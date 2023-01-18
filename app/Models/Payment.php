<?php

namespace ShellaiDev\Models;

use JetBrains\PhpStorm\NoReturn;
use Output;
use PDO;
use ShellaiDev\Config;
use ShellaiDev\Models\Parent\Model;
use ShellaiDev\Models\System\Base;
use ShellaiDev\Models\System\DB;
use Thedudeguy\Rcon;

class Payment extends Model {

    private Entity $entity;

    private $isSurcharge = false;

    public function __construct(Entity $entity){
        $this->entity = $entity;
    }

    public function isSurchageAllowed(){
        return $this->isSurcharge;
    }

    public function create(){
        $price = $this->entity->calcPrice();

        $isCustomItem = false;
        if ( strpos(Config::$configs['items'][ $this->params['item'] ]['rule'], 'group') === false ) $isCustomItem = true;

        if( !$isCustomItem ){
            $surcharge = $this->calcSurcharge();

            if($surcharge == -1) return Output::genAnswer('error', 'Нельзя приобрести привилегию ниже рангом от Вашей текущей!');
            if($this->isSurcharge) $price = $surcharge;
        }

        $data = [
            'login' => $this->params['login'],
            'sum' => $price,
            'date' => date('Y-m-d H:i:s'),
            'payment_type' => $this->params['payment_type'],
            'item_id' => intval($this->params['item']),
            'server_id' => intval($this->params['server']),
            'status' => 0
        ];

        $inserted = DB::$database->payments->insertOne($data);

        if( $inserted->getInsertedCount() > 0 ){
            $data['id'] = $inserted->getInsertedId();
            return $data;
        }

        return false;
    }

    public function createDonation(){
        $data = [
            'login' => $this->params['login'],
            'sum' =>  $this->params['sum'],
            'date' => date('Y-m-d H:i:s'),
            'payment_type' => $this->params['payment_type'],
            'is_donate' => 1,
            'status' => 0
        ];

        $inserted = DB::$database->payments->insertOne($data);

        if( $inserted->getInsertedCount() > 0 ){
            $data['id'] = $inserted->getInsertedId();
            return $data;
        }

        return false;
    }

    public function getById($id){
        return DB::$database->payments->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
    }

    public function updatePayment($payment, $status){
        $updated = DB::$database->payments->updateOne(
            ['_id' => $payment->_id],
            [ '$set' => ['status' => $status] ]
        );

        return $updated->getModifiedCount() > 0;
    }

    public function processRCON(){
        $server = $this->params['payment']->server_id;
        $item = $this->params['payment']->item_id;

        $command = Config::$configs['items'][$item]['rule'];
        if(strpos($command, '%player%') !== false){
            $command = str_replace('%player%', $this->params['payment']->login, $command);
        }

        $rcon = new Rcon(Config::$configs['servers'][$server]['rcon']['ip'], Config::$configs['servers'][$server]['rcon']['port'], Config::$configs['servers'][$server]['rcon']['pass'], 15);

        if( !$rcon->connect() ) return false;

        $rcon->sendCommand( $command );

        return true;
    }

    public function processDatabase(){
        $item = $this->params['payment']->item_id;

        $offlineUUID = UUID::offlineUUID($this->params['payment']['login']);
        $bindataUUID = UUID::fromUUID($offlineUUID);

        $userPerm = DB::$server['database']->luckperms_users->findOne(["_id" => $bindataUUID]);

        $permission = [
            'key' => Config::$configs['items'][$item]['rule'],
            'value' => true,
        ];

        $ruleDetailed = explode('.', $permission['key']);

        $context = Config::$configs['items'][$item]['lp_context'];

        if( !empty($context) ) {
            $context = explode("=", $context);

            $permission['context'] = [
                ['key' => $context[0], 'value' => $context[1]]
            ];
        }

        if($userPerm == null) {

            $user = DB::$server['database']->luckperms_uuid->findOne(['_id' => $bindataUUID]);
            if($user == null) {
                // Insert into Luckperms uuid
                $inserted = DB::$server['database']->luckperms_uuid->insertOne(
                    [
                        '_id' => $bindataUUID,
                        'name' => strtolower($this->params['payment']['login'])
                    ]
                );
        
                if($inserted->getInsertedCount() < 1) return Output::genAnswer('error', '[Ошибка 1] Не удалось выдать товар. Обратитесь к администрации!');
            }

            $insertedPerm = DB::$server['database']->luckperms_users->insertOne(
                [
                    '_id' => $bindataUUID,
                    'name' => strtolower($this->params['payment']['login']),
                    'primaryGroup' => empty($context) ? $ruleDetailed[1] : 'default',
                    'permissions' => [
                        $permission
                    ]
                ]
            );
        
            if($insertedPerm->getInsertedCount() < 1) return Output::genAnswer('error', '[Ошибка 2] Не удалось выдать товар. Обратитесь к администрации!');
        } else {
            // Clear all groups (Only for `groups` rule. Example, `group.vip`)
            if( strcmp($ruleDetailed[0], 'group') === 0 ) {
                $groupsToClear = $this->getGroupsToClear($userPerm);

                if( !empty($groupsToClear) ) {

                    $keyRule = [
                        'key' => ['$in' => array_values($groupsToClear)]
                    ];

                    if( empty($context) ){
                        $keyRule['context'] = ['$exists' => false];
                    } else {
                        $keyRule['context'] = [
                            '$elemMatch' => [
                                'key' => $context[0],
                                'value' => $context[1]
                            ]
                        ];

                    }

                    DB::$server['database']->luckperms_users->updateMany(
                        ['_id' => $bindataUUID],
                        [
                            '$pull' =>  ['permissions' =>  $keyRule]
                        ]
                    );
                }
            }

            // Add permission
            $permission = [
                '$push' => ['permissions' => $permission]
            ];

            // If no context needed, update primaryGroup (According to LuckPerms Documentation)
            if( empty($context) ) {
                $permission['$set'] = ['primaryGroup' => $ruleDetailed[1]];
            }

            $inserted = DB::$server['database']->luckperms_users->updateOne(
                ['_id' => $bindataUUID],
                $permission
            );

            if($inserted->getModifiedCount() < 1) return Output::genAnswer('error', '[Ошибка 3] Не удалось выдать товар. Обратитесь к администрации!');
        }

        return true;
    }

    private function getGroupsToClear($permissions){
        $groupsToClear = [];
        foreach($permissions->permissions as $key => $value) {
            if( strpos($value->key, 'group') !== false ){
                $groupPermission = explode('.', $value->key);
                // If group is present in whitelist, skip.
                if( in_array($groupPermission[1], Config::WHITELIST_PRIVILEGES) ) continue;
                array_push($groupsToClear, $value->key);
            }
        }

        return array_unique($groupsToClear);
    }

    public function calcSurcharge(){
        $availablePrivileges = $this->entity->getPrivilegesForDatabase();

        if( count($availablePrivileges) < 1 ) return 0;

        $item = [
            'priority' => $availablePrivileges[$this->params['item']]['priority'],
            'context' => $availablePrivileges[$this->params['item']]['lp_context'],
            'rule' => $availablePrivileges[$this->params['item']]['rule'],
            'price' => $this->entity->getSale($this->params['item'])
        ];

        $price = $this->entity->calcPrice();

        $offlineUUID = UUID::offlineUUID($this->params['login']);
        $bindataUUID = UUID::fromUUID($offlineUUID);

        $userPerm = DB::$server['database']->luckperms_users->findOne(["_id" => $bindataUUID]);
        if($userPerm == null) return $price;
        
        $andAggregation = [];
        $andAggregation[1] = "";

        if( !empty($item['context']) ) {
            $_context = explode("=", $item['context']);

            $andAggregation[0] = '$$p.context';
            $andAggregation[1] = [
                '$eq' => [
                    '$$p.context',
                    [
                        [
                            'key' => $_context[0],
                            'value' => $_context[1],
                        ]
                    ]
                ]
            ];
        } else {
            $andAggregation[0] = [
                '$lte' => [
                    '$$p.context',
                    'null'
                ]
            ];
        }

        $groups = DB::$server['database']->luckperms_users->aggregate([
            [
                '$match' => ["_id" => $bindataUUID]
            ],
            [
                '$set' => [
                    'permissions' => [
                        '$filter' => [
                            'input' => '$permissions',
                            'as' => 'p',
                            'cond' => [
                                '$and' => [
                                    [
                                        '$regexMatch' => [
                                            'input' => '$$p.key',
                                            'regex' => 'group'
                                        ]
                                    ],
                                    $andAggregation[0],
                                    $andAggregation[1],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ])->toArray();

        if( $groups == null || empty($groups) || empty($groups[0]['permissions'])) return $price;

        $filteredGroups = [];

        // Filter for available groups from config
        foreach(Config::$configs['items'] as $key => $value){
            if( strpos($value['rule'], 'group') !== false ) {
                if( !empty($item['context']) && strcmp($value['lp_context'], $item['context']) !== 0 ) continue;
                $filteredGroups[$key] = $value;
            }
        }

        if( empty($filteredGroups) ) return -1;

        // Found current groups in filtered config 
        $privilegesToCheck = [];
        $filteredGroupsRules = array_column($filteredGroups, 'rule');
        foreach($groups[0]['permissions'] as $group){
            $privilegeName = (explode('.', $group->key))[1];
            if( in_array($privilegeName, Config::WHITELIST_PRIVILEGES) ||
                !in_array($group->key, $filteredGroupsRules)
            ) continue;
            array_push($privilegesToCheck, $group);
            break;  // Because, only one privilege from shop user will have!
        }

        if( empty($privilegesToCheck) ) return $price;

        $group = $privilegesToCheck[0]->key;

        $currentContext = $privilegesToCheck[0]->context ?? null;
        if($currentContext != null){
            $currentContext = $currentContext[0]->key . "=" . $currentContext[0]->value;
        }

        // Find user's existing privilege in config
        $index = -1;    // Index of privilege in config
        foreach( $filteredGroups as $key => $value){
            if( strcmp($value['rule'], $group) === 0 ){
                
                if( !empty($item['context']) ) {
                    if($currentContext == null) {
                        $index = -1;
                        break;
                    }

                    if( strcmp($value['lp_context'], $currentContext) === 0 ) {
                        $index = $key;
                        break;
                    }

                } else {
                    $index = $key;
                    break;
                }
            }
        }

        if($index == -1) return $price;
        
        // If there is no privilege set, can't buy it
        $currentPriority = Config::$configs['items'][$index]['priority'] ?? null;
        if($currentPriority == null) return -1;

        // If current privilege has greater priority, than a new privilege
        if($currentPriority > $item['priority']) return -1;

        // Price of current user's privilege
        $currentPrice = $this->entity->getSale($index);

        $calcPrice = $price - $currentPrice;

        $this->isSurcharge = true;

        return $calcPrice <= 0 ? $price : $calcPrice;
    }

}

?>
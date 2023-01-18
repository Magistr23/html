<?php

namespace ShellaiDev\Models;

use Output;
use ShellaiDev\Config;
use ShellaiDev\Models\Parent\Model;
use ShellaiDev\Models\System\Base;
use ShellaiDev\Models\System\DB;

class Entity extends Model {

    /** Calc item's price  */
    public function calcPrice(){
        $price = $this->getSale($this->params['item']);
        if( isset($this->params['promo']) && array_key_exists($this->params['promo'], Config::PROMOCODES) ){
            $price = $price * (1 - (Config::PROMOCODES[$this->params['promo']] / 100) );
        } 
        return $price;
    }

    /** Is item valid? */
    public function isItemValid(){
        return array_key_exists($this->params['item'], Config::$configs['items']);
    }

    /** Check if item is supporting server */
    public function isServerSupported(){
        return in_array($this->params['server'], Config::$configs['items'][ $this->params['item'] ]['server_id'] );
    }

    /* Check if user can buy privileges */
    public function canBuyPrivilege(){
        if ( strpos(Config::$configs['items'][ $this->params['item'] ]['rule'], 'group') === false ) return true;

        $offlineUUID = UUID::offlineUUID($this->params['login']);
        $bindataUUID = UUID::fromUUID($offlineUUID);

        $userPerm = DB::$database->luckperms_users->findOne(
            ["_id" => $bindataUUID]
        );

        if($userPerm == null) return true;

        $allItems = $this->getlLuckPermsPrivileges();
        if( empty($allItems) ) return true;

        $customItem = false;
        foreach($userPerm->permissions as $value){
            $privilegeName = (explode('.', $value->key))[1];
            if( !in_array($value->key, $allItems)
                && !in_array($privilegeName, Config::WHITELIST_PRIVILEGES)
                && strpos($value->key, 'group') !== false
                && strpos($value->key, 'group.default') === false
            ) {
                $customItem = $value->key; 
            }
        }

       return !$customItem ? true : false;
    }

    /* Get all items from config */
    public function getlLuckPermsPrivileges(){
        $luckpermsGroups = $this->getPrivilegesForDatabase();
        
        $groupPerms = [];
        foreach($luckpermsGroups as $key => $value){
            $groupPerms[] = $value['rule'];
            //$groupPerms[$key]['name'] = $value['name'];
        }

        return $groupPerms;
    }
    
    /* Get all privileges from config by `driver` => `database` */
    public function getPrivilegesForDatabase(){
        return array_filter(Config::$configs['items'], function($item){
            return strcmp($item['driver'], 'database') === 0;
        });
    }

    /* Get price with sale */
    public function getSale($item){
        return Config::$configs['items'][$item]['sale_price'] > 0 ? Config::$configs['items'][$item]['sale_price'] : Config::$configs['items'][$item]['price'];
    }

    /* Save into commands */
    public function saveCommands(){
        $context = Config::$configs['items'][$this->params['item_id']]['lp_context'];
        $rule = Config::$configs['items'][$this->params['item_id']]['rule'];
        
        if( empty($context) ) $context = 'global';
        $cmd = $rule .','.$context;

        return DB::$server['mysql']->insert('commands',
            [
                'name' => $this->params['login'],
                'cmd' => $cmd,
                'active' => 1
            ]
        );
    }

}

?>
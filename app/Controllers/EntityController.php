<?php

namespace ShellaiDev\Controllers;

use ShellaiDev\Config;
use ShellaiDev\Controllers\Parent\Controller;
use ShellaiDev\Models\Entity;
use ShellaiDev\Models\System\Security;

class EntityController extends Controller {

    private Entity $entity;

    public function __construct(){
        parent::__construct();

        $this->entity = new Entity();
        $this->entity->setParams($this->request);
    }

    public function getItems(){
        $items = array_filter(Config::$configs['items'], function($item){
            return in_array($this->request['category'], $item['category_id']);
        });

        $items = array_map(function($item){
            return Security::whitelistedKeys($item, ['name', 'price', 'sale_price', 'img', 'descr']);
        }, $items);

        \Output::printJsonAnswer('success', $items);
    }

    public function itemInfo(){
        if( !array_key_exists($this->request['id'], Config::$configs['items']) ) \Output::printJsonAnswer('error', 'No item found!');
        
        $info = Security::whitelistedKeys(Config::$configs['items'][$this->request['id']], ['name', 'price', 'sale_price', 'img', 'descr', 'description_full']);
        
        \Output::printJsonAnswer('success', $info);
    }

}

?>
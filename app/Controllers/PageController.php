<?php

namespace ShellaiDev\Controllers;

use ShellaiDev\Config;
use ShellaiDev\Controllers\Parent\Controller;
use ShellaiDev\Models\Monitoring;
use ShellaiDev\Models\System\File;
use ShellaiDev\Models\System\Page;
use ShellaiDev\Models\System\Security;


class PageController extends Controller {

    public function __construct(){
        parent::__construct();

        $this->data = [ 'csrf_token' => Security::getCsrfToken() ];
    }

    /* Show main page */
    public function pageIndex(){
       /*  $monitoring = new Monitoring(); */

        $items = array_filter(Config::$configs['items'], function($item){
            return in_array(0, $item['category_id']);
        });

        $sales = array_filter(Config::$configs['items'], function($item){
            return $item['sale_price'] > 0;
        });
        $keys = array_keys($sales);
        shuffle($keys);
        $shuffledSales = [];
        foreach ($keys as $key){
            $shuffledSales[$key] = $sales[$key];
        }

        $this->fillData([
            'categories' => Config::$configs['categories'],
            'items' => $items,
           /*  'online' => $monitoring->checkMon(), */
            'sales' => $shuffledSales
        ]);

        File::includeFileWith(TPL_DIR."/pages/index.php", $this->data);
    }

    /* Show rules page */
    public function pageRules(){
        File::includeFileWith(TPL_DIR."/pages/rules.php", $this->data);
    }

    /* Show donate page */
    public function pageDonate(){
        File::includeFileWith(TPL_DIR."/pages/donate.php", $this->data);
    }

    /* Show vote page */
    public function pageVote(){
        File::includeFileWith(TPL_DIR."/pages/vote.php", $this->data);
    }

    /* Show contacts page */
    public function pageContacts(){
        File::includeFileWith(TPL_DIR."/pages/contacts.php", $this->data);
    }

    /* Display custom page */
    public function customPage(){
        $this->fillData([
            'params' => $this->request['custom_params']
        ]);
        File::includeFileWith(TPL_DIR."/pages/{$this->request['custom_params']['page']}.php", $this->data);
    }

    /** Success message after payment */
    public function success(){
        Page::redirectWithMessage('', 'success', 'Оплата прошла успешно!');
    }
}

?>
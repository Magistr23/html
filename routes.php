<?php

/***
 * Роутер сайта
 */

if( !defined('SHELLAIDEV_AUTODONATE_2022') ) die('Hacking attempt!');

return [
    /* Главная страница сайта */
    'index' => ['ShellaiDev\Controllers\PageController@pageIndex', ['method' => 'GET'] ],
    /* Страница "Правила" */
    'rules' => ['ShellaiDev\Controllers\PageController@pageRules', ['method' => 'GET'] ],
    /* Страница "Донат" */
    'donate' => ['ShellaiDev\Controllers\PageController@pageDonate', ['method' => 'GET'] ],
    /* Страница "Голосование" */
    'vote' => ['ShellaiDev\Controllers\PageController@pageVote', ['method' => 'GET'] ],
    /* Страница "Контакты" */
    'contacts' => ['ShellaiDev\Controllers\PageController@pageContacts', ['method' => 'GET'] ],

    /* Отображение предметов по категории */
    'show/items' => ['ShellaiDev\Controllers\EntityController@getItems', ['method' => 'POST'] ],
    /* Отображение онлайна */
    'mon/check' => ['ShellaiDev\Controllers\MonitoringController@check', ['method' => 'POST'] ],
    /* Информация о предмете */
    'item/info' => ['ShellaiDev\Controllers\EntityController@itemInfo', ['method' => 'POST'] ],
    
    /* Создание платежа */
    'payment/create' => ['ShellaiDev\Controllers\PaymentController@createPayment', ['method' => 'POST'] ],
    /* Проверка платежа */
    'payment/process' => ['ShellaiDev\Controllers\PaymentController@processPayment', ['method' => 'REQUEST'] ],
    /* Уведомление об успешном платеже */
    'payment/success' => ['ShellaiDev\Controllers\PageController@success', ['method' => 'REQUEST'] ],
    /* Уведомление об успешном платеже для YooKassa */
    'payment/yookassa/success' => ['ShellaiDev\Controllers\PageController@success', ['method' => 'REQUEST'] ],

    /* Пожертвование */
    'payment/donate' => ['ShellaiDev\Controllers\PaymentController@donate', ['method' => 'POST'] ],

    /* Проверка промокода */
    'promo/check' => ['ShellaiDev\Controllers\PaymentController@checkPromo', ['method' => 'POST'] ],
    /* Проверка промокода */
    'price/check' => ['ShellaiDev\Controllers\PaymentController@checkPrice', ['method' => 'POST'] ],


    /* Тестовая страница */
    //    'test' => ['ShellaiDev\Controllers\PageController@customPage', ['method' => 'GET'], ['page' => 'test'] ],
];

?>
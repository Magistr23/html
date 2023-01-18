<?php

/**
 * Главный конфиг сайта
 */
namespace ShellaiDev;

if( !defined('SHELLAIDEV_AUTODONATE_2022') ) die('Hacking attempt!');

class Config {

    /**  Включен ли дебаг сайта? (false/true)
     * Ставить `false`, если не требуется тестирование
     */
    const DEBUG_ENABLED = true;

    /** Есть ли сертификат у сайта от Cloud? (Полезно, если SSL не установлен напрямую и стоит на каком-то Cloud. Например, cloudflare) */
    const HAS_SSL = false;

    /** Папка сайта (Оставить пустым, если сайт лежит в корневой папке хоста) */
    const SITE_DIR = '';

    /** Настройки подключения к MongoDB сайта */
    const MONGODB = [
        'host' => 'localhost',  // Хост
        'user' => 'root', // Пользователь
        'pass' => 'rDbxaPmTUHfJtD3JRd8Ku5jZ',  // Пароль
        'database' => 'admin', // База данных
        'port' => 27017    // Порт
    ];

    /** Мониторинг */
    const MONITORING = [
        'ip' => '127.0.0.1', // IP сервера для мониторинга
        'port' => 25565, // Порт сервера для мониторинга
    ];

    /** Промокоды на скидку (Скидка в %) [Процент на скидку]
     * Формат: 'ПРОМОКОД' => 'ПРОЦЕНТ_СКИДКИ', 'ПРОМОКОД' => 'ПРОЦЕНТ_СКИДКИ', ...
    */
    const PROMOCODES = [
        'dasdqwwd' => 10,
        'qwerty' => 5
    ];

    /** Qiwi */
    const QIWI = [
        'public_key' => '',
        'secret_key' => '',
        'success_url' => 'https://megacraft.org/payment/success'
    ];

    /** YooKassa */
    const YOOKASSA = [
        'id' => '111',
        'secret_key' => 'qwerty',
        'success_url' => 'https://megacraft.org/payment/process?payment_type=yookassa'
    ];

    /** Whitelist привилегий, которые не будут удаляться при покупке новой */
    const WHITELIST_PRIVILEGES = [
        'admin', 'moder', 'helper'
    ];

    /*****************************/
    /****** НИЖЕ НЕ ТРОГАТЬ ******/
    /*****************************/
    public static $configs = [];
    public static function parseConfigs(){
        self::$configs['categories'] = include_once 'config/categories.php';    // Категории
        self::$configs['servers'] = include_once 'config/servers.php';  // Сервера
        self::$configs['items'] = include_once 'config/items.php';  // Предметы
    }
}

?>
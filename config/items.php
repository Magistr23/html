<?php

/**
 * | Товар |
 *
 * Формат: ID => [ ПАРАМЕТРЫ ]
 * ID не должен дублироваться в текущем файле!
 */

return [
    // VIP
    [
        'name' => 'VIP',    // Название
        'price' => 30,     // Цена
        'sale_price' => 25,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/vip.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/vip.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0, 2],     // ID категорий из `/config/categories.php` (можно указывать через запятую внутри [], если товар находится в нескольких категориях одновременно) |Для навигации|
        'server_id' => [0],       // ID серверов из `/config/servers.php` (можно указывать через запятую внутри [], если товар доступен на наскольких серверах)

        'driver' => 'database',     // Способ получения товара (`rcon` - для RCON выдачи, `database` - для хранения в базе данных)
        'type' => 'permission',          // Тип товара:
        // `permission` - право/группа в LuckPerms !! (ТОЛЬКО ПРИ 'driver' => 'database');
        // `command` - команда для выполнения !! (ТОЛЬКО ПРИ 'driver' => 'rcon');

        'lp_context' => 'server=test2',  // Контекст для LuckPerms, если способ получения товара - 'driver' => 'database';
        // Оставить 'lp_context' => '', если контекст не используется;
        // Формат 'ключ=значение'. Например, 'server=test' ;

        /**
         * (ТОЛЬКО ДЛЯ 'driver' => 'database')
         * При 'type' => 'permission' здесь указывается конкретное правило LuckPerms (Например, group.vip);
         * -----------------------------------------------------------------------------
         * (ТОЛЬКО ДЛЯ 'driver' => 'rcon')
         * При 'type' => 'command' здесь указывается команда для выдачи конкретного правила (Например, money add %player% 500);
         * -----------------------------------------------------------------------------
         * Специальная переменная %player% подставляет логин игрока, который покупает предмет!
         */
        'rule' => 'group.vip',

        // Описание (Поддерживаются HTML-тэги)
        'descr' => 'Ваш префикс: [ Вип ] ваш_никмейм<br/>
                    Полёт /fly<br/>
                    Режим бога /god<br/>
                    Кит VIP /kit vip<br/>
                    Больше приватов!<br/>
                    * Очистка инвентаря /clear ДР.<br/>
                    Возможность входа на заполненный сервер<br/>
                    /dmeny- меню донатера<br/>
                    /CityWorld - доступ к городу Админам<br/>
                    d - донатный чат<br/>
                    /join - изменять сообщение при входе<br/>
                    Волк питомец<br/>
                    Команда для питомцев /Pet<br/>
                    Эффект сердечки /trails<br/>
                    Эффект сферы при убийстве<br/>
                    Эффекты при убийстве - /effectkill open<br/>',

        'priority' => 1 // Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Premium
    [
        'name' => 'Премиум',    // Название
        'price' => 69,     // Цена
        'sale_price' => 50,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/premium.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/premium.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0, 1],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Премиум] ваш_никнейм<br/>
                    Починка вещей /repair<br/>
                    Кит Премиума /kit Premium<br/>
                    Возвращение при смерти или просто /back<br/>
                    Запуск фейерверков! /firework.<br/>
                    Возможность писать в чат цветным текстом!<br/>
                    •Своё время /ptime<br/>
                    * Несколько домов и больше приватов<br/>
                    Дюп /more<br/>
                    Питомец Волк, Курица<br/>
                    команда для питомцев /pet<br/>
                    Зффект злость /trails<br/>
                    + Все возмохности предыдущих групп!<br/>',

        'priority' => 2 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Creative
    [
        'name' => 'Креатив',    // Название
        'price' => 95,     // Цена
        'sale_price' => 80,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/creative.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/creative.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0, 1],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Креатив] ваш_никнейм<br/>
                    Креатив режим /gm 1<br/>
                    Переход в другие режимы /gm 0,1.2,3<br/>
                    Гитонец Волк, Курица, Свинья<br/>
                    Команда для питомцев /pet<br/>
                    *Эффект Магия /trails<br/>
                    Все возножности предыдущих групп!<br/>',

        'priority' => 3 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Moder
    [
        'name' => 'Модератор',    // Название
        'price' => 145,     // Цена
        'sale_price' => 145,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/moder.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/moder.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Модер] ваш-никнейм<br>
                    Муты /tempmute<br>
                    Баны /tempban<br>
                    Изменение инвентаря игроков /invsee<br>
                    Поджёг /burn и /ext тушить<br>
                    /kick - кикнуть игрока<br>
                    Писать объявления! /broadcast<br>
                    ТЕЛЕПОРТАЦИЯ /tp<br>
                    Смена спавнеров /spawner<br>
                    Писать на табличках цветными буквами!<br>
                    /join - больше различных сообщений при входе<br>
                    Питомец: Волк, Курциа, Свинья, Корова<br>
                    Команда для питомцев /pet<br>
                    Эффект цвета /trails<br>
                    Все возможности предыдущих групп!<br>',

        'priority' => 4 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Admin
    [
        'name' => 'Админ',    // Название
        'price' => 195,     // Цена
        'sale_price' => 180,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/admin.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/admin.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Админ] ваш_никнейм<br>
                    Выдача вещей /give<br>
                    /ban - бан НАВСЕГДА!<br>
                    Установка любых флагов WorldGuard!<br>
                    Выдача игрокам или себе опыта /exp<br>
                    Кит Админа /kit admin<br>
                    /sell hand - продать предмет в руке<br>
                    /rainbow - радужная броня<br>
                    Цветовые коды в донат чате<br>
                    /join - больше различных сообщений при входе<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Команда для питомцев /pet<br>
                    Эффект облака /trails и звезды при убийстве<br>
                    Купить себе байк (мотоцикл)!<br>
                    А так же ездить на нем! /bikeShop<br>
                    Транспорт - /transport<br>
                    Все возможности предыдущих групп!<br>',

        'priority' => 5 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Lord
    [
        'name' => 'Лорд',    // Название
        'price' => 285,     // Цена
        'sale_price' => 285,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/lord.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/lord.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Лорд] ваш_никнейм<br>
                    Выдача другим игрокам /god и /fly<br>
                    Зачарование на любой уровень /enchant<br>
                    Доступ к первому ряду суффиксов /suffix<br>
                    Бесконечное кол-во домов!<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот<br>
                    Команда для питомцев /pet<br>
                    Эффект магия ведьмы /trails<br>
                    Купить себе тачку (машину)!<br>
                    А также ездить на ней! /carShop<br>
                    Все возможности предыдущих групп!<br>',

        'priority' => 6 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // gladmin
    [
        'name' => 'Главный Админ',    // Название
        'price' => 450,     // Цена
        'sale_price' => 399,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/gladmin.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/gladmin.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Описание доната: [Гл. Админ] ваш_никнейм<br>
                    Использование /speed !<br>
                    Убийство игроков /kill !<br>
                    Бесконечные деньги /eco и выдача их другим!<br>
                    /enchant all - наложить все чары на 5 лвл!<br>
                    Установить цвет текста в чате /colors<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца<br>
                    Команда для питомцев /pet<br>
                    Эффект эндер /trails<br>
                    Купить себе настоящий поезд!<br>
                    А так же ездить на нем! /trainshop<br>
                    Эффект взрывы при убийстве!<br>
                    Все возможности предыдущих групп!',

        'priority' => 7 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Operator
    [
        'name' => 'Оператор',    // Название
        'price' => 555,     // Цена
        'sale_price' => 500,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/oper.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/oper.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Оператор] ваш_никнейм<br>
                    Выдача вам прав Оператора<br>
                    Доступ ко многим командам!<br>
                    Ставить варпы /setwarp<br>
                    Менять ник /nick<br>
                    Отходить /afk<br>
                    Меня время /time и погоду /weather<br>
                    Новое оружие KILLER v.228 /guns<br>
                    Доступ ко второму ряду суффиксов /suffix<br>
                    /join - больше различных сообщений при входе<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца, Грибная корова<br>
                    Команда для питомцев /pet<br>
                    Эффект зеленый /trails<br>
                    Купить себе плот (есть пиратский)!<br>
                    А так же плавать на нем! /raftShop<br>
                    Все возможности предыдущих групп!<br>',

        'priority' => 8 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Creator
    [
        'name' => 'Создатель',    // Название
        'price' => 675,     // Цена
        'sale_price' => 675,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/creator.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/creator.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Создатель] ваш_никнейм<br>
                    Сделать реальный ник /realname<br>
                    /tnt /thor<br>
                    Большинство команд Essentials и WorldGuard<br>
                    Вы отображаетесь в списке контактов вк<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца, Грибная корова, Зомби<br>
                    Команда для питомцев /pet<br>
                    Эффект искры /trails<br>
                    Купить себе настоящий самолёт!<br>
                    А так же летать на нем /planeShop<br>
                    Эффект заморозка при убийстве<br>
                    Все возможности предыдущих групп!',
        'priority' => 9 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Owner
    [
        'name' => 'Основатель',    // Название
        'price' => 855,     // Цена
        'sale_price' => 855,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/owner.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/owner.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Основатель] ваш_никнейм<br>
                    Доступ в приваты, ломать сундуки!<br>
                    Бесконечные регионы!<br>
                    Возможность менять префикс /prefix<br>
                    Статус формального со-владельца проекта<br>
                    Вы добавляетесь в админ-конфу в скайпе!<br>
                    Больше прав в группе<br>
                    /join - больше различных сообщений при входе<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца, Грибная корова, Зомби, Скелет<br>
                    Команда для питомцев /pet<br>
                    Эффект огонь /trails<br>
                    Купить себе парашют!<br>
                    А так же прыгать с ним! /parachuteShop<br>
                    Все возможности предыдущих групп!',
        'priority' => 10 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Vladelec
    [
        'name' => 'Владелец',    // Название
        'price' => 999,     // Цена
        'sale_price' => 999,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/vl.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/vl.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Владелец] ваш_никнейм<br>
                    Доступ к огромному количеству команд<br>
                    Можно зайти и контролировать всё!<br>
                    на сервере вы - Царь!<br>
                    /unban /unmute - снятие бана и мута!<br>
                    /banip /tempbanip - бан по IP!<br>
                    Новое оружие Самотык /guns<br>
                    /join - больше различных сообщений при входе<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца, Грибная корова, Зомби, Скелет<br>
                    Паук<br>
                    Команда для питомцев /pet<br>
                    ВСЕ эффекты частиц /trails<br>
                    Купить себе настоящий вертолет!<br>
                    И летать на нем! /helicopterShop<br>
                    Эффект сатана при убийстве<br>
                    Все возможности предыдущих групп!',
        'priority' => 11 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // Анти-Грифер
    [
        'name' => 'Анти-Грифер',    // Название
        'price' => 1065,     // Цена
        'sale_price' => 1065,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/ag.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/ag.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [Игрок] ваш_никнейм<br>
                    Доступ к улучшенному ванишу<br>
                    /tptoggle<br>
                    /tabag - поставить префикс как у игрока<br>
                    /tabclear - поставить стандартный так префикс<br>
                    Не видно в табе и при входе<br>
                    Префикс игрока!<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца, Грибная корова, Зомби, Скелет<br>
                    Паук, Голем<br>
                    Команда для питомцев /pet<br>
                    ВСЕ эффекты частиц и блоков /trails<br>
                    Купить себе настоящий ТАНК!<br>
                    И так же ездить на нем ХОТЬ где! /tankShop<br>
                    Все возможности предыдущих групп!',
        'priority' => 12 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // БОГ
    [
        'name' => 'БОГ',    // Название
        'price' => 1459,     // Цена
        'sale_price' => 1459,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/god.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/god.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [БОГ] ваш_никнейм<br>
                    Доступ к консоли сервера<br>
                    За получением обращаться в лс группы<br>
                    /shead ник - голову по нику из лицензии<br>
                    /afk сообщение - сменить сообщение когда<br>
                    игроки пишут вам в лс и вы в это время /afk<br>
                    Ещё больше суффиксов /suffix и стилей в чате /colors<br>
                    Можно будет много всего делать! Лучшее, что может быть ;)!<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца, Грибная корова, Зомби, Скелет<br>
                    Паук, Голем, Странник края<br>
                    Команда для питомцев /pet<br>
                    ВСЕ эффекты частиц, блоков, дождя /trails<br>
                    Купить себе субмарину (подводную лодку)!<br>
                    А так же плавать на ней ХОТЬ где! /submarineShop<br>
                    Все возможности предыдущих групп!',
        'priority' => 13 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // БИГ БОСС
    [
        'name' => 'БОЛЬШОЙ БОСС',    // Название
        'price' => 1957,     // Цена
        'sale_price' => 1957,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/donate/bb.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/donate/bb.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [0],
        'server_id' => [0],

        'driver' => 'database',
        'type' => 'permission',
        'lp_context' => 'server=test2',
        'rule' => 'group.premium',
        'descr' => 'Префикс: [БОЛЬШОЙ БОСС] ваш_никнейм<br>
                    Самая крутая привилегия на сервере!<br>
                    СПЕЦ-ПРЕДЛОЖЕНИЕ, продажа может остановиться<br>
                    в любой момент! Всего осталось 3 БОССА!<br>
                    Доступ к Супер-Консоли сервера, обращаться в ЛС группы!<br>
                    /magic выдать себе магическую палку на 1000лвл<br>
                    /tppos телепорт по координатам<br>
                    /autodrop present - автоматическая раздача подарков!<br>
                    /autodrop standart - автоматическая раздача вещей!<br>
                    Питомец Волк, Курица, Свинья, Корова, Лошадь<br>
                    Оцелот, Овца, Грибная корова, Зомби, Скелет<br>
                    Паук, Голем, Странник края, Команда /pet<br>
                    Добавлен эффект крыльев!<br>
                    ВСЕ эффекты какие только есть /trails<br>
                    Купить себе настоящую волшебную метлу!<br>
                    А так же летать на ней ХОТЬ где! /broomShop<br>
                    Все возможности предыдущих групп!',
        'priority' => 14 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],








    //

    // 500 монет
    [
        'name' => '500 Монет',    // Название
        'price' => 500,     // Цена
        'sale_price' => 1,  // Цена со скидкой
        'img' => [
            'default' => 'template/assets/images/case.png',    // URL картинки для отображения в списке товаров
            'big' => 'template/assets/images/case.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [1],     // ID категорий из `/config/categories.php` (можно указывать через запятую внутри [], если товар находится в нескольких категориях одновременно) |Для навигации|
        'server_id' => [0],       // ID серверов из `/config/servers.php` (можно указывать через запятую внутри [], если товар доступен на наскольких серверах)

        'driver' => 'rcon',     // Способ получения товара (`rcon` - для RCON выдачи, `database` - для хранения в базе данных)
        'type' => 'command',          // Тип товара:
        // `permission` - право в LuckPerms !! (ТОЛЬКО ПРИ 'driver' => 'database');
        // `command` - команда для выполнения !! (ТОЛЬКО ПРИ 'driver' => 'rcon');

        'lp_context' => 'server=main',  // Контекст для LuckPerms, если способ получения товара: 'driver' => 'database';
        // Оставить 'lp_context' => '', если контекст не используется;
        // Формат 'ключ=значение'. Например, 'server=test' ;

        /**
         * (ТОЛЬКО ДЛЯ 'driver' => 'database')
         * При 'type' => 'permission' здесь указывается конкретное правило LuckPerms (Например, group.vip);
         * -----------------------------------------------------------------------------
         * (ТОЛЬКО ДЛЯ 'driver' => 'rcon')
         * При 'type' => 'command' здесь указывается команда для выдачи конкретного правила (Например, money add %player% 500);
         * -----------------------------------------------------------------------------
         * Специальная переменная %player% подставляет логин игрока, который покупает предмет!
         */
        'rule' => 'say Hello %player%',

        // Описание (Поддерживаются HTML-тэги)
        'descr' => 'Lorem Ipsum является текст-заполнитель обычно используется в графических, печать и издательской индустрии для предварительного просмотра макета и визуальных макетах.<br><br> <b>Beautiful!</b>',

        'priority' => 3 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // 500 монет
    [
        'name' => '500 Монет',    // Название
        'price' => 500,     // Цена
        'sale_price' => 1,  // Цена со скидкой
        'img' => [
            'default' => 'https://megacraft.org/template/assets/images/case.png',    // URL картинки для отображения в списке товаров
            'big' => 'https://megacraft.org/template/assets/images/case.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [1],     // ID категорий из `/config/categories.php` (можно указывать через запятую внутри [], если товар находится в нескольких категориях одновременно) |Для навигации|
        'server_id' => [0],       // ID серверов из `/config/servers.php` (можно указывать через запятую внутри [], если товар доступен на наскольких серверах)

        'driver' => 'rcon',     // Способ получения товара (`rcon` - для RCON выдачи, `database` - для хранения в базе данных)
        'type' => 'command',          // Тип товара:
        // `permission` - право в LuckPerms !! (ТОЛЬКО ПРИ 'driver' => 'database');
        // `command` - команда для выполнения !! (ТОЛЬКО ПРИ 'driver' => 'rcon');

        'lp_context' => 'server=main',  // Контекст для LuckPerms, если способ получения товара: 'driver' => 'database';
        // Оставить 'lp_context' => '', если контекст не используется;
        // Формат 'ключ=значение'. Например, 'server=test' ;

        /**
         * (ТОЛЬКО ДЛЯ 'driver' => 'database')
         * При 'type' => 'permission' здесь указывается конкретное правило LuckPerms (Например, group.vip);
         * -----------------------------------------------------------------------------
         * (ТОЛЬКО ДЛЯ 'driver' => 'rcon')
         * При 'type' => 'command' здесь указывается команда для выдачи конкретного правила (Например, money add %player% 500);
         * -----------------------------------------------------------------------------
         * Специальная переменная %player% подставляет логин игрока, который покупает предмет!
         */
        'rule' => 'say Hello %player%',

        // Описание (Поддерживаются HTML-тэги)
        'descr' => 'Lorem Ipsum является текст-заполнитель обычно используется в графических, печать и издательской индустрии для предварительного просмотра макета и визуальных макетах.<br><br> <b>Beautiful!</b>',

        'priority' => 4 //  Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ],

    // 500 монет
    [
        'name' => '500 Монет',    // Название
        'price' => 500,     // Цена
        'sale_price' => 1,  // Цена со скидкой
        'img' => [
            'default' => 'https://megacraft.org/template/assets/images/case.png',    // URL картинки для отображения в списке товаров
            'big' => 'https://megacraft.org/template/assets/images/case.png'         // URL картинки для отображения в модальном окне
        ],

        'category_id' => [1],     // ID категорий из `/config/categories.php` (можно указывать через запятую внутри [], если товар находится в нескольких категориях одновременно) |Для навигации|
        'server_id' => [0],       // ID серверов из `/config/servers.php` (можно указывать через запятую внутри [], если товар доступен на наскольких серверах)

        'driver' => 'rcon',     // Способ получения товара (`rcon` - для RCON выдачи, `database` - для хранения в базе данных)
        'type' => 'command',          // Тип товара:
        // `permission` - право в LuckPerms !! (ТОЛЬКО ПРИ 'driver' => 'database');
        // `command` - команда для выполнения !! (ТОЛЬКО ПРИ 'driver' => 'rcon');

        'lp_context' => 'server=main',  // Контекст для LuckPerms, если способ получения товара: 'driver' => 'database';
        // Оставить 'lp_context' => '', если контекст не используется;
        // Формат 'ключ=значение'. Например, 'server=test' ;

        /**
         * (ТОЛЬКО ДЛЯ 'driver' => 'database')
         * При 'type' => 'permission' здесь указывается конкретное правило LuckPerms (Например, group.vip);
         * -----------------------------------------------------------------------------
         * (ТОЛЬКО ДЛЯ 'driver' => 'rcon')
         * При 'type' => 'command' здесь указывается команда для выдачи конкретного правила (Например, money add %player% 500);
         * -----------------------------------------------------------------------------
         * Специальная переменная %player% подставляет логин игрока, который покупает предмет!
         */
        'rule' => 'say Hello %player%',

        // Описание (Поддерживаются HTML-тэги)
        'descr' => 'Lorem Ipsum является текст-заполнитель обычно используется в графических, печать и издательской индустрии для предварительного просмотра макета и визуальных макетах.<br><br> <b>Beautiful!</b>',

        'priority' => 5 // Приоритет привилегии для LuckPerms (Используется для доплаты. Проверяется ЛИШЬ при 'driver' => 'database')
    ]
];

?>
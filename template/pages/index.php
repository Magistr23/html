<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    $globaltitle = "MegaCraft | Minecraft сервер 1.8-1.18+";
    $globaldesc = "Надоели одинаковые и скучные сервера, уже разочаровались в игре? Заходи на MegaCraft - современный и увлекательный майнкрафт сервер, работающий на версиях 1.8-1.18+!";
    include_once TPL_DIR . "/components/head.php"
    ?>
    <title><?php echo $globaltitle; ?></title>
    <meta name="title" content="<?php echo $globaltitle; ?>">
    <meta name="description" content="<?php echo $globaldesc; ?>">

    <?php
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
    ?>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $actual_link; ?>">
    <meta property="og:title" content="<?php echo $globaltitle; ?>">
    <meta property="og:description" content="<?php echo $globaldesc; ?>">
    <meta property="og:image" content="<?php echo $protocol; ?>megacraft.org/template/assets/images/megacraft_og.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $actual_link; ?>">
    <meta property="twitter:title" content="<?php echo $globaltitle; ?>">
    <meta property="twitter:description" content="<?php echo $globaldesc; ?>">
    <meta property="twitter:image" content="<?php echo $protocol; ?>megacraft.org/template/assets/images/megacraft_og.png">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    
    <?php include_once TPL_DIR . "/components/navigation.php" ?>

    <div class="welcome">
        <div class="description">
            <h1><span class="orange-text">Mega</span>Craft</h1>
            <p class="description__text">
                Надоели одинаковые и скучные сервера, уже разочаровались в игре? Заходи на MegaCraft - современный и увлекательный майнкрафт сервер, работающий на версиях 1.8-1.18+! 
            </p>

            <div class="description__server">
                <button class="btn ip">mc.megacraft.org</button>
                <p class="online">Онлайн: <span class="orange-text">...</span> игроков</p>
            </div>
        </div>

        <div class="sales">
            <p class="title">Скидки:</p>
            <div class="border-orange"></div>
            <div class="sales__items">
                <?php 
                $i = 0;
                foreach($sales as $key => $value):
                    if($i == 2) break;
                    $i++;
                ?>
                    <div class="sales__item">
                        <p class="sales__item-title"><?php echo $value['name'] ?></p>
                        <img class="img-responsive sales__item-img" src="<?php echo $value['img']['default'] ?>" alt="">
                        <div class="sales__item-buy">
                            <button class="btn sales__item-buy-btn" data-id="<?php echo $key ?>">Купить</button>
                            <div class="sales__item-price">
                                <p class="sales__item-price-old"><?php echo $value['price'] ?> Руб</p>
                                <p class="sales__item-price-current"><?php echo $value['sale_price'] ?> Руб</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="items">
        <div class="items__categories">
            <ul class="items__categories-list inline-block">
                <li data-id="0" class="active"><?php echo $categories[0]['name'] ?></li>
                <?php for($i = 1; $i < count($categories); $i++): ?>
                    <li data-id="<?php echo $i ?>" ><?php echo $categories[$i]['name'] ?></li>
                <?php endfor; ?>
            </ul>
        </div>

        <div class="items__description">
            <p class="items__description-category"><?php echo $categories[0]['name'] ?></p>
            <p class="items__description-text"><?php echo $categories[0]['descr'] ?></p>
        </div>

        <div class="items__list">
            <?php foreach($items as $key => $value): ?>
                <div class="items__list-item">
                    <p class="items__list-item-title"><?php echo $value['name'] ?></p>
                    <img class="img-responsive item-img" src="<?php echo $value['img']['default'] ?>" alt="<?php echo $value['name'] ?>">
                    <button class="btn btn-buy" data-id="<?php echo $key ?>">Купить за <?php echo ($value['price'] != $value['sale_price'] && $value['sale_price'] > 0) ? $value['sale_price'] : $value['price'] ?> Руб</button>
                </div>
            <?php endforeach; ?>
        </div>

        <img class="img-responsive baubles baubles_left" src="<?php echo ASSETS_URL ?>/images/baubles_left.png" alt="">
        <img class="img-responsive baubles baubles_right" src="<?php echo ASSETS_URL ?>/images/baubles_right.png" alt="">
        <img class="img-responsive baubles baubles_right-footer" src="<?php echo ASSETS_URL ?>/images/baubles_right-footer.png" alt="">

    </div>

    <?php include_once TPL_DIR . "/components/footer.php" ?>

    <div id="buy-popup" class="popup mfp-hide">
        <p class="popup__title">Покупка товара "<span class="buy-item"></span>"</p>
        <div class="popup__border"></div>
        <div class="item-description"></div>

        <div class="item-buy">
            <div class="item-img">
                <img class="img-responsive item-img__big" src="" alt="">
            </div>

            <div class="customer-info">
                <p class="customer-info__label">Укажите Ваш никнейм на сервере</p>
                <input class="input-custom" type="text" name="login">

                <p class="customer-info__label">Укажите промо-код, если он у Вас есть</p>
                <input class="input-custom" type="text" name="promo">

                <input type="hidden" name="server" value="0">
                <input type="hidden" name="item" value="">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">

                <div class="item-buy__confirm">
                    <div class="item-price"></div>
                    <button class="btn btn-buy-confirm">Оплатить</button>
                </div>

                <div class="payment-types" style="display: none;">
                    <p class="payment-types__title">Выберите способ оплаты, кликнув по иконке:</p>

                    <div class="payment" data-type="qiwi">
                        <img class="img-responsive payment__icon" src="<?php echo ASSETS_URL ?>/images/qiwi_icon.svg" alt="">
                    </div>
                    <div class="payment" data-type="yookassa">
                        <img class="img-responsive payment__icon" src="<?php echo ASSETS_URL ?>/images/io.svg" alt="">
                    </div>
                </div>
            </div>

        </div>
    
    </div>

    <script>
        let categories = <?php echo json_encode($categories, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    
    <?php include_once TPL_DIR . "/components/scripts.php" ?>
    
</div>

</body>

</html>
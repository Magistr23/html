<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        const DEBUG = 0;
        const GlobalTittle = "MegaCraft | Контакты";
        const GlobalDescription = "На этой странице размещена основная контактная информация.";
        if(!DEBUG) include_once TPL_DIR . "/components/head.php";
    ?>
    <title><?=GlobalTittle;?></title>
    <meta name="title" content="<?=GlobalTittle;?>">
    <meta name="description" content="<?=GlobalDescription;?>">

    <?
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
    ?>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $actual_link; ?>">
    <meta property="og:title" content="<?=GlobalTittle;?>">
    <meta property="og:description" content="<?=GlobalDescription;?>">
    <meta property="og:image" content="<?php echo $protocol; ?>megacraft.org/template/assets/images/megacraft_og.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $actual_link; ?>">
    <meta property="twitter:title" content="<?=GlobalTittle;?>">
    <meta property="twitter:description" content="<?=GlobalDescription;?>">
    <meta property="twitter:image" content="<?php echo $protocol; ?>megacraft.org/template/assets/images/megacraft_og.png">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <style type="text/css">
        a.cont {
            border-bottom: 1px solid white;
            color: black;
            text-decoration: none;
            transition: all 0.2s;
        }

        a.cont:hover:after {
            content: "👈";
        }

        a.cont:hover:before {
            content: "👉";
        }
    </style>
</head>
<body>
<?php if(!DEBUG) include_once TPL_DIR . "/components/navigation.php"; ?>
<div class="container">
    <h1>Контакты</h1>
    <p class="container__description">
        Контактная информация.
    </p>
</div>

<div class="rules">
    <div class="rules__text">
        <p>Владелец сервера - <a href="https://vk.com/rem_inn" target="_blank">@rem_inn</a></p>
        <p>Владелец сервера - <a href="https://vk.com/itsmegacraft" target="_blank">@itsmegacraft</a></p>
        <p>Группа сервера - <a href="https://vk.com/themegacraft" target="_blank">@themegacraft</a></p>
        <p>Фан-группа сервера - <a href="https://vk.com/funmegacraft" target="_blank">@funmegacraft</a></p>
        <p><a href="http://megacraft.org/template/assets/docs/agreement.pdf" target="_blank">Договор-оферта</a> - <a href="http://megacraft.org/template/assets/docs/privacy.pdf" target="_blank">Политика приватности</a> - <a href="http://megacraft.org/template/assets/docs/disclaimer.pdf" target="_blank">Дисклеймер</a></p>
        <p>Почта для обращений: <a href="mailto:admin@megacraft.org">admin@megacraft.org</p>
    </div>

    <img src="<?=ASSETS_URL?>/images/container_baubles-left.png" class="img-responsive baubles baubles_container-left" alt="">
    <img src="<?=ASSETS_URL?>/images/container_baubles-left-bottom.png" class="img-responsive baubles baubles_container-left-bottom" alt="">
    <img src="<?=ASSETS_URL?>/images/container_baubles-right.png" class="img-responsive baubles baubles_container-right" alt="">
</div>
<?php if(!DEBUG) include_once TPL_DIR . "/components/footer.php";
include_once TPL_DIR . "/components/scripts.php";
?>

</body>
</html>
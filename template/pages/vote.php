<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        const DEBUG = 0;
        const GlobalTittle = "MegaCraft | Голосуйте";
        const GlobalDescription = "На этой странице вы найдёте ссылки для голосования.";
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
        a.goVote:after {
            content: "🔗" !important;
        }
        a.goVote {
            margin-bottom: 10px !important;
        }
    </style>
</head>
<body>
<?php if(!DEBUG) include_once TPL_DIR . "/components/navigation.php"; ?>
<div class="container">
    <h1>Голосуйте!</h1>
    <p class="container__description">
        Голосуя за сервер - Вы продвигаете его в массы.
    </p>
</div>

<div class="rules">
    <div class="rules__text">
        <h3>Голосуй каждый день и получай МегаКоины за голосование!</h3>
        <?php
        $links = ['MONITORING' => 'https://tmonitoring.com/server/megacraft/',
            'MisterLauncher' => 'http://minecraftrating.ru/vote/27029',
            'HOTMC' => 'http://hotmc.ru/casino-169719',
            'mc-monitoring.info' => 'https://mc-monitoring.info/server/143',
            'minecraft-monitor.ru' => 'https://minecraft-monitor.ru/id/297382',
            'minecraftmonitoring.ru' => 'http://minecraftmonitoring.ru/server-8756',
            'mc-servera.ru' => 'http://mc-servera.ru/68662',
            'minecraft-statistic.net' => 'https://minecraft-statistic.net/ru/server/themegacraft.html',
            'minecraft-server-list.com' => 'http://minecraft-server-list.com/server/410045/',
            'hotmc.ru' => 'http://hotmc.ru/minecraft-server-169719',
            'monitoringminecraft.ru' => 'http://monitoringminecraft.ru/server/271083',
            'minecraft-mp.com' => 'http://minecraft-mp.com/server-s178755',
            'www.serverpact.com' => 'https://www.serverpact.com/vote-42679',
            'minecraft-server.net' => 'https://minecraft-server.net/vote/sosdoz/',
            'topminecraftservers.org' => 'http://topminecraftservers.org/vote/12170',
            'minecraftmonitoring.com' => 'https://minecraftmonitoring.com/server/80',
            'misterlauncher.org' => 'https://misterlauncher.org/server/megacraft/',
            'mc-monitor.ru' => 'https://mc-monitor.ru/server/mc-megacraft',
            'elegantservers.ru' => 'https://elegantservers.ru/server/78'];
        $random = ['🤭', '😎', '💀', '👻', '💘', '🤘', '👈'];
        foreach($links as $t => $l) {
            $r = $random[rand(0, count($random)-1)];
            echo "<p><a href='$l' target='_blank' class='goVote'>$t $r</a></p>";
        }
        ?>
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
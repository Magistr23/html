<?php
use ShellaiDev\Config;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    const DEBUG = 0;
    $globaltitle = "MegaCraft | Описание доната";
    $globaldesc = "На этой странице вы найдете подробное описание доната на сервере MegaCraft.";
    if(!DEBUG) include_once TPL_DIR . "/components/head.php";

    if(DEBUG) {
        echo '<link href="s.css" rel="stylesheet">
        <link href="https://megacraft.org/template/assets/css/magnific-popup.css" rel="stylesheet">';
    }
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
    <style type="text/css">
        .btn-description {
            position: relative;
            top: 13px;
        }
        .btn-description {
            background-color: #F77F15;
            font-weight: 600;
            font-size: 18px;
            line-height: 22px;
            text-align: center;
            color: #FFFFFF;
            min-width: 189px;
            height: 39px;
            max-width: 100%;
            border-radius: 21px;
            padding: 0 5px;
            box-sizing: border-box;
            font-family: "ProximaNova-Regular";
        }
        .item-description-full {
            height: 500px;
            max-width: 100%;
            overflow-y: auto;
            color: #BEBEBE;
            font-size: 15px;
            line-height: 15px;
            text-align: justify;
            padding-right: 10px;
            padding-left: 10px;
            box-sizing: border-box;
            margin-bottom: 42px;
        }
        .item-description-full p {
            line-height: 23px;
            letter-spacing: 1px;
            margin-top:10px;
            font-size: 16px;
        }

        span.cmd {
            background-color: #F77F15;
            padding: 3px;
            font-weight: 500;
            font-size: 17px;
            color: #FFFFFF;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <?php if(!DEBUG) include_once TPL_DIR . "/components/navigation.php"; ?>
    <div class="container">
        <h1>Описание доната</h1>
        <p class="container__description">
            На данной странице представлено описание всего доната.
        </p>
    </div>
    <div class="items">
        <div class="items__list">
            <?php
                foreach (Config::$configs['items'] as $data_id => $i) {?>
                    <div class='items__list-item'>
                    <p class='items__list-item-title'><?=$i["name"]?></p>
                    <img class='img-responsive item-img' src='<?=$i["img"]["default"]?>' alt='<?=$i["name"]?>'>
                        <div class="item-description-full">
                            <?=$i['descr'];?>
                        </div>
                    </div>
                        <?
                }
            ?>

        </div>
        <img src="<?=ASSETS_URL?>/images/container_baubles-left.png" class="img-responsive baubles baubles_container-left" alt="">
        <img src="<?=ASSETS_URL?>/images/container_baubles-left-bottom.png" class="img-responsive baubles baubles_container-left-bottom" alt="">
        <img src="<?=ASSETS_URL?>/images/container_baubles-right.png" class="img-responsive baubles baubles_container-right" alt="">
    </div>
    <div id="buy-popup" class="popup mfp-hide">
        <p class="popup__title">Описание <span class="buy-item"></span></p>
        <div class="popup__border"></div>
        <div class="item-buy">
            <div class="item-img">
                <img class="img-responsive item-img__big" src="" alt="">
            </div>
            <div class="item-description-full">
                <?=$i['descr'];?>
            </div>
        </div>
    </div>

    <?php if(!DEBUG) include_once TPL_DIR . "/components/footer.php"; ?>
    <?php include_once TPL_DIR . "/components/scripts.php" ?>
    <script type="text/javascript">
        $(document).on('click', '.btn-description', function(event){
            event.preventDefault();
            let item = $(this).attr('data-id');

            $.post(`${BASE_URL}/item/info`, {id: item}, function(response){
                if(response.status == 'error'){
                    alert(response.answer);
                    return;
                }

                $('#buy-popup .buy-item').html(response.answer.name);
                $('#buy-popup .item-description-full').html(response.answer.description_full);
                $('#buy-popup .item-img__big').attr('src', response.answer.img.big);

                showModal('#buy-popup');
            });


        });
    </script>
</body>
</html>
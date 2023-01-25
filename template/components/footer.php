<footer>
    <!-- <div class="border-footer"></div> -->

    <div class="footer-container">
        <ul class="footer-container__nav">
            <li><a href=".">Главная</a></li>
        </ul>
        <ul class="footer-container__nav">
            <li><a href="/contacts">Контакты</a></li>
        </ul>
        <ul class="footer-container__nav">
            <li><a href="/vote">Голосовать</a></li>
        </ul>
        <ul class="footer-container__nav">
            <li><a href="#" onclick="event.preventDefault(); showModal('#donate-popup');">Пожертвовать</a></li>
        </ul>

        <div class="footer-container__socials">
            <ul>
                <li>
                    <span><a href="https://vk.com/themegacraft" target="_blank">vk.com/themegacraft</a></span>
                    <img class="img-responsive" src="<?php echo ASSETS_URL ?>/images/icon_vk.svg" alt="">
                </li>
                <li>
                    <span><a href=".">megacraft.org</a></span>
                    <img class="img-responsive" src="<?php echo ASSETS_URL ?>/images/icon_site.svg" alt="">
                </li>
                <li>
                    <span><a href="https://discord.com/invite/TyHbaVjkR2" target="_blank">Discord</a></span>
                    <img class="img-responsive" src="<?php echo ASSETS_URL ?>/images/icon_discord.svg" alt="">
                </li>
                <li>
                    <span><a href="mailto:admin@megacraft.org">admin@megacraft.org</a></span>
                    <img class="img-responsive" src="<?php echo ASSETS_URL ?>/images/icon_mail.svg" alt="">
                </li>
            </ul>
        </div>
    </div>
</footer>

<div id="donate-popup" class="popup mfp-hide">
    <p class="popup__title">Пожертвование</p>
    <div class="popup__border"></div>

    <div class="item-buy">

        <div class="customer-info">
            <p class="customer-info__label">Укажите Ваш никнейм на сервере</p>
            <input class="input-custom" type="text" name="login">

            <p class="customer-info__label">Введите сумму</p>
            <input class="input-custom" type="number" name="sum" min="0">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">

            <div class="item-buy__confirm">
                <button class="btn btn-donate">Пожертвовать</button>
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
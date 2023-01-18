/**
 * Created by Shellaidev.com
 * VK: https://vk.com/shellai_dev
 * @author ShellaiDev
 * All rights reserved!
 */

let csrfToken = '';

/* Responsive menu */
$(document).on('click', '.burger', function(){
    if( $('.nav__container-items').hasClass('nav__container-items-mob') ) {
        $('.nav__container-items').fadeToggle(500, 'swing', function(){
            $('.nav__container-items').removeClass('nav__container-items-mob');
            $('.nav__container-items').css('display', '');
        });
    } else {
        $('.nav__container-items').fadeToggle(500, 'swing', function(){
            $('.nav__container-items').addClass('nav__container-items-mob');
            $('.nav__container-items').css('display', '');
        });
    }
});

$( function(){

    // Set CSRF Token
    setCSRFToken();

    // Check monitoring
    checkMon();
    setInterval(checkMon, 10000);

    // Open BUY popup
    $(document).on('click', '.sales__item-buy-btn, .btn-buy', function(event){
        event.preventDefault(); 
        let item = $(this).attr('data-id');

        $.post(`${BASE_URL}/item/info`, {id: item}, function(response){
            if(response.status == 'error'){
                alert(response.answer);
                return;
            }

            $('#buy-popup .buy-item').html(response.answer.name);
            $('#buy-popup .item-description').html(response.answer.descr);
            $('#buy-popup .item-img__big').attr('src', response.answer.img.big);
            $('#buy-popup input[name="item"]').val(item);

            let price = (response.answer.price != response.answer.sale_price && response.answer.sale_price > 0) ? response.answer.sale_price : response.answer.price;
            $('#buy-popup .item-price').html(`${price} Руб`);

            showModal('#buy-popup');
        });

        
    });

    // Navigate categories
    $(document).on('click', '.items__categories-list li', function(){
        let id = $(this).attr('data-id');
        $('.items__categories-list li').removeClass('active');
        $(this).addClass('active');

        $('.items__description-category').html( $(this).html() );
        $('.items__description-text').html(categories[id].descr);

        $.post(`${BASE_URL}/show/items`, {category: id}, function(response){
            $('.items__list').empty();

            let items = '';
            $.each(response.answer, function(key, value){
                $price = (value.price != value.sale_price && value.sale_price > 0) ? value.sale_price : value.price;
                items += `
                    <div class="items__list-item">
                        <p class="items__list-item-title">${value.name}</p>
                        <img class="img-responsive item-img" src="${value.img.default}" alt="">
                        <button class="btn btn-buy" data-id="${key}">Купить за ${$price} Руб</button>
                    </div>
                `;
            });

            $('.items__list').append(items).hide().fadeIn();
        });
    });

    // Copy ip
    $(document).on('click', '.ip', function(){
        copyToClipboard(this);
    });

    // Prepare to pay
    $(document).on('click', '#buy-popup .btn-buy-confirm', function(){
        let $promo = $.trim( $(this).closest('.customer-info').find('input[name="promo"]').val() );
        let login = $.trim( $(this).closest('.customer-info').find('input[name="login"]').val() );

        let params = {
            item: $(this).closest('.customer-info').find('input[name="item"]').val()
        };

        if(login.length < 1) {
            showMessage('error', 'Введите логин!', 7000);
            return;
        }

        if($promo.length > 1){
            $.post(`${BASE_URL}/promo/check`, {csrf_token: csrfToken, item: params.item, promo: $promo}, function(response){
                if(response.status == 'success') $('#buy-popup .item-price').html(`${response.answer} Руб`);
            });
        }

        showPaymentsTypes('#buy-popup');
    });

    // Pay item
    $(document).on('click', '#buy-popup .payment', function(){
        let params = {
            payment_type: $(this).attr('data-type'),
            login: $('#buy-popup input[name="login"]').val(),
            server: $('#buy-popup input[name="server"]').val(),
            promo: $('#buy-popup input[name="promo"]').val(),
            item: $('#buy-popup input[name="item"]').val(),
            csrf_token: csrfToken
        };

        if(params.login.length < 1) {
            showMessage('error', 'Введите логин!', 7000);
            return;
        }

        $.post(`${BASE_URL}/payment/create`, params, function(response){
            if(response.status == 'error') {
                showMessage(response.status, response.answer, 7000);
                return;
            }

            window.open(response.answer, "_self");
        });

    });

    // Calc item's price
    let timeout;
    $(document).on('keyup', '#buy-popup input[name="login"]', function(){
        clearTimeout(timeout);

        $('#buy-popup .btn-buy-confirm').html(`Оплатить`);

        let params = {
            item: $('#buy-popup input[name="item"]').val(),
            server: $('#buy-popup input[name="server"]').val(),
            login: $(this).val(),
            csrf_token: csrfToken,
            promo: $('#buy-popup input[name="promo"]').val()
        };

        if( params.login.length == 0) return;

        timeout = setTimeout(function() {
            $.post(`${BASE_URL}/price/check`, params, function(response){

                if(response.status == 'error') {
                    $('#buy-popup .item-price').html(`? Руб`);
                    showMessage(response.status, response.answer, 4000);
                    return;
                }
    
                $('#buy-popup .item-price').html(`${response.answer.price} Руб`);
                if( response.answer.can_surcharge === true ) $('#buy-popup .btn-buy-confirm').html(`Доплатить`);
    
            });
        }, 2000);

    });

    // Prepare to Donate
    $(document).on('click', '#donate-popup .btn-donate', function(){
        let params = {
            login: $.trim( $(this).closest('.customer-info').find('input[name="login"]').val() ),
            sum: $('#donate-popup input[name="sum"]').val()
        };

        if(params.login.length < 1) {
            showMessage('error', 'Введите логин!', 7000);
            return;
        }

        if(params.sum < 1) {
            showMessage('error', 'Сумма должна быть больше 0!', 7000);
            return;
        }

        showPaymentsTypes('#donate-popup');
    });

    // Donate
    $(document).on('click', '#donate-popup .payment', function(){
        let params = {
            payment_type: $(this).attr('data-type'),
            login: $('#donate-popup input[name="login"]').val(),
            sum: $('#donate-popup input[name="sum"]').val(),
            csrf_token: csrfToken
        };

        if(params.login.length < 1) {
            showMessage('error', 'Введите логин!', 7000);
            return;
        }

        $.post(`${BASE_URL}/payment/donate`, params, function(response){
            if(response.status == 'error') {
                showMessage(response.status, response.answer, 7000);
                return;
            }

            window.open(response.answer, "_self");
        });

    });
});

function checkMon(){
    $.post(`${BASE_URL}/mon/check`, {}, function(response){
        $('.online .orange-text').html(response.answer);
    });
}

function showPaymentsTypes(popup){
    if( $(`${popup} .payment-types`).css('display') == 'none' ) {
        $(`${popup} .payment-types`).fadeToggle(500, 'swing', function(){
            $('.mfp-fade').animate({
                scrollTop: $(popup).offset().top + $(popup).height() / 2
            }, 500);
        });
    } else {
        $('.mfp-fade').animate({
            scrollTop: $(popup).offset().top + $(popup).height() / 2
        }, 500);
    }
}

function showModal($modal){
    $.magnificPopup.open(
        {
            items: {
                src: $modal,
                type: 'inline',
                midClick: true,
            },
            removalDelay: 300,
            mainClass: 'mfp-fade',
        }
    );
}

// Copy ip to clipboard
function copyToClipboard(element) {
    let $temp = $("<input>");
    $("body").append($temp);
    $temp.val( $(element).text().trim() ).select();
    document.execCommand("copy");
    $temp.remove();

    if( $('body').find('.notify').length <= 0){
        showMessage('success', 'IP успешно скопирован!', 3000)
    }
}

// Show message
function showMessage(status, message, delay = 5000){
    $('.notify').remove();
    $(`<div class="notify notify_${status}">${message}</div>`).appendTo('body').hide().fadeIn(300);
    setTimeout( () => {
        $('.notify').fadeOut(300, () => $('.notify').remove());
    }, delay);
}

function setCSRFToken(){
    let input = $('input[name="csrf_token"]');
    if( typeof(input) !== 'undefined' ) csrfToken = $(input).val();
}
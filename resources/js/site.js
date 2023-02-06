"use strict";
document.addEventListener("DOMContentLoaded", () => {
// document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){

    /*
     * Общие настройки ajax-запросов, отправка на сервер csrf-токена
     */
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    /*
     * Раскрытие и скрытие пунктов меню каталога в левой колонке
     */
    // Скрываем подменю
    if (document.querySelector('#catalog-sidebar > ul ul')) {
        document.querySelector('#catalog-sidebar > ul ul').style.display = "none";
    }
    // Обработчик на "+"
    if (document.querySelector('#catalog-sidebar .badge')) {
        document.querySelector('#catalog-sidebar .badge').addEventListener('click', function (e) {
            // Удаляем действия по умолчанию
            e.preventDefault();

            // Получаем первый элемент по классу
            let badge = this;

            // getNextSiblings(badge)[0].localName === ul
            // nextElementSibling - 1-й следующий эл-т
            let closed = badge.nextElementSibling.tagName === 'UL' && badge.nextElementSibling.style.display === 'none';

            // Обрезание содержимого блока
            badge.nextElementSibling.style.overflow = 'hidden';

            if (closed) {
                slideToggle(badge.nextElementSibling, 1000);
                badge.firstElementChild.classList.toggle('fa-plus');
                badge.firstElementChild.classList.toggle('fa-minus');
            } else {
                slideToggle(badge.nextElementSibling, 1000);
                badge.firstElementChild.classList.toggle('fa-plus');
                badge.firstElementChild.classList.toggle('fa-minus');
            }
        });
    }

    /* TOGGLE SLIDE UP and SLIDE DOWN*/
    let slideToggle = (target, duration = 500) => {
        if (window.getComputedStyle(target).display === 'none') {
            return slideDown(target, duration);
        } else {
            return slideUp(target, duration);
        }
    }

    /*
     * Получение данных профиля пользователя при оформлении заказа
     */
    // document.querySelector('form#profiles button[type="submit"]').style.display = "none";
    // при выборе профиля отправляем ajax-запрос, чтобы получить данные
    // document.querySelector('form#profiles select').change(function () {
    //     // если выбран элемент «Выберите профиль»
    //     if (this.value === 0) {
    //         // очищаем все поля формы оформления заказа
    //         document.querySelector('#checkout').reset();
    //         return;
    //     }
    //     var data = new FormData(document.querySelector('form#profiles')[0]);

    //     let request = new XMLHttpRequest();
    //     request.open("POST", "/basket/profile", true);
    //     request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    //     request.send(data);

    // });


    /*
     * Получение данных профиля пользователя при оформлении заказа
     */
    // $('form#profiles button[type="submit"]').hide();
    // при выборе профиля отправляем ajax-запрос, чтобы получить данные
    // $('form#profiles select').change(function () {
    //     // если выбран элемент «Выберите профиль»
    //     if ($(this).val() == 0) {
    //         // очищаем все поля формы оформления заказа
    //         $('#checkout').trigger('reset');
    //         return;
    //     }
    //     var data = new FormData($('form#profiles')[0]);
    //     $.ajax({
    //         type: 'POST',
    //         url: '/basket/profile',
    //         data: data,

    //         processData: false,
    //         contentType: false,

    //         dataType: 'JSON',

    //         success: function(data) {
    //             $('input[name="name"]').val(data.profile.name);
    //             $('input[name="email"]').val(data.profile.email);
    //             $('input[name="phone"]').val(data.profile.phone);
    //             $('input[name="address"]').val(data.profile.address);
    //             $('textarea[name="comment"]').val(data.profile.comment);
    //         },

    //         error: function (reject) {
    //             alert(reject.responseJSON.error);
    //         }
    //     });
    // });

    /*
     * Добавление товара в корзину с помощью ajax-запроса без перезагрузки
     */
    // $('form.add-to-basket').submit(function (e) {
    //     // отменяем отправку формы стандартным способом
    //     e.preventDefault();
    //     // получаем данные этой формы добавления в корзину
    //     var $form = $(this);
    //     var data = new FormData($form[0]);
    //     $.ajax({
    //         url: $form.attr('action'),
    //         data: data,
    //         processData: false,
    //         contentType: false,
    //         type: 'POST',
    //         dataType: 'HTML',
    //         beforeSend: function () {
    //             var spinner = ' <span class="spinner-border spinner-border-sm"></span>';
    //             $form.find('button').append(spinner);
    //         },
    //         success: function(html) {
    //             $form.find('.spinner-border').remove();
    //             $('#top-basket').html(html);
    //         }
    //     });
    // });


    /* SLIDE UP */
    let slideUp = (target, duration = 500) => {

        target.style.transitionProperty = 'height, margin, padding';
        target.style.transitionDuration = duration + 'ms';
        target.style.boxSizing = 'border-box';
        target.style.height = target.offsetHeight + 'px';
        target.offsetHeight;
        // target.style.overflow = 'hidden';
        target.style.height = '0';
        target.style.paddingTop = '0';
        target.style.paddingBottom = '0';
        target.style.marginTop = '0';
        target.style.marginBottom = '0';
        window.setTimeout(() => {
            target.style.display = 'none';
            target.style.removeProperty('height');
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
            //alert("!");
        }, duration);
    }

    /* SLIDE DOWN */
    let slideDown = (target, duration = 500) => {

        target.style.removeProperty('display');
        let display = window.getComputedStyle(target).display;
        if (display === 'none') display = 'block';
        target.style.display = display;
        let height = target.offsetHeight;
        // target.style.overflow = 'hidden';
        target.style.height = '0';
        target.style.paddingTop = '0';
        target.style.paddingBottom = '0';
        target.style.marginTop = '0';
        target.style.marginBottom = '0';
        target.offsetHeight;
        target.style.boxSizing = 'border-box';
        target.style.transitionProperty = "height, margin, padding";
        target.style.transitionDuration = duration + 'ms';
        target.style.height = height + 'px';
        target.style.removeProperty('padding-top');
        target.style.removeProperty('padding-bottom');
        target.style.removeProperty('margin-top');
        target.style.removeProperty('margin-bottom');
        window.setTimeout(() => {
            target.style.removeProperty('height');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
        }, duration);
    }

    // поиск соседних элементов перед текущим элементом
    // function getPreviousSiblings(elem) {
    //     let siblings = [];
    //     let sibling = elem;
    //     while (sibling.previousSibling) {
    //         sibling = sibling.previousSibling;
    //         sibling.nodeType === 1 && siblings.push(sibling);
    //     }
    //
    //     return siblings;
    // }

    // поиск соседних элементов после текущего элементом
    // function getNextSiblings(elem) {
    //     let siblings = [];
    //     let sibling = elem;
    //     while (sibling.nextSibling) {
    //         sibling = sibling.nextSibling;
    //         sibling.nodeType === 1 && siblings.push(sibling);
    //     }
    //
    //     return siblings;
    // }

});

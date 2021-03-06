$(document).ready(function () {

// Выпадающее меню в хедере
    header = $("header");
    var dropMenu = $(".drop-menu");
    dropMenu.hide();
    $(".header-nav-mobile-burger").on('click', function () {
        if (dropMenu.is(":visible")) {
            dropMenu.slideUp();
        } else {
            dropMenu.slideDown();
        }
    });

// фиксация шапки при сколле
    $(document).scroll(function () {
        var height = $(window).scrollTop();

        if (height !== 0) {
            $('header').addClass('showed').slideDown();
            dropMenu.slideUp();
            $('.ham8').removeClass('active');
        } else {
            if ($(window).width() > 991){
                $('header').removeClass('showed').hide();
            }
        }
    });

// плавный скрол до якорей
    header.on("click", "a", function (event) {
        event.preventDefault();

        var id = $(this).attr('href');
        var top;
            if ($(window).width() > 991){
            top = $(id).offset().top - 105
        } else {
            top = $(id).offset().top - 79}

        $('body,html').animate({scrollTop: top}, 1500);
    });

//слайдер
    $('.wrapper-slide').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        asNavFor: null,
        dots:true

    });

//E-mail Ajax Send
    $(".callback form, .modal form").submit(function () { //Change
        var th = $(this);
        $.ajax({
            type: "POST",
            url: "/mail.php", //Change
            data: th.serialize()
        }).done(function () {
            $(th).find('.success').addClass('active').css('display', 'flex').hide().fadeIn();
            setTimeout(function () {
                // Done Functions
                $(th).find('.success').removeClass('active').fadeOut();
                th.trigger("reset");
            }, 4000);
        });
        return false;
    });

// Yandex-map
    // Функция ymaps.ready() будет вызвана, когда
    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);
    var myMap;
    var myPlacemark1;
    function init(){
            myMap = new ymaps.Map("map", {
            center: [44.73660492, 39.92236579],
            zoom: 15
        });
            myMap.behaviors.disable ([
                'scrollZoom',
                // 'drag'    // прокрутка карты зажатой кнопкой мыши или пальцем
            ]);
        myPlacemark1 = new ymaps.Placemark([44.73660492, 39.92236579], { hintContent: 'Белые ключи', balloonContent: 'Загородный поселок'});
        myMap.geoObjects.add(myPlacemark1);
    }
});


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
// import './bootstrap';
// import $ from  './js/jquery-2.2.4.min';
import $ from 'jquery';
import jQueryBridget from 'jquery-bridget';

import './js/main.min';
import './js/custom';
import Global from './modules/Global'
import Cart from './modules/Cart';
// import Checkout from './modules/Checkout';

new Global(document.querySelector('.js-cart'));
new Cart(document.querySelector('.js-cart-form'));
// new Checkout(document.querySelector('.js-checkout-form'));

let checkout = document.querySelector('.checkout');
if(checkout){
    let type1 = document.querySelector('.type1');
    let type2 = document.querySelector('.type2');
    document.querySelector('#paymentMethod').firstChild.textContent = 'Choose a payment method';
    type1.addEventListener('click', function(){
        this.classList.add('selected');
        this.nextElementSibling.classList.remove('selected');
        $('#paymentMethod').val('');
        $('#paymentMethod').niceSelect('update');
        document.querySelector('.select-wrapper').style.display = 'none';
        document.querySelector('#paymentMethod').required = false;

    })
    type2.addEventListener('click', function(){
            if(!this.classList.contains('disabled')) {
                this.classList.add('selected');
                this.previousElementSibling.classList.remove('selected');
                document.querySelector('.select-wrapper').style.display = 'block';
                document.querySelector('#paymentMethod').required = true;
            }
    })
}

$('#paymentMethod').on('change', function(){
    console.log($('#paymentMethod').val());
})

var _html = document.documentElement,
    isTouch = (('ontouchstart' in _html) || (navigator.msMaxTouchPoints > 0) || (navigator.maxTouchPoints));

_html.className = _html.className.replace("no-js","js");
_html.classList.add( isTouch ? "touch" : "no-touch");

import './js/device.min';
import './js/b5bf1bd49e';
import Isotope from './js/isotope.pkgd.min';

jQueryBridget('isotope', Isotope, $);



// $(window).on('load', function(){
//     $('#loading').fadeOut(500);
// });

function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);

    function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);
        }
    }
}

function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
}

onReady(function () {
    show('app', true);
    $('#loading').fadeOut(1000);
    // show('loading', false);
    /*==================================================================
[ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

// filter items on button click
    $filter.each(function () {
        $filter.on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({filter: filterValue});
        });

    });

// init Isotope
    $(window).on('load', function () {
        var $grid = $topeContainer.each(function () {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine : 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function(){
        $(this).on('click', function(){
            for(var i=0; i<isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });
});

// $(window).on('load', function () {
//     var wind = $(window);
//     /* ----------------------------------------------------------------
//         [ Preloader ]
// -----------------------------------------------------------------*/
//
//     $('.loading').fadeOut(500);
// });
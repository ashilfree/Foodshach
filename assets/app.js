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
import $ from  './js/jquery-2.2.4.min';

import './js/main.min';
import './js/custom';

var _html = document.documentElement,
    isTouch = (('ontouchstart' in _html) || (navigator.msMaxTouchPoints > 0) || (navigator.maxTouchPoints));

_html.className = _html.className.replace("no-js","js");
_html.classList.add( isTouch ? "touch" : "no-touch");

import './js/device.min';

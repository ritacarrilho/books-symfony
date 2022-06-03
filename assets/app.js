/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/style.sass';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function() { // when the page finishes to load
    $('[data-bs-toggle = "tooltip"]').tooltip(); // activates tooltip to all elements where it was applied 
});
import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css'
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css'

console.log('importing @fortawesome free');
import '@fortawesome/fontawesome-free'
import '@fortawesome/fontawesome-free/css/fontawesome.min.css'

console.log('This log comes from assets/app.js - bootstrap, etc.')

import $ from 'jquery';
window.$ = $;

import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

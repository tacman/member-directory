<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'map' => [
        'path' => './assets/js/map.js',
        'entrypoint' => true,
    ],
    'fos_routing_local' => [
        'path' => './vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    'bootstrap' => [
        'version' => '5.3.2',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.2',
        'type' => 'css',
    ],
    'leaflet' => [
        'version' => '1.9.4',
    ],
    'leaflet/dist/leaflet.min.css' => [
        'version' => '1.9.4',
        'type' => 'css',
    ],
    'gravatar' => [
        'version' => '1.8.2',
    ],
    'blueimp-md5' => [
        'version' => '2.19.0',
    ],
    'hotkeys-js' => [
        'version' => '3.12.0',
    ],
    'fos-routing' => [
        'version' => '0.0.6',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    'twig' => [
        'version' => '1.17.1',
    ],
    'locutus/php/strings/sprintf' => [
        'version' => '2.0.16',
    ],
    'locutus/php/strings/vsprintf' => [
        'version' => '2.0.16',
    ],
    'locutus/php/math/round' => [
        'version' => '2.0.16',
    ],
    'locutus/php/math/max' => [
        'version' => '2.0.16',
    ],
    'locutus/php/math/min' => [
        'version' => '2.0.16',
    ],
    'locutus/php/strings/strip_tags' => [
        'version' => '2.0.16',
    ],
    'locutus/php/datetime/strtotime' => [
        'version' => '2.0.16',
    ],
    'locutus/php/datetime/date' => [
        'version' => '2.0.16',
    ],
    'locutus/php/var/boolval' => [
        'version' => '2.0.16',
    ],
    'axios' => [
        'version' => '1.6.1',
    ],
    'datatables.net-bs5' => [
        'version' => '2.0.3',
    ],
    'datatables.net' => [
        'version' => '2.0.3',
    ],
    'datatables.net-bs5/css/dataTables.bootstrap5.min.css' => [
        'version' => '2.0.3',
        'type' => 'css',
    ],
    'datatables.net-responsive' => [
        'version' => '3.0.2',
    ],
    'datatables.net-searchpanes-bs5' => [
        'version' => '2.3.0',
    ],
    'datatables.net-searchpanes-bs5/css/searchPanes.bootstrap5.min.css' => [
        'version' => '2.3.0',
        'type' => 'css',
    ],
    'datatables.net-select-bs5' => [
        'version' => '2.0.1',
    ],
    'datatables.net-select-bs5/css/select.bootstrap5.min.css' => [
        'version' => '2.0.1',
        'type' => 'css',
    ],
    '@fortawesome/fontawesome-free' => [
        'version' => '6.4.2',
    ],
    '@fortawesome/fontawesome-free/css/fontawesome.min.css' => [
        'version' => '6.4.2',
        'type' => 'css',
    ],
    'datatables.net-plugins/i18n/en-GB.mjs' => [
        'version' => '2.0.5',
    ],
    'datatables.net-select' => [
        'version' => '2.0.1',
    ],
    'datatables.net-scroller-bs5' => [
        'version' => '2.4.1',
    ],
    'datatables.net-scroller' => [
        'version' => '2.4.1',
    ],
    'datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css' => [
        'version' => '2.4.1',
        'type' => 'css',
    ],
    'datatables.net-searchpanes' => [
        'version' => '2.3.0',
    ],
    'datatables.net-buttons-bs5' => [
        'version' => '3.0.2',
    ],
    'datatables.net-buttons' => [
        'version' => '3.0.2',
    ],
    'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css' => [
        'version' => '3.0.2',
        'type' => 'css',
    ],
    'datatables.net-responsive-bs5' => [
        'version' => '3.0.2',
    ],
    'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css' => [
        'version' => '3.0.2',
        'type' => 'css',
    ],
    'tablednd' => [
        'version' => '1.0.5',
    ],
    'moment' => [
        'version' => '2.29.4',
    ],
    'bootstrap-icons/font/bootstrap-icons.min.css' => [
        'version' => '1.11.2',
        'type' => 'css',
    ],
    'perfect-scrollbar' => [
        'version' => '1.5.5',
    ],
    'perfect-scrollbar/css/perfect-scrollbar.min.css' => [
        'version' => '1.5.5',
        'type' => 'css',
    ],
    'datatables.net-searchbuilder-bs5' => [
        'version' => '1.7.1',
    ],
    'datatables.net-searchbuilder' => [
        'version' => '1.7.1',
    ],
    'datatables.net-searchbuilder-bs5/css/searchBuilder.bootstrap5.min.css' => [
        'version' => '1.7.1',
        'type' => 'css',
    ],
];

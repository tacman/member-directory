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
 *
 * @return array<string, array{    // Import name as key, description of the imported file as value
 *     path: string,               // Logical, relative or absolute path to the file
 *     type?: 'js'|'css'|'json',   // Type of the file, defaults to 'js'
 *     entrypoint?: bool,          // Whether the file is an entrypoint, for 'js' only
 * }|array{
 *     version: string,            // Version of the remote package
 *     package_specifier?: string, // Remote "package-name/path" specifier, defaults to the import name
 *     type?: 'js'|'css'|'json',
 *     entrypoint?: bool,
 * }>
 */
return [
    'app' => ['path' => './assets/app.js', 'entrypoint' => true],
    'map' => ['path' => './assets/js/map.js', 'entrypoint' => true],
    '@symfony/stimulus-bundle' => ['path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js'],
    '@survos/js-twig/generated/fos_routes.js' => ['path' => './var/js_twig_bundle/generated/fos_routes.js'],
    'bootstrap' => ['version' => '5.3.2'],
    '@popperjs/core' => ['version' => '2.11.8'],
    'bootstrap/dist/css/bootstrap.min.css' => ['version' => '5.3.2', 'type' => 'css'],
    'leaflet' => ['version' => '1.9.4'],
    'leaflet/dist/leaflet.min.css' => ['version' => '1.9.4', 'type' => 'css'],
    'gravatar' => ['version' => '1.8.2'],
    'blueimp-md5' => ['version' => '2.19.0'],
    'hotkeys-js' => ['version' => '3.12.0'],
    'jquery' => ['version' => '3.7.1'],
    '@hotwired/stimulus' => ['version' => '3.2.2'],
    'twig' => ['version' => '1.17.1'],
    'locutus/php/strings/sprintf' => ['version' => '2.0.16'],
    'locutus/php/strings/vsprintf' => ['version' => '2.0.16'],
    'locutus/php/math/round' => ['version' => '2.0.16'],
    'locutus/php/math/max' => ['version' => '2.0.16'],
    'locutus/php/math/min' => ['version' => '2.0.16'],
    'locutus/php/strings/strip_tags' => ['version' => '2.0.16'],
    'locutus/php/datetime/strtotime' => ['version' => '2.0.16'],
    'locutus/php/datetime/date' => ['version' => '2.0.16'],
    'locutus/php/var/boolval' => ['version' => '2.0.16'],
    'axios' => ['version' => '1.7.7'],
    'datatables.net-bs5' => ['version' => '3.0.0-beta.1'],
    'datatables.net' => ['version' => '3.0.0-beta.1'],
    'datatables.net-bs5/css/dataTables.bootstrap5.min.css' => ['version' => '3.0.0-beta.1', 'type' => 'css'],
    'datatables.net-responsive' => ['version' => '4.0.0-beta.1'],
    'datatables.net-searchpanes-bs5' => ['version' => '2.3.0'],
    'datatables.net-searchpanes-bs5/css/searchPanes.bootstrap5.min.css' => ['version' => '2.3.0', 'type' => 'css'],
    'datatables.net-select-bs5' => ['version' => '4.0.0-beta.1'],
    'datatables.net-select-bs5/css/select.bootstrap5.min.css' => ['version' => '4.0.0-beta.1', 'type' => 'css'],
    '@fortawesome/fontawesome-free' => ['version' => '6.4.2'],
    '@fortawesome/fontawesome-free/css/fontawesome.min.css' => ['version' => '6.4.2', 'type' => 'css'],
    'datatables.net-plugins/i18n/en-GB.mjs' => ['version' => '2.3.6'],
    'datatables.net-select' => ['version' => '4.0.0-beta.1'],
    'datatables.net-scroller-bs5' => ['version' => '3.0.0-beta.1'],
    'datatables.net-scroller' => ['version' => '3.0.0-beta.1'],
    'datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css' => ['version' => '3.0.0-beta.1', 'type' => 'css'],
    'datatables.net-searchpanes' => ['version' => '2.3.0'],
    'datatables.net-buttons-bs5' => ['version' => '4.0.0-beta.1'],
    'datatables.net-buttons' => ['version' => '4.0.0-beta.1'],
    'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css' => ['version' => '4.0.0-beta.1', 'type' => 'css'],
    'datatables.net-responsive-bs5' => ['version' => '4.0.0-beta.1'],
    'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css' => ['version' => '4.0.0-beta.1', 'type' => 'css'],
    'tablednd' => ['version' => '1.0.5'],
    'moment' => ['version' => '2.29.4'],
    'bootstrap-icons/font/bootstrap-icons.min.css' => ['version' => '1.11.2', 'type' => 'css'],
    'perfect-scrollbar' => ['version' => '1.5.6'],
    'perfect-scrollbar/css/perfect-scrollbar.min.css' => ['version' => '1.5.6', 'type' => 'css'],
    'datatables.net-searchbuilder-bs5' => ['version' => '2.0.0-beta.1'],
    'datatables.net-searchbuilder' => ['version' => '2.0.0-beta.1'],
    'datatables.net-searchbuilder-bs5/css/searchBuilder.bootstrap5.min.css' => ['version' => '2.0.0-beta.1', 'type' => 'css'],
    'datatables.net-plugins/i18n/es-ES.mjs' => ['version' => '2.3.6'],
    'datatables.net-plugins/i18n/de-DE.mjs' => ['version' => '2.3.6'],
    '@symfony/ux-leaflet-map' => ['path' => './vendor/symfony/ux-leaflet-map/assets/dist/map_controller.js'],
    '@tabler/core' => ['version' => '1.0.0-beta21'],
    '@tabler/core/dist/css/tabler.min.css' => ['version' => '1.0.0-beta21', 'type' => 'css'],
    '@tacman1123/twig-browser' => ['version' => '1.0.0'],
    '@tacman1123/twig-browser/src/compat/compileTwigBlocks.js' => ['version' => '1.0.0'],
    '@tacman1123/twig-browser/adapters/symfony' => ['version' => '1.0.0'],
    'datatables.net-bs5/css/dataTables.bootstrap5.css' => ['version' => '3.0.0-beta.2', 'type' => 'css'],
    'datatables.net-buttons-bs5/css/buttons.bootstrap5.css' => ['version' => '4.0.0-beta.1', 'type' => 'css'],
    'datatables.net-responsive-bs5/css/responsive.bootstrap5.css' => ['version' => '4.0.0-beta.1', 'type' => 'css'],
    'datatables.net-searchbuilder-bs5/css/searchBuilder.bootstrap5.css' => ['version' => '2.0.0-beta.1', 'type' => 'css'],
    'datatables.net-select-bs5/css/select.bootstrap5.css' => ['version' => '4.0.0-beta.1', 'type' => 'css'],
    'datatables.net-columncontrol' => ['version' => '2.0.0-beta.1'],
    'datatables.net-columncontrol-bs5' => ['version' => '2.0.0-beta.1'],
    'datatables.net-columncontrol-bs5/css/columnControl.bootstrap5.min.css' => ['version' => '2.0.0-beta.1', 'type' => 'css'],
    'datatables.net-columncontrol-bs5/css/columnControl.bootstrap5.css' => ['version' => '2.0.0-beta.1', 'type' => 'css'],
    'stimulus-attributes' => ['version' => '1.0.2'],
    'escape-html' => ['version' => '1.0.3'],
    'dexie' => ['version' => '4.4.4'],
    'flag-icons/css/flag-icons.min.css' => ['version' => '7.5.0', 'type' => 'css'],
];

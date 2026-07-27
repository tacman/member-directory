/* jshint esversion: 6 */
/* globals $ */

// The main member listing table now uses api-grid-bundle's <twig:api_grid> component
// (see templates/directory/directory.html.twig) instead of a hand-rolled DataTable here.

import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.html5.js';

$(function () {
  var exportButtons = [
    {
      text: '<i class="fas fa-save fa-fw"></i> Download CSV',
      extend: 'csvHtml5',
      className: 'btn-sm'
    },
    {
      text: '<i class="fas fa-clipboard fa-fw"></i> Copy to Clipboard',
      extend: 'copyHtml5',
      className: 'btn-sm'
    }
  ];

  if ($('.birthdayTable').length) {
    new DataTable('.birthdayTable', {
      paging: false,
      searching: false,
      info: false,
      buttons: exportButtons,
      dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
        "<'d-block text-center py-3'B>",
    });
  }
});

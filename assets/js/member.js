/* globals Routing, $ */

import 'leaflet/dist/leaflet.css';
import 'leaflet-defaulticon-compatibility/dist/leaflet-defaulticon-compatibility.webpack.css'; // Re-uses images from ~leaflet package
import * as L from 'leaflet';
import 'leaflet-defaulticon-compatibility';

// Member Map
$(document).ready(function() {
  var mailingLatitude = $('#mapContainer').data('mailing_latitude')
  var mailingLongitude = $('#mapContainer').data('mailing_longitude')
  
  if (!mailingLatitude || !mailingLongitude) {
    return;
  }
  
  var mymap = L.map('mapContainer').setView([mailingLatitude, mailingLongitude], 12);

  L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png', {
    subdomains: 'abcd',
    maxZoom: 19,
    minZoom: 1,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright" target="blank">OpenStreetMap</a> &copy; <a href="http://cartodb.com/attributions" target="blank">CartoDB</a>'
  }).addTo(mymap)

  var markerIcon = L.Icon.extend({
    options: {
      iconUrl:       require('../images/marker-icon.svg').default,
      shadowUrl:     require('../images/marker-shadow.png').default,
      iconSize:    [24, 40],
      iconAnchor:  [12, 40],
      shadowSize:  [40, 40]
    }
  });

  var defaultIcon = new markerIcon();

  var marker = L.marker(L.latLng(mailingLatitude, mailingLongitude))
  marker.setIcon(defaultIcon)
  marker.addTo(mymap)
});

// Inline address verification
$(document).ready(function () {
  var verifyAddressButton = $('#verifyAddressButton')
  var verifyAddressStatusIndicator = $('#verifyAddressStatusIndicator')
  var toastContainer = $('#toastContainer')
  var toastTemplate = $('#toastTemplate').html()
  var mailingAddressLine1 = $('#member_mailingAddressLine1')
  var mailingAddressLine2 = $('#member_mailingAddressLine2')
  var mailingCity = $('#member_mailingCity')
  var mailingState = $('#member_mailingState')
  var mailingPostalCode = $('#member_mailingPostalCode')
  
  $(verifyAddressStatusIndicator).hide()
  
  verifyAddressButton.on('click', function () {
    $(verifyAddressStatusIndicator).show()

    $.getJSON(Routing.generate('verify_address_data'), {
      mailingAddressLine1: mailingAddressLine1.val(),
      mailingAddressLine2: mailingAddressLine2.val(),
      mailingCity: mailingCity.val(),
      mailingState: mailingState.val(),
      mailingPostalCode: mailingPostalCode.val()
    })
      .done(function(data) {
        if (typeof data.verify.Address1 == 'undefined') {
          mailingAddressLine1.val(data.verify.Address2);
          mailingAddressLine2.val('');
        } else {
          mailingAddressLine1.val(data.verify.Address1);
          mailingAddressLine2.val(data.verify.Address2);
        }
        mailingCity.val(data.verify.City);
        mailingState.val(data.verify.State);
        mailingPostalCode.val(data.verify.Zip5+'-'+data.verify.Zip4);

        var toast = $(toastTemplate)
        $('.toast-header', toast).addClass('bg-success text-light')
        $('.toast-title', toast).html('Address Verification')
        $('.toast-body', toast).html('Updated form fields with verified mailing address from the US Postal Service.')
        $(toast).appendTo(toastContainer)
        $('.toast').toast({
          animation: true,
          autohide: true,
          delay: 5000
        })
        toast.toast('show')
      })
      .fail(function (response) {
        var toast = $(toastTemplate)
        $('.toast-header', toast).addClass('bg-danger text-light')
        $('.toast-title', toast).html('Address Verification')
        $('.toast-body', toast).html(response.responseJSON.message)
        $(toast).appendTo(toastContainer)
        $('.toast').toast({
          animation: true,
          autohide: true,
          delay: 10000
        })
        toast.toast('show')
      })
      .always(function () {
        $(verifyAddressStatusIndicator).hide()
      })
  })
})

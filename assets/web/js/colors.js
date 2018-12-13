/* global rgbToHex */
//import jQuery from 'jquery';
//window.$ = window.jQuery = jQuery;

/**
 * --------------------------------------------------------------------------
 * CoreUI Free Boostrap Admin Template (v2.1.10): colors.js
 * Licensed under MIT (https://coreui.io/license)
 * --------------------------------------------------------------------------
 */

jQuery('.theme-color').each(function () {
  const Color = jQuery(this).css('backgroundColor')
    jQuery(this).parent().append(`
    <table class="w-100">
      <tr>
        <td class="text-muted">HEX:</td>
        <td class="font-weight-bold">${rgbToHex(Color)}</td>
      </tr>
      <tr>
        <td class="text-muted">RGB:</td>
        <td class="font-weight-bold">${Color}</td>
      </tr>
    </table>
  `)
})

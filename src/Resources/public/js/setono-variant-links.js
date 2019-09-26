/**
 * A lot of the code here was taken from
 *
 * vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Resources/private/js/sylius-variants-prices.js
 */
(function ($) {
  'use strict';

  const handleProductOptionsChange = function handleProductOptionsChange() {
    $('[name*="sylius_add_to_cart[cartItem][variant]"]').on('change', () => {
      let selector = '';

      $('#sylius-product-adding-to-cart select[data-option]').each((index, element) => {
        const select = $(element);
        const option = select.find('option:selected').val();
        selector += `[data-${select.data('option')}="${option}"]`;
      });

      const path = $('#setono-variant-links').find(selector).data('value');

      if (path !== undefined) {
        location.href = path;
      }
    });
  };

  const handleProductVariantsChange = function handleProductVariantsChange() {
    $('[name="sylius_add_to_cart[cartItem][variant]"]').on('change', (event) => {
      const variantCode = $(event.currentTarget).val();
      const path = $('#setono-variant-links [data-variant-code="' + variantCode + '"]').data('value');

      if(path !== undefined) {
        location.href = path;
      }
    });
  };

  $.fn.extend({
    variantLinks: function () {
      if ($('#sylius-variants-pricing').length > 0) {
        handleProductOptionsChange();
      } else if ($('#sylius-product-variants').length > 0) {
        handleProductVariantsChange();
      }
    }
  });
})(jQuery);

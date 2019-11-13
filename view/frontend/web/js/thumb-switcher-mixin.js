/**
 * @category    Kraken
 * @copyright   Copyright (c) 2019 Kraken Commerce
 */
define([
  'jquery',
  'jquery/ui'
], function ($) {
  "use strict";

  return function () {

    jQuery.widget(
      'mage.magicToolboxThumbSwitcher',
      jQuery['mage']['magicToolboxThumbSwitcher'],
      {
        /**
         * Override the MagicScroll/MagicZoomPlus logic so that if a video thumbnail is clicked, user is scrolled down
         * to video section
         *
         * @param event
         * @returns {boolean|*}
         * @private
         */
        _switchThumb: function (event) {

          var videoElementId = $(event.target).data('video');

          if (videoElementId && videoElementId.indexOf('wistia_video') >= 0) {

            // Open "Video" accordion, if it's not already visible
            if ($('#attribute_video .switch') && $('#attribute_video.content').is(':visible') !== true) {
              $('#attribute_video .switch').click();
            }

            var timeDelay = 700;
            var offset = 30;

            $('html').animate({
                scrollTop: $('#' + videoElementId).offset().top - offset,
              },
              timeDelay
            );

            setTimeout(function(){
                window.wistiaInit = function(W) {

                  W.api(videoElementId).play();

                };
              },
              timeDelay
            );
            return false;
          }

          return this._super(event);
        },
      }
    );

    return jQuery['mage']['magicToolboxThumbSwitcher'];
  };
});

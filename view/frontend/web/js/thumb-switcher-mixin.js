/**
 * @category    Kraken
 * @copyright   Copyright (c) 2019 Kraken Commerce
 */
define([
  'jquery',
  'jquery-ui-modules/widget'
], function ($) {
  "use strict";

  return function () {

    jQuery.widget(
      'mage.magicToolboxThumbSwitcher',
      jQuery['mage']['magicToolboxThumbSwitcher'],
      {
        /**
         * Bind handler to elements
         * @protected
         */
        _bind: function () {

          var switchMethod = this.options.switchMethod,
            thumbs = this.options.thumbs;

          if (this.options.isMagicZoom) {
            switchMethod = (switchMethod == 'click' ? 'btnclick' : switchMethod);
          }

          var switchThumbFn = $.proxy(this._switchThumb, this);
          for (var i = 0; i < thumbs.length; i++) {
            // BEGIN EDIT - Force user to click on video thumbnail, even if "Swap trigger: hover" is configured
            if ($(thumbs[i]).hasClass('video-selector')) {
              var videoThumbnail = $(thumbs[i]);
              videoThumbnail.attr('title', "Click to watch video");
              $mjs(thumbs[i]).jAddEvent('click'+' tap', switchThumbFn, 1);
              return;
            }
            // END EDIT
            $mjs(thumbs[i]).jAddEvent(switchMethod+' tap', switchThumbFn, 1);
          }
        },

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

(function ($, Drupal) {

  Drupal.behaviors.blockVideoTextExtras = {
    attach: function (context, settings) {

      if (window.location.pathname.startsWith('/admin'))
        return;

      $(context).find('.video-container').each((i, e) => $(e).attr('data-video-id', `video${i}`));

      let players = {};

      function initializePlayer(container) {
        const iframe = container.find('iframe')[0];
        const overlayImage = container.find('.overlay-image img');
        const videoId = container.data('video-id');

        players[videoId] = new YT.Player(iframe, {
          events: {
            onReady: function () {
              overlayImage.on('click', function () {
                showVideo(container);
                players[videoId].playVideo();
              });
            },
            onStateChange: function (event) {
              if (event.data === YT.PlayerState.PAUSED || event.data === YT.PlayerState.ENDED) {
                hideVideo(container);
              }
            }
          }
        });
      }

      function showVideo(container) {
        container.find('iframe').show();
        container.find('.overlay-image').hide();
      }

      function hideVideo(container) {
        container.find('iframe').hide();
        container.find('.overlay-image').show();
      }

      window.onYouTubeIframeAPIReady = function () {
        $('.video-container').each(function () {
          initializePlayer($(this));
        });
      };

    }
  };

})(jQuery, Drupal);

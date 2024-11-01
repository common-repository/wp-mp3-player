jQuery(function ($) {
    $(document).ready(function() {

        init();

    });
    $(document).on('widget-updated', function(){

        init();

    });
    $(document).on('widget-added', function(){

        init();

    });
    function init() {
	    $('.mp3_track_header').click(function() {
            var $details = $(this).parent().find('.mp3_track_details');
            if ( $details.hasClass( 'show' ) ) {
                $details.removeClass( 'show' ).addClass( 'hidden' );
				$(this).find('span').removeClass('icon_collapse').addClass('icon_expand');
            } else if ( $details.hasClass( 'hidden' ) ) {
                $details.removeClass( 'hidden' ).addClass( 'show' );
				$(this).find('span').removeClass('icon_expand').addClass('icon_collapse');
            }
        });
	    $('.mp3_delete_track').click(function() {
            var $container = $(this).parents('.mp3_track_container');
            $container.find('.widefat').val('');
            $container.find('.mp3_track_details').removeClass( 'show' ).addClass( 'hidden' );
			var track_id = $(this).data("id");
			$container.find('.mp3_track_header').html('<span class="icon_expand"></span><strong>' + ("00" + track_id).slice(-2) + '</strong>. <em class="lolite">empty</em>')
        });
    }
});

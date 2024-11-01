<?php
/*
Plugin Name: WP Mp3 Player
Description: Sidebar audio player, responsive, cross-browser and user-friendly.
Author: Neil Hillman
Version: 1.01
Author URI: http://www.neilhillman.com/
Plugin URI: http://www.neilhillman.com/to-be-announced/
*************************************/

// Creating the widget 
class mp3_player_widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      // Base ID of your widget
      'wp_mp3_widget', 

      // Widget name will appear in UI
      __('Mp3 Player', 'wp_mp3_widget_domain'), 

      // Widget description
      array( 'description' => __( 'Sidebar audio player, responsive, cross-browser.', 'wp_mp3_widget_domain' ), ) 
    );
  }

  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
    $widget_title = apply_filters( 'widget_title', $instance['widget_title'] );

    // before widget defined by themes
    echo $args['before_widget'];

    if ( ! empty( $widget_title ) ) {
      echo $args['before_title'] . $widget_title . $args['after_title'];
    }
    ?>
      <audio preload></audio>
      <ol class="mp3_playlist">
        <?php
        for ( $x = 0; $x < 50; $x++ ) {
          if ( ! empty( $instance['track_title'][$x] ) && ! empty( $instance['track_url'][$x] ) ) {
            echo "<li><a href='#' data-src='" . $instance['track_url'][$x] . "'>" . $instance['track_title'][$x] . "</a></li>\n";
	  }
	}
        ?>
      </ol>

    <?php
    // after widget defined by themes
    echo $args['after_widget'];
  }

  // Widget Backend 
  public function form( $instance ) {

    if ( isset( $instance[ 'widget_title' ] ) ) {
      $widget_title = $instance[ 'widget_title' ];
    } else {
      $widget_title = __( 'Mp3 Player', 'mp3_widget_domain' );
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><strong><?php _e( 'Widget title:' ); ?></strong></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text" value="<?php echo esc_attr( $widget_title ); ?>" />
    </p>
    <p class="no_bottom_margin">
      <label><strong><?php _e( 'Playlist:' ); ?></strong></label> 
    </p>
    <div class="tracklist">
      <?php
      $track_title = array();
      $track_url = array();
      $track_num = 0;
      $show_one = true;
      for ( $x = 0; $x < 50; $x++ ) {
        if ( isset( $instance['track_title'][$x] ) ) {
          $track_title[$x] = $instance['track_title'][$x];
        } else {
          $track_title[$x] = '';
	}
        if ( isset( $instance['track_url'][$x] ) ) {
          $track_url[$x] = $instance['track_url'][$x];
        } else {
          $track_url[$x] = '';
        }
        if ( !empty( $track_title[$x] ) && !empty( $track_url[$x] ) ) {
          ?>
          <div class="mp3_track_container" data-name="track_<?php echo $x; ?>">
            <div class="mp3_track_header">
              <span class="icon_expand"></span>
              <strong><?php echo str_pad( ($x+1), 2, "0", STR_PAD_LEFT); ?></strong>. <?php echo esc_attr( $track_title[$x] ); ?>
            </div>
            <div class="mp3_track_details hidden">
              <p>
                <label for="<?php echo $this->get_field_id( 'track_'.$x.'_title' ); ?>"><strong><?php _e( 'Track title:' ); ?></strong></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'track_'.$x.'_title' ); ?>" name="<?php echo $this->get_field_name( 'track_'.$x.'_title' ); ?>" type="text" value="<?php echo esc_attr( $track_title[$x] ); ?>" />
              </p>
              <p class="no_bottom_margin">
                <label for="<?php echo $this->get_field_id( 'track_'.$x.'_mp3' ); ?>"><strong><?php _e( 'Mp3 file:' ); ?></strong> <em class="lolite"><?php _e( '(absolute path, http://&hellip;)' ); ?></em></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'track_'.$x.'_mp3' ); ?>" name="<?php echo $this->get_field_name( 'track_'.$x.'_mp3' ); ?>" type="text" value="<?php echo esc_attr( $track_url[$x] ); ?>" />
              </p>
              <p class="no_top_margin">
                <a href="#" class="mp3_delete_track" data-id="<?php echo ($x+1);?>"><?php _e( 'Remove track' ); ?></a>
              </p>
            </div>
	  </div>
          <?php
	  $track_num++;
        } else {
	  if ( $show_one ) {
            ?>
            <div class="mp3_track_container" data-name="track_<?php echo $x; ?>">
              <div class="mp3_track_header">
                <span class="icon_collapse"></span>
                <strong><?php echo str_pad( ($x+1), 2, "0", STR_PAD_LEFT); ?></strong>. <em class="lolite">add a new track&hellip;</em>
              </div>
              <div class="mp3_track_details show">
                <p>
                  <label for="<?php echo $this->get_field_id( 'track_'.$x.'_title' ); ?>"><strong><?php _e( 'Track title:' ); ?></strong></label> 
                  <input class="widefat" id="<?php echo $this->get_field_id( 'track_'.$x.'_title' ); ?>" name="<?php echo $this->get_field_name( 'track_'.$x.'_title' ); ?>" type="text" value="<?php echo esc_attr( $track_title[$x] ); ?>" />
                </p>
                <p>
                  <label for="<?php echo $this->get_field_id( 'track_'.$x.'_mp3' ); ?>"><strong><?php _e( 'Mp3 file:' ); ?></strong> <em class="lolite"><?php _e( '(absolute path, http://&hellip;)' ); ?></em></label> 
                  <input class="widefat" id="<?php echo $this->get_field_id( 'track_'.$x.'_mp3' ); ?>" name="<?php echo $this->get_field_name( 'track_'.$x.'_mp3' ); ?>" type="text" value="<?php echo esc_attr( $track_url[$x] ); ?>" />
                </p>
              </div>
            </div>
            <?php
            $track_num++;
            $show_one = false;
          }
        }
      }
      ?>
    </div>
    <?php
  }
	
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {

    $instance = array();
    $instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ? strip_tags( $new_instance['widget_title'] ) : '';

    $instance['track_title'] = array();
    $instance['track_url'] = array();
    $track_num = 0;
    for ( $x = 0; $x < 50; $x++ ) {
      if ( ! empty( $new_instance['track_'.$x.'_title'] ) && ! empty( $new_instance['track_'.$x.'_mp3'] ) ) {
        $instance['track_title'][$track_num] = ( ! empty( $new_instance['track_'.$x.'_title'] ) ) ? strip_tags( $new_instance['track_'.$x.'_title'] ) : '';
        $instance['track_url'][$track_num] = ( ! empty( $new_instance['track_'.$x.'_mp3'] ) ) ? strip_tags( $new_instance['track_'.$x.'_mp3'] ) : '';
        $track_num++;
      }
    }
    return $instance;
  }
}
/* CLASS ENDS HERE
-------------------------------------------------*/

// Register and load the widget
function mp3_widget_load() {

  register_widget( 'mp3_player_widget' );

}
add_action( 'widgets_init', 'mp3_widget_load' );

// Register and load additional frontend scripts
function mp3_widget_additional_scripts() {

  wp_register_style( 'mp3_widget-style', plugins_url('assets/css/wp-mp3-style.css', __FILE__) );
  wp_enqueue_style( 'mp3_widget-style' );

  wp_enqueue_script( 'jquery' );

  wp_register_script('mp3_widget-audiojs', plugins_url('assets/audiojs/audio.min.js' , __FILE__ ), array('jquery'));
  wp_enqueue_script('mp3_widget-audiojs');

  wp_register_script('mp3_widget-script', plugins_url('assets/js/wp-mp3-script.js' , __FILE__ ), array('jquery'));
  wp_enqueue_script('mp3_widget-script');
			
}
add_action('wp_enqueue_scripts','mp3_widget_additional_scripts');

// Register and load additional admin scripts
function mp3_widget_admin_scripts( $hook ) {

    /* CODE TO ONLY EXECUTE ON "WIDGETS" PAGE */
    /*----------------------------------------*/
    if( 'widgets.php' != $hook )
        return;
    /*----------------------------------------*/

        wp_register_style( 'mp3_widget-admin-style', plugins_url('assets/css/wp-mp3-admin.css', __FILE__) );
        wp_enqueue_style( 'mp3_widget-admin-style' );

        wp_register_script('mp3_widget-admin-script', plugins_url('assets/js/wp-mp3-admin.js' , __FILE__ ), array( 'jquery' ), false, true);
        wp_enqueue_script('mp3_widget-admin-script');

        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-accordion');
}
add_action('admin_enqueue_scripts','mp3_widget_admin_scripts');
?>

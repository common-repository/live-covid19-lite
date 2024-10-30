<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/**
 * LCOVID_Country_Widget
 * @package live-covid
 * @author Chandan Kumar
 * @version 1.0.0
 */

class LCOVID_Country_Widget extends WP_Widget {
    
    /*
    * Text Domains
    */
    private $td = 'live-covid';
    
    function __construct() {
 
        parent::__construct(
            'lcvad-country',  // Base ID
            'COVID19 Single Country Data'   // Name
        );
 
    }
 
    public $args = array(
        'before_title'  => '<h4 class="lcvad-widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
 
        echo $args['before_widget'];
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        
        $country = ( !empty($instance['country']) ) ? $instance['country'] : 'USA';
        $all_cases = ["confirms","deaths","recovered"];
        $covid = new LCOVID_Utils();
        $attrs = [
                'show_title'=> ( !empty( $instance['show_title'] ) && $instance['show_title'] ) ? true : false,
                'separator' => ( !empty( $instance['separator'] ) &&  $instance['separator']) ? true : false,
                'delimiter' => ( !empty( $instance['separator'] ) &&  $instance['separator']) ? ',' : '',
                'counter'   => ( !empty( $instance['counter'] ) &&  $instance['counter'] ) ? true : false,
                'duration'  => 3000
        ];

        foreach ($all_cases as $value) {
            $attrs[$value] = $instance["is_$value"];
            if(! empty( $instance["is_$value"] ) && $instance["is_$value"]){
                $attrs["title_$value"] = $instance["title_$value"];
            }
        }
        $pageData = array('attrs' => $attrs, 'data' => $covid->getCountry_data( $country ));
        echo lcvad_templates('lcvad_counters',$pageData);
 
 
        echo $args['after_widget'];
 
    }
 
    public function form( $instance ) {
        
        $defaults = array(
        'title'    => '',
        'country'    => '',
        'show_title'    => '',
        'is_confirms'     => '',
        'title_confirms'     => '',
        'is_deaths' => '',
        'title_deaths' => '',
        'is_recovered'   => '',
        'title_recovered'   => '',
        'counter'   => '',
        'separator'   => ''
        );

       extract( wp_parse_args( ( array ) $instance, $defaults ) );
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Widget Title:', $this->td ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'country' ); ?>"><?php _e( 'Select Country', $this->td ); ?></label>
        <select name="<?php echo $this->get_field_name( 'country' ); ?>" id="<?php echo $this->get_field_id( 'country' ); ?>" class="widefat">
        <?php 
        $options = LCOVID_Utils::CountryList();

        foreach ( $options as $key => $name ) {
            echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $country, $key, false ) . '>'. $name . '</option>';

        } ?>
        </select>
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php echo esc_html__( 'Enable Case Title:', $this->td ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_title ); ?> />
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'is_confirms' ) ); ?>"><?php _e( 'Show Confirm Cases', $this->td ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'is_confirms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_confirms' ) ); ?>" type="checkbox" value="yes" <?php checked( 'yes', $is_confirms ); ?> />
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title_confirms' ) ); ?>"><?php _e( 'Title of Confirm Cases', $this->td ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'title_confirms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_confirms' ) ); ?>" type="text" value="<?php echo esc_attr( $title_confirms ); ?>" />
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'is_deaths' ) ); ?>"><?php _e( 'Show Deaths', $this->td ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'is_deaths' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_deaths' ) ); ?>" type="checkbox" value="yes" <?php checked( 'yes', $is_deaths ); ?> />
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title_deaths' ) ); ?>"><?php _e( 'Title of Deaths', $this->td ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'title_deaths' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_deaths' ) ); ?>" type="text" value="<?php echo esc_attr( $title_deaths ); ?>" />
        </p>
        

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'is_recovered' ) ); ?>"><?php _e( 'Show Recovered', $this->td ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'is_recovered' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_recovered' ) ); ?>" type="checkbox" value="yes" <?php checked( 'yes', $is_recovered ); ?> />
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title_recovered' ) ); ?>"><?php _e( 'Title of Recovered', $this->td ); ?></label>
         <input class="" id="<?php echo esc_attr( $this->get_field_id( 'title_recovered' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_recovered' ) ); ?>" type="text" value="<?php echo esc_attr( $title_recovered ); ?>" />
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'counter' ) ); ?>"><?php _e( 'Enable Counter', $this->td ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'counter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $counter ); ?> />
        </p>

         <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>"><?php _e( 'Enable Thousand Separator', $this->td ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'separator' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $separator ); ?> />
        </p>
       
        <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();
 
        $instance['title']         = ( !empty( $new_instance['title'] ) ) ?  $new_instance['title']  : '';
        $instance['country']         = isset( $new_instance['country'] ) ? wp_strip_all_tags( $new_instance['country'] ) : '';
        $instance['show_title']    = isset( $new_instance['show_title'] ) ? 1 : false;
        $instance['is_confirms']      = isset( $new_instance['is_confirms'] ) ? 'yes' : false;
        $instance['title_confirms']      = ( !empty( $new_instance['title_confirms'] ) ) ? $new_instance['title_confirms'] : '';
        $instance['is_deaths']        = isset( $new_instance['is_deaths'] ) ? 'yes' : false;
        $instance['title_deaths']        = ( !empty( $new_instance['title_deaths'] ) ) ? $new_instance['title_deaths'] : '';
        $instance['is_recovered']     = isset( $new_instance['is_recovered'] ) ? 'yes' : false;
        $instance['title_recovered']     = ( !empty( $new_instance['title_recovered'] ) ) ? $new_instance['title_recovered'] : '';
        
        $instance['counter']       = isset( $new_instance['counter'] ) ? true : false;
        $instance['separator']     = isset( $new_instance['separator'] ) ? true : false;
        return $instance;
    }
 
}

?>
<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/**
 * Shortcode Class 
 * @package live-covid
 * @author Chandan Kumar
 * @version 1.0.0
 */

if( !class_exists('LCOVID_Shortcode') ){
    class LCOVID_Shortcode{
    	
    	function __construct()
    	{
    		add_shortcode( 'lcovid-table', array($this,'table_data') );
    		add_shortcode( 'lcovid-global', array($this,'global_data') );
    		add_shortcode( 'lcovid-country', array($this,'country_data') );
    	}

    	public function table_data($atts){
    		ob_start();
    		$covid = new LCOVID_Utils();
    		$attrs = shortcode_atts( array(
    			'flag'	  => 'no',	
    	        'sorting' => 'yes',
                'separator' => 'no',
                'delimiter' => ',',
                'confirms' => 'yes',
                'title_confirms' =>  _('Confirms'),
                'deaths' => 'yes',
                'title_deaths' => _('Deaths'),
                'recovered'     => 'yes',
                'title_recovered' => _('Recovered')
    	    ), $atts );

    		$pageData = array( 'attrs' => $attrs, 'data' => $covid->getAllCountry_data() );
            echo lcvad_templates('lcvad_table',$pageData);
    		return ob_get_clean();
    	}

    	public function global_data($atts){
    		ob_start();
            $covid = new LCOVID_Utils();
    		$attrs = shortcode_atts( array(
    	        'show_title' => 'yes',
    	        'counter' => false,
    	        'duration' => 300,
    	        'delimiter' => ',',
    	        'separator' => 'no',
    	        'confirms' => 'yes',
                'title_confirms' =>  _('Confirms'),
                'deaths' => 'yes',
                'title_deaths' => _('Deaths'),
                'recovered' => 'yes',
                'title_recovered' => _('Recovered')
    	    ), $atts );

            $pageData = array( 'attrs' => $attrs, 'data' => $covid->getWorld_data() );
            echo lcvad_templates('lcvad_counters',$pageData);
    		return ob_get_clean();
    	}

    	public function country_data($atts){
    		ob_start();
    		$covid = new LCOVID_Utils( );
    		$attrs = shortcode_atts( array(
    			'country' => 'USA',
    	        'show_title' => 'yes',
    	        'delimiter' => ',',
    	        'separator' => 'no',
    	        'counter' => false,
    	        'duration' => 300,
    	        'confirms' => 'yes',
                'title_confirms' =>  _('Confirms'),
                'deaths' => 'yes',
                'title_deaths' => _('Deaths'),
                'recovered' => 'yes',
                'title_recovered' => _('Recovered')
    	    ), $atts );

            $pageData = array('attrs' => $attrs, 'data' => $covid->getCountry_data( $attrs['country'] ));
            echo lcvad_templates('lcvad_counters',$pageData);
            return ob_get_clean();
    	}
    }
}
new LCOVID_Shortcode();


?>
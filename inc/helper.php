<?php
/*
* This file keeps plugin's own helper functions
*/

if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');


if(!function_exists('lcvad_templates')){
	/*
	* Call the templates files
	* All template files should be php files and in plugin_root/templates/ folder 
	*
	* @param string $file_name (file name without extension).
	* @param array 	$prmt (Data in array if want to sent to template file)
	*
	*/
	function lcvad_templates($file_name,$prmt=false){
		include_once(LIVE_COVID_LTE_DIR . '/templates/'.$file_name.'.php');
		$file_name($prmt);
	}
}

if(!function_exists('lcvad_js_dependency')){
	/*
	* Specific js file will be include
	* Js file should be registered before include the file through this function
	*
	* @param string $js_dep  (file name without extension)
	*
	*/
	function lcvad_js_dependency( $js_dep = array() ){
		if(is_array($js_dep)){
			foreach ($js_dep as  $value) {
				wp_enqueue_script( $value );
			}
		}else{
			if( !empty($js_dep) ){
				wp_enqueue_script( $js_dep );
			}
		}
	}
}

if(!function_exists('lcvad_num_separator')){
	/*
	* Add thousand separator to numeric value if char isn't provided of false
	*
	* @param int $num 
	* @param string $char ( delimiter for thousand separator )
	*
	* @return int|string
	*/
	function lcvad_num_separator( $num, $char = false ){
		return ($char) ? number_format( (int)$num ,false,'',$char) : $num ;
	}
}

if(!function_exists('lcvad_get_site_domain_name')){
	/*
	* Get Domain Name of the current site
	*
	* @return string host name of the site
	*/
	function lcvad_get_site_domain_name(){
		return $_SERVER['HTTP_HOST'];
	}
}

?>
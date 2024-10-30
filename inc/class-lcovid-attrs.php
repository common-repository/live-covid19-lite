<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/**
 * LCOVID_Attrs
 * @package live-covid
 * @author Chandan Kumar
 * @version 1.0.0
 */

class LCOVID_Attrs{

	public $attrs;

	private $filter_prefix = null;

	public $cases;

	public function __construct($attrs = null) {
		$this->cases = [ 'confirms', 'deaths', 'recovered'];
		$this->attrs = $attrs;
	}

	public function set_filter_prefix($prefix){
		$this->filter_prefix = sprintf('%s',$prefix);
	}

	public function var( $var , $def = false){
		return ( is_array($this->attrs) && isset($this->attrs[$var]) ) ? $this->attrs[$var] : false;
	}

	public function enable( $var ){
		return ( $this->var($var) == 'yes' || $this->var($var) === true ) ? true : false;
	}

	public function filters( $var ){
		if(!$this->filter_prefix) return _('filter_prefix should be assign t before use the filter method');
		return apply_filters( $this->filter_prefix.$var, $this->var($var) );
	}


}

?>

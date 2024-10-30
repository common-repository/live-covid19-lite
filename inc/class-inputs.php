<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/**
 * LOVID_Inputs
 * @package live-covid
 * @author Chandan Kumar
 * @version 1.0.0
 */

class LCOVID_Inputs{

	public $type;

	private $attr;

	private $def_attributes;
	
	public function __construct() {
		$this->def_attributes = [
			'id'	=> '',
	        'type'    => 'text',
	        'name'    => '',
	        'attrs'     => '',
	        'value'     => '1',
	        'options'	=> '',
	        'conditions'     => '',
	        'default'     => ''
		];
	}

	public function create($args){
		if( !isset($args['name']) ) return false;
		$this->set_attrs($args);
		$this->type = $this->attr['type'];
		$this->setInput($this->attr);
	}

	private function setInput($attr){
		
		if( !empty($attr['conditions']) ){
			$attr['attrs'] = ( empty($attr['attrs']) ) ? ['data-show' => esc_attr(json_encode($attr['conditions'])) ] :  array_merge($attr['attrs'],['data-show' => esc_attr(json_encode($attr['conditions'])) ]);
		}
		if( !empty($attr['default']) ){
			$attr['attrs'] = ( empty($attr['attrs']) ) ? ['data-default' => $attr['default'] ] :  array_merge($attr['attrs'],['data-default' => $attr['default'] ]);
		}
		if( !empty($attr['attrs']) ){
			$attr['attrs'] = $this->html_attrs($attr['attrs']);
		}

		switch ($this->type) {
			case 'checkbox':
				 	$this->checkbox($attr);
				break;
			case 'select':
				  $this->select($attr);
				break;

			default:
				$this->def_inputs($attr);
				break;
		}
	}

	protected function set_attrs($attr){
		$this->attr = wp_parse_args( ( array ) $attr, $this->def_attributes );
	}

	private function html_attrs($attrs = array()){
        return  implode(' ', array_map( function ($v, $k) { 
                                                return sprintf("%s='%s'", $k,$v); 
                                            },
                                            $attrs,
                                            array_keys($attrs)
                    ));
    }

	protected function checkbox($thisattr){
		extract($thisattr);
		$value = ( !empty($value) ) ? $value : '1';
		printf( '<input type="checkbox" id="%s" name="%s" value="%s" %s %s />',esc_attr( $id ),esc_attr( $name ),esc_attr( $value),checked( 'yes', $value ,false) ? 'checked' : '',  $attrs ); 
	}

	protected function select($thisattr){
		extract($thisattr);
		echo "<select id=".esc_attr($id)." name=".esc_attr($name)." $attrs >";
        foreach ($options as $key => $val) {
            printf('<option value="%s" %s>%s</option>',esc_attr($key),selected( $value , $key ,false) ? 'selected' : '',esc_attr($val));
        }
        echo '</select>';
	}

	protected function def_inputs($thisattr){
		extract($thisattr);
	
		printf( '<input type="%s" id="%s" name="%s" value="%s" %s />',esc_attr( $type ),esc_attr( $id ),esc_attr( $name ),esc_attr( $value),$attrs);
	}

	
}

?>

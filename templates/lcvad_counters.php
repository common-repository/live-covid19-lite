<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/*
* Template for Counters
*
* @param array 	$atts (Data in array if want to sent to this template)
*/
if( !function_exists('lcvad_counters') ){
	function lcvad_counters($atts){
		extract($atts);

		$attr = new LCOVID_Attrs($attrs);
		$attr->set_filter_prefix('lcvad_global_title');
		$attrs_string = [
						'delimiter' => $attr->var('delimiter'),
						'counter' 	=> $attr->var('counter'),
						'dur' 		=> $attr->var('duration')
				];
		
		$classes = array( 'lcvad-global', 'lcvad-numbers' , 'lcvad-row'  );
		$classes[] = ($attr->var('source')) ? $attr->var('source') : 'lcavad-def-container'; 

		if($attr->var('counter')){
			lcvad_js_dependency( 'lcvad-numerator' );
		}

		?>
		<div class=" <?php esc_attr_e(implode(' ',$classes)) ?>" data-attrs="<?php esc_attr_e( json_encode( $attrs_string ) ) ?>">
			<?php
				foreach ($attr->cases as $case) {
					if($attr->enable($case)) : ?>
						<div class="lcvad-col">
							<div class="lcvad-number-wrapper">
				                <span class="lcvad-number-prefix"><?php echo $attr->var('prefix'); ?></span>
				                <span class="lcvad-number" data-to-value="<?php esc_attr_e( $data[$case] )?>"> 
				                	<?php
				                	if($attr->var('counter')){
				                		esc_html_e( $attr->enable('separator') ? 0 : $data[$case] );
				                	}else{
				                		esc_html_e( $attr->enable('separator') ? lcvad_num_separator( $data[$case], $attr->var('delimiter')) : $data[$case]  );
				                	}
				                	?>    
				                </span>
				                <span class="lcvad-number-suffix"><?php echo $attr->var('suffix'); ?></span>
				            </div>
				            <?php if ( $attr->enable('show_title') ): ?>
				                <div class="lcvad-number-title"><?php echo $attr->var("title_$case"); ?></div>
				            <?php endif; ?>
						</div>
					<?php endif;
				}
			?>
		</div>
		<?php
	}
}
?>
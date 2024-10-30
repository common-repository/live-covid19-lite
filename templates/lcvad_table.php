<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/*
* Template for Data Table
*
* @param array 	$atts (Data in array if want to sent to this template)
*/
if( !function_exists('lcvad_table') ){
	function lcvad_table($atts){
		extract($atts);

		$attr = new LCOVID_Attrs($attrs);
		
		$classes = array( 'lcvad-table' );
		$classes[] = ($attr->var('source')) ? $attr->var('source') : 'lcavad-def-container'; 
		
		$sp = ( $attr->enable('separator') ) ?  $attr->var('delimiter') : false;
		
		// initiate Actions
		$pdf = $csv = $print = $sorting = false;


		if( $attr->enable('sorting') ){
			$sorting = true;
			$classes[] = 'lcvad-sorting';
		}


		// Assign Actions to Table //
		$tbl_actions = [ 'sorting' => $sorting];


		?>
		<div class="<?php esc_attr_e(implode(' ',$classes)) ?>" data-actions="<?php esc_attr_e( json_encode( $tbl_actions) ) ?>">
			<div class="lcvad-buttons">
				<input type="text" name="search" class="lcvad-right" placeholder="Search">
			</div>
			<div class="lcvad-table-wrapper">
				<table class="lcvad-table lcvad-datatbl" id="lcvad-<?php echo uniqid()?>">
					<thead>
						<tr>
						<th><?php _e('Country/Region') ?> </th>
						<?php
							foreach ($attr->cases as $case) {
								echo ( $attr->enable($case) ) ? sprintf('<th>%s</th>',$attr->var("title_$case") ) : '';
							}
						?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $val) : ?>
						<tr>
							<td><?php echo ( $attr->enable('flag') ) ? sprintf('<img src="%s"  height="10" width="15" />',$val['countryInfo']['flag']) : ''; echo $val['country']; ?></td>
							<?php 
							foreach ($attr->cases as $case) {
							echo ($attr->enable($case)) ? sprintf('<td>%s</td>',lcvad_num_separator($val[$case],$sp )) : '';
							}
							?>
						</tr>
						<?php endforeach ; ?>
					</tbody>
				</table>
			</div>
		</div>
		
		<?php
	}
}

?>
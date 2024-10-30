
<?php

if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/*
* Template for `Pro Features` tab of admin sections
*
* @param array 	$atts (Data in array if want to sent to this template)
*/
if( !function_exists('lcovid_pro_features') ){
	function lcovid_pro_features($atts){
		?>
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder">
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div id="dashboard_quick_press" class="postbox ">
							<div class="inside lcovid-card">
								<h2>File Exports</h2>
								<p class="lcovid-icons">
									<img title="PDF" src="<?php echo trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE ).'assets/img/pdf.svg' ?>" width="50" height="50">
									<img title="Excel" src="<?php echo trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE ).'assets/img/excel.svg' ?>" width="50" height="50">
									<img title="Print" src="<?php echo trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE ).'assets/img/print.svg' ?>" width="50" height="50">
								</p>
								<p>Data Exports with PDF, Print and Excel format</p>
								<a target="_blank" href="<?php echo esc_url('https://www.wpmentals.com/live-covid19')?>" class="lcovid-btn"><?php esc_html_e( 'Go Pro', 'live-covid' )  ?></a>
							</div>
						</div>
					</div>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div id="dashboard_quick_press" class="postbox ">
							<div class="inside lcovid-card">
								<h2>Extra Cases</h2>
								<p class="lcovid-icons">
									<img title="Extra Cases" src="<?php echo trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE ).'assets/img/tests.svg' ?>" width="50" height="50">
								</p>
								<p>Number of Test and Active cases</p>
								<a target="_blank" href="<?php echo esc_url('https://www.wpmentals.com/live-covid19')?>" class="lcovid-btn"><?php esc_html_e( 'Go Pro', 'live-covid' )  ?></a>
							</div>
						</div>
					</div>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div id="dashboard_quick_press" class="postbox ">
							<div class="inside lcovid-card">
								<h2>New Cases</h2>
								<p class="lcovid-icons">
									<img title="New Cases" src="<?php echo trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE ).'assets/img/new-case.svg' ?>" width="50" height="50">
								</p>
								<p>New/Today confirm cases and New/Today death cases</p>
								<a target="_blank" href="<?php echo esc_url('https://www.wpmentals.com/live-covid19')?>" class="lcovid-btn"><?php esc_html_e( 'Go Pro', 'live-covid' )  ?></a>
							</div>
						</div>
					</div>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div id="dashboard_quick_press" class="postbox ">
							<div class="inside lcovid-card">
								<h2>Donate to this Plugin</h2>
								<p class="lcovid-icons">
									<img title="New Cases" src="<?php echo trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE ).'assets/img/donate.svg' ?>" width="50" height="50">
								</p>
								<a target="_blank" href="<?php echo esc_url('https://www.paypal.me/chandankumargouda')?>" class="lcovid-btn"><?php esc_html_e( 'Donate', 'live-covid' )  ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

?>
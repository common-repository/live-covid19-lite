<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

if( !class_exists('LCOVID_Settings') ){
    class LCOVID_Settings{
        /**
         * Directory of the plugin
         * @var string
         */
        public $plugin_dir;
        /**
         * Holds the values to be used in the fields callbacks
         */
        private $options;

        /*
        * Text Domains
        */
        private $td = 'live-covid';

        /**
         * Holds the current tab section
         */
        private $current_tab;

        /**
         * Static Singleton Holder
         * @var self
         */
        protected static $instance;

        /**
         * Start up
         */
            /**
         * Get (and instantiate, if necessary) the instance of the class
         *
         * @return self
         */
        public static function instance() {
            if ( ! self::$instance ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        protected function __construct(){
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

        /**
         * Add options page
         */
        public function add_plugin_page(){
            // This page will be under "Settings"
            $this->plugin_dir = trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE );
            add_options_page(
                'Live COVID19', 
                'Live COVID19', 
                'manage_options', 
                'lcovid-settings', 
                array( $this, 'create_admin_page' )
            );

        }

        /**
         * Options page callback
         */
        public function create_admin_page(){
            // Set class property
            $this->current_tab = $current = (isset($_GET['tab'])) ? $_GET['tab'] : 'lcovid_shortcodes';
            $this->options = get_option( $current );
            $tabs = [
                                    'lcovid_shortcodes'  =>  'Shortcode Generator',
                                    'lcovid_pro'  =>  'Pro Features'
                                  ]
            ?>
            <div class="wrap">
                <h1>Live COVID19 LTE</h1>
                 <h2 class="nav-tab-wrapper">
                     <?php 
                        foreach( $tabs as $tab => $tab_name ){
                            $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                            echo "<a class='nav-tab$class' href='?page=lcovid-settings&tab=$tab'>".$tab_name."</a>";
                        }
                     ?>
                </h2>
                <form method="post" action="options.php">
                <?php
                    switch ($current) {
                         case 'lcovid_pro':
                                echo $this->pro_features();
                            break;
                        
                        default:
                                settings_fields( 'lcovid_shortcodes' );
                                do_settings_sections( 'lcovid-shortrcodes-sec' );
                            break;
                    }
                    // This prints out all hidden setting fields
                    
                ?>
                </form>
            </div>
            <?php
        }

        public function admin_enqueue_scripts(){
            wp_enqueue_style( 'lcovid-admin-style', $this->plugin_dir.'assets/css/admin-style.css', '', '', 'all' );
            wp_enqueue_script('lcovid-admin-script', $this->plugin_dir.'assets/js/admin-script.js', array('jquery') );
        }

        /**
         * Register and add settings
         */
        public function page_init(){        

            $scGenSet = 'lcovid-shortrcodes-sec';
            $scGenSec = 'lcvad_shortcode_section';


            register_setting(
                'lcovid_shortcodes', // Option group
                'lcovid_shortcodes' // Option name
            );

            // Shortcode Generator Section

            add_settings_section( $scGenSec, '', '', $scGenSet );   

            add_settings_field( 'gn_shortcode', __('Generated Shortcode',$this->td), [ $this, 'generated_shortcode' ], $scGenSet, $scGenSec,['id' => 'gn_shortcode' ]);

            add_settings_field( 'shortcodes', __('Choose Shortcode',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'shortcodes',
                                'type' => 'select',
                                'options' =>  ['lcovid-global' => 'Global Data', 'lcovid-country' => 'Single Country', 'lcovid-table' => 'All Countries Table' ]
                         ]);    
         
            add_settings_field( 'country', __('Choose Country',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'country',
                                'type' => 'select',
                                'options' =>  LCOVID_Utils::CountryList(),
                                'conditions' => [ 'shortcodes' => 'lcovid-country' ]
            ]);

            add_settings_field( 'flag', __('Show National Flags',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'flag',
                                'default' => 'no',
                                'type' => 'checkbox',
                                'conditions' => [ 'shortcodes' => 'lcovid-table' ] 
            ]); 

            add_settings_field( 'show_title', __('Show Case Titles',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'show_title',
                                'default' => 'yes',
                                'type' => 'checkbox'
            ]); 

            add_settings_field( 'confirms', __('Show Confirm Cases',$this->td), [$this,'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'confirms',
                                'default' => 'yes',
                                'type' => 'checkbox'
            ]);
            
            add_settings_field( 'title_confirms', __('Title Confirm Cases',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'title_confirms',
                                'default' => 'Confirms',
                                'conditions' => [ 'confirms' => 'yes', 'show_title' => 'yes' ] 
            ]);

            add_settings_field( 'deaths', __('Show Deaths',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'deaths',
                                'default' => 'yes',
                                'type' => 'checkbox'
            ]);

            add_settings_field( 'title_deaths', __('Title Deaths',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'title_deaths',
                                'default' => 'Deaths',
                                'conditions' => [ 'deaths' => 'yes', 'show_title' => 'yes' ] 
            ]);

            add_settings_field( 'recovered', __('Show Recovered',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'recovered',
                                'default' => 'yes',
                                'type' => 'checkbox'
            ]);

            add_settings_field( 'title_recovered', __('Title Recovered',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'title_recovered',
                                'default' => 'Recovered',
                                'conditions' => [ 'recovered' => 'yes', 'show_title' => 'yes' ] 
            ]);

            add_settings_field( 'counter', __('Enable Counter',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'counter',
                                'type' => 'checkbox'
            ]);

            add_settings_field( 'duration', __('Duration (in ms)',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'duration',
                                'type' => 'number',
                                'default' => 300,
                                'conditions' => [ 'counter' => 'yes' ]
            ]);

            add_settings_field( 'separator', __('Enable Thousand Separator',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'separator',
                                'type' => 'checkbox'
            ]);

            add_settings_field( 'delimiter', __('Choose Separator Delimiter',$this->td), [ $this, 'lcovid_inputs' ], $scGenSet, $scGenSec,[
                                'id' => 'delimiter',
                                'type' => 'select',
                                'options' =>  [',' => 'Comma', '.' => 'Dot', 'space' => 'Space' ],
                                'conditions' => [ 'separator' => 'yes' ]
            ]);

            add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_scripts'));
        }

         /** 
         * Print Shortcode Generated Input
         */

        public function generated_shortcode($args){
            $args = [
                    'type'  => 'text',
                    'id'    => $args['id'],
                    'name'  => $args['id'],
                    'attrs' => [ 'readonly' => true, 'class' => 'widefat' ],
                    'value'     => '[lcovid-global]'

            ];
            $inputs = new LCOVID_Inputs();
            $inputs->create($args);

            submit_button('Copy','primary','copy',false,['style' => 'position: absolute;right: 30px']);
        }

        public function pro_features(){
            echo lcvad_templates('lcovid_pro_features');
        }

        /** 
         * Print the Section Inputs
         */

        public function lcovid_inputs($args){
            $current = $this->current_tab;
            $id = $args['id'];

            $args['type'] = (isset($args['type'])) ? $args['type'] : 'text';
            $args['value'] = ( isset( $this->options[$id] ) ) ? $this->options[$id] : (( isset( $args['default']) ) ? $args['default'] : '');
            $args['name'] = ( isset($args['id']) ) ? sprintf('%s[%s]',$current,$id) : '';
            $args['attrs']['class'] = ( isset($args['attrs']['class']) ) ? $args['attrs']['class'].' lcovid-inputs' : 'lcovid-inputs';
            
            $inputs = new LCOVID_Inputs();
            $inputs->create($args);
        }

    }
}


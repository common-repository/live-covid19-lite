<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

use \Elementor\Frontend;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Plugin;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class LCOVID_Country_Elem_Widget extends Widget_Base {

    /*
    * Text Domains
    */
    private $td = 'live-covid';

    /**
     * Get widget name.
     *
     * Retrieve Menu widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'lcvad-country';
    }

    /**
     * Get widget title.
     *
     * Retrieve Menu widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'COVID19 : Single Country', $this->td );
    }

    /**
     * Get Menu icon.
     *
     * Retrieve Menu widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-bug';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    /**
     * Retrieve the list of scripts the counter widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'jquery-numerator' ];
    }

    /**
     * Register counter widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_counter',
            [
                'label' => __( 'General', $this->td )
            ]
        );

        $this->add_control(
            'country',
            [
                'label' => __( 'Select Country', $this->td ),
                'type' => Controls_Manager::SELECT,
                'default' => 'USA',
                'options' => LCOVID_Utils::CountryList()
            ]
        );

        $this->add_responsive_control(
            'prefix',
            [
                'label' => __( 'Number Prefix', $this->td ),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->add_responsive_control(
            'suffix',
            [
                'label' => __( 'Number Suffix', $this->td ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __( '+', $this->td )
            ]
        );

         $this->add_responsive_control(
            'show_title',
            [
                'label' => __( 'Show Title', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Show', $this->td ),
                'label_off' => __( 'Hide', $this->td )
            ]
        );

        $this->add_responsive_control(
            'is_counter',
            [
                'label' => __( 'Counter', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Yes', $this->td ),
                'label_off' => __( 'No', $this->td )
            ]
        );

        $this->add_control(
            'counter_dur',
            [
                'label' => __('Counter Duration', $this->td),
                'description' => __('Duration of Numerator (in ms)', $this->td),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'is_counter' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'thousand_separator',
            [
                'label' => __( 'Thousand Separator', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Show', $this->td ),
                'label_off' => __( 'Hide', $this->td )
            ]
        );

        $this->add_control(
            'thousand_separator_char',
            [
                'label' => __( 'Separator', $this->td ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'thousand_separator' => 'yes',
                ],
                'options' => [
                    ',' => 'Comma',
                    '.' => 'Dot',
                    ' ' => 'Space',
                ],
                'default' => ','
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'confirms',
            [
                'label' => __( 'Confirm Cases', $this->td ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_responsive_control(
            'is_confirms',
            [
                'label' => __( 'Show Confirm Cases', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Show', $this->td ),
                'label_off' => __( 'Hide', $this->td )
            ]
        );
        $this->add_control(
            'title_confirms',
            [
                'label' => __( 'Confirm Cases Title', $this->td ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'is_confirms' => 'yes',
                    'show_title' => 'yes'
                ],
                'default' => __( 'Total Cases', $this->td )
            ]
        );

        $this->add_control(
            'todayconfirms_pro',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-nerd-box">' .
                        '<div class="elementor-nerd-box-message">' .
                            __( 'Meet New Cases/ Today Cases on', 'elementor' ) .
                        '</div>
                        <div class="elementor-nerd-box-message">' .
                            __( 'Live COVID19 Pro', 'elementor' ) .
                        '</div>
                        <a target="_blank" style="background-color : #2446CC" class="elementor-nerd-box-message elementor-button elementor-button-default" href="'.esc_url('https://www.wpmentals.com/live-covid19').'">' .
                            __( 'Go Pro', 'elementor' ) .
                        '</a>
                        </div>',

            ]
        );
        $this->end_controls_section();

         $this->start_controls_section(
            'deaths',
            [
                'label' => __( 'Deaths', $this->td ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

         $this->add_responsive_control(
            'is_deaths',
            [
                'label' => __( 'Show Death', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Show', $this->td ),
                'label_off' => __( 'Hide', $this->td )
            ]
        );
        $this->add_control(
            'title_deaths',
            [
                'label' => __( 'Deaths Title', $this->td ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'is_deaths' => 'yes',
                    'show_title' => 'yes'
                ],
                'default' => __( 'Total Deaths', $this->td )
            ]
        );

        $this->add_control(
            'todaydeaths_pro',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-nerd-box">' .
                        '<div class="elementor-nerd-box-message">' .
                            __( 'Meet New Deaths/ Today deaths on', 'elementor' ) .
                        '</div>
                        <div class="elementor-nerd-box-message">' .
                            __( 'Live COVID19 Pro', 'elementor' ) .
                        '</div>
                        <a target="_blank" style="background-color : #2446CC" class="elementor-nerd-box-message elementor-button elementor-button-default" href="'.esc_url('https://www.wpmentals.com/live-covid19').'">' .
                            __( 'Go Pro', 'elementor' ) .
                        '</a>
                        </div>',

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'recovered',
            [
                'label' => __( 'Recovered', $this->td ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_responsive_control(
            'is_recovered',
            [
                'label' => __( 'Show Recovered', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Show', $this->td ),
                'label_off' => __( 'Hide', $this->td )
            ]
        );
         $this->add_control(
            'title_recovered',
            [
                'label' => __( 'Recovered Title', $this->td ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'is_recovered' => 'yes',
                    'show_title' => 'yes'
                ],
                'default' => __( 'Total Recovered', $this->td )
            ]
        );

        $this->end_controls_section();

         $this->start_controls_section(
            'active',
            [
                'label' => __( 'Active Cases', $this->td ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'active_pro',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-nerd-box">' .
                        '<i class="elementor-nerd-box-icon eicon-hypster" aria-hidden="true"></i>
                        <div class="elementor-nerd-box-message">' .
                            __( 'This feature is only available on', 'elementor' ) .
                        '</div>
                        <div class="elementor-nerd-box-message">' .
                            __( 'Live COVID19 Pro', 'elementor' ) .
                        '</div>
                        <a target="_blank" style="background-color : #2446CC" class="elementor-nerd-box-message elementor-button elementor-button-default" href="'.esc_url('https://www.wpmentals.com/live-covid19').'">' .
                            __( 'Go Pro', 'elementor' ) .
                        '</a>
                        </div>',

            ]
        );

        $this->end_controls_section();

         $this->start_controls_section(
            'tests',
            [
                'label' => __( 'Number of Tests', $this->td ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'tests_pro',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-nerd-box">' .
                        '<i class="elementor-nerd-box-icon eicon-hypster" aria-hidden="true"></i>
                        <div class="elementor-nerd-box-message">' .
                            __( 'This feature is only available on', 'elementor' ) .
                        '</div>
                        <div class="elementor-nerd-box-message">' .
                            __( 'Live COVID19 Pro', 'elementor' ) .
                        '</div>
                        <a target="_blank" style="background-color : #2446CC" class="elementor-nerd-box-message elementor-button elementor-button-default" href="'.esc_url('https://www.wpmentals.com/live-covid19').'">' .
                            __( 'Go Pro', 'elementor' ) .
                        '</a>
                        </div>',

            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_number',
            [
                'label' => __( 'Number', $this->td ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => __( 'Text Color', $this->td ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcvad-number-wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_number',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .lcvad-number-wrapper',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Title', $this->td ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', $this->td ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcvad-number-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .lcvad-number-title',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render counter widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $all_cases = ["confirms","deaths","recovered"];
        $country = ( !empty($settings['country']) ) ? $settings['country'] : 'USA';

        $covid = new LCOVID_Utils( );
        $attrs = [
                'show_title'=> ( !empty( $settings['show_title'] ) ) ? true : false,
                'separator' => ( !empty( $settings['thousand_separator'] ) ) ? true : false,
                'delimiter' => ( !empty( $settings['thousand_separator'] ) ) ? $settings['thousand_separator_char'] : false,
                'counter'   => ( !empty( $settings['is_counter'] ) ) ? true : false,
                'duration'  => ( !empty( $settings['is_counter'] ) ) ? $settings['counter_dur'] : false,
                'prefix'    => ( !empty( $settings['prefix'] ) ) ? $settings['prefix'] : false,
                'suffix'     => ( !empty( $settings['suffix'] ) ) ? $settings['suffix'] : false,
                'source'    => 'elem-container'
        ];

        foreach ($all_cases as $value) {
            $attrs[$value] = $settings["is_$value"];
            if(! empty( $settings["is_$value"] )){
                $attrs["title_$value"] = $settings["title_$value"];
            }
        }
        $pageData = array('attrs' => $attrs, 'data' => $covid->getCountry_data( $country ));
        echo lcvad_templates('lcvad_counters',$pageData);
    }

}

?>
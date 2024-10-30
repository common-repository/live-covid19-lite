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
class LCOVID_Country_Table_Elem_Widget extends Widget_Base {

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
        return 'lcvad-table';
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
        return __( 'COVID 19 : ALL Countries Table', 'elem-nav-expert' );
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
        return [  ];
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
            'show_flags',
            [
                'label' => __( 'Show Flags', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', $this->td ),
                'label_off' => __( 'Hide', $this->td )
            ]
        );

        $this->add_control(
            'sort',
            [
                'label' => __( 'Sort', $this->td ),
                'type' => Controls_Manager::SELECT,
                'default' => 'confirms',
                'options' => [
                    'confirms'         => 'Confirms',
                    'deaths'        => 'Deaths',
                    'recovered'     => 'Recovered'
                ]
            ]
        );

         $this->add_control(
            'table_sorting',
            [
                'label' => __( 'Table Sorting', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', $this->td ),
                'label_off' => __( 'No', $this->td )
            ]
        );

        $this->add_control(
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
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'confirms',
            [
                'label' => __( 'Confirms', $this->td ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
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
                ],
                'default' => __( 'Total Confirms', $this->td )
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

         $this->add_control(
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

        $this->add_control(
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
            'section_style',
            [
                'label' => __( 'Table', $this->td ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'full_table',
            [
                'label' => __( 'Full Table', $this->td ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
                'label_on' => __( 'Yes', $this->td ),
                'label_off' => __( 'No', $this->td )
            ]
        );
        $this->add_responsive_control(
            'table_height',
            [
                'label' => __( 'Table Height', $this->td ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','vh'],
                'conditions' => [
                        'terms' => [
                                [
                                    'name' => 'full_table',
                                    'operator' => '!in',
                                    'value' => [
                                        'yes',
                                    ],
                                ],
                            ],
                ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 10000,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcvad-table-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'table_header_color',
            [
                'label' => __( 'Header Color', $this->td ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} table thead' => 'background: {{VALUE}};',
                    '{{WRAPPER}} table thead th' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .lcvad-table-wrapper::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lcvad-table-wrapper::-webkit-scrollbar' => 'background-color: {{VALUE}};'
                   
                ],
                'default' => '#555'
            ]
        );
        $this->add_control(
            'table_header_text_color',
            [
                'label' => __( 'Header Text Color', $this->td ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} table thead th' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcvad-sorting th:after' => 'border-top-color: {{VALUE}}',
                    '{{WRAPPER}} .lcvad-sorting th:before' => 'border-bottom-color: {{VALUE}}'
                ],
                'default' => '#fff'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_header_text_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} table th',
            ]
        );

        $this->add_control(
            'table_column_color',
            [
                'label' => __( 'Column Color', $this->td ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} table tbody tr:nth-child(even)' => 'background: {{VALUE}};',
                ],
                'default' => '#ccc'
            ]
        );
        $this->add_control(
            'table_column_text_color',
            [
                'label' => __( 'Column Text Color', $this->td ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} table tbody td' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_column_text_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} table tbody td',
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render counter widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _content_template() {
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

        $covid = new LCOVID_Utils();
        $attrs = array(
            'source'  => 'elem-container',
            'flag'    => $settings['show_flags'],
            'sorting' => $settings['table_sorting'],
            'separator' => ( !empty( $settings['thousand_separator'] ) ) ? true : false,
            'delimiter' => ( !empty( $settings['thousand_separator'] ) ) ? $settings['thousand_separator_char'] : false,
        );

        foreach ($all_cases as $value) {
            $attrs[$value] = $settings["is_$value"];
            if(! empty( $settings["is_$value"] ) && $settings["is_$value"]){
                $attrs["title_$value"] = $settings["title_$value"];
            }
        }
        $pageData = array('attrs' => $attrs, 'data' => $covid->getAllCountry_data(array('sort' => $settings['sort'])));
        echo lcvad_templates('lcvad_table',$pageData);
        ?>
        <?php
    }

}

?>
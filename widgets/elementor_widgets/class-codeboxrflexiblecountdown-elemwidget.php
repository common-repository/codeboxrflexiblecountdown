<?php

namespace CodeboxrFlexibleCountdownElemWidget\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * CBX Flexible Countdown Elementor Widget
 */
class CodeboxrFlexibleCountdown_ElemWidget extends Widget_Base
{

    /**
     * Retrieve google maps widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'cbfc_elemwidget';
    }

    /**
     * Retrieve google maps widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('CBX Flexible Countdown', 'codeboxrflexiblecountdown');
    }

    /**
     * Get widget categories.
     *
     * Retrieve the widget categories.
     *
     * @return array Widget categories.
     * @since  1.0.10
     * @access public
     *
     */
    public function get_categories()
    {
        return array('codeboxr');
    }

    /**
     * Retrieve google maps widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-countdown';
        //return 'cbfc-elementor-icon';
    }

    /**
     * Register google maps widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls()
    {


        do_action('cbfc_elementor_fields_start', $this);

        $this->start_controls_section(
            'section_cbfc_general',
            array(
                'label' => esc_html__('CBX Flexible Countdown', 'codeboxrflexiblecountdown'),
            )
        );

        $this->add_control(
            'type',
            array(
                'label'       => esc_html__('Countdown Style', 'codeboxrflexiblecountdown'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'default'     => 'light',
                'placeholder' => esc_html__('Select countdown style', 'codeboxrflexiblecountdown'),
                'options'     => \CBFCHelper::getCountdownStyles()
            )
        );

        $this->add_control(
            'date',
            array(
                'label'          => esc_html__('Launch Date', 'codeboxrflexiblecountdown'),
                'type'           => \Elementor\Controls_Manager::DATE_TIME,
                'default'        => \CBFCHelper::getDefaultDate('Y-m-d'),
                'picker_options' => array(
                    'enableTime' => true
                )
            )
        );
        $this->add_control(
            'hour',
            array(
                'label'   => esc_html__('Launch Hour', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 0
            )
        );
        $this->add_control(
            'minute',
            array(
                'label'   => esc_html__('Launch Minutes', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 0
            )
        );

        $this->add_control(
            'hide_sec',
            array(
                'label'        => esc_html__('Hide Second', 'codeboxrflexiblecountdown'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'codeboxrflexiblecountdown'),
                'label_off'    => esc_html__('No', 'codeboxrflexiblecountdown'),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_cbfc_light',
            array(
                'label' => esc_html__('Light Countdown Settings', 'codeboxrflexiblecountdown'),
            )
        );


        $this->add_control(
            'l_numclr',
            array(
                'label'   => esc_html__('Count Number Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#333'
            )
        );

        $this->add_control(
            'l_resnumclr',
            array(
                'label'   => esc_html__('Count Number Color (On Responsive)', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#333'
            )
        );

        $this->add_control(
            'l_numbgclr',
            array(
                'label'   => esc_html__('Count Number Background Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#eaeaea'
            )
        );

        $this->add_control(
            'l_textclr',
            array(
                'label'   => esc_html__('Text Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff'
            )
        );

        $this->add_control(
            'l_restextclr',
            array(
                'label'   => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff'
            )
        );

        $this->add_control(
            'l_textbgclr',
            array(
                'label'   => esc_html__('Text Background Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5832b'
            )
        );

        $this->end_controls_section();
        //End Light Countdown


        //Circular Countdown
        $this->start_controls_section(
            'section_cbfc_circular',
            array(
                'label' => esc_html__('Circular Countdown Settings', 'codeboxrflexiblecountdown'),
            )
        );


        $this->add_control(
            'c_secbclr',
            array(
                'label'   => esc_html__('Seconds Border Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff6386'
            )
        );

        $this->add_control(
            'c_minbclr',
            array(
                'label'   => esc_html__('Minutes Border Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#00c1c1'
            )
        );

        $this->add_control(
            'c_hourbclr',
            array(
                'label'   => esc_html__('Hours Border Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffcf4a'
            )
        );

        $this->add_control(
            'c_daybclr',
            array(
                'label'   => esc_html__('Days Border Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#00a3ee'
            )
        );

        $this->add_control(
            'c_bgclr',
            array(
                'label'   => esc_html__('Background Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff'
            )
        );

        $this->add_control(
            'c_textclr',
            array(
                'label'   => esc_html__('Count Number And Text Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#3B1D82'
            )
        );

        $this->add_control(
            'c_restextclr',
            array(
                'label'   => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#333'
            )
        );


        $this->add_control(
            'c_borderw',
            array(
                'label'   => esc_html__('Circle Border Width', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 8
            )
        );

        $this->end_controls_section();
        //End Circular Countdown

        //KK Countdown
        $this->start_controls_section(
            'section_cbfc_kk',
            array(
                'label' => esc_html__('KK Countdown Settings', 'codeboxrflexiblecountdown'),
            )
        );

        $this->add_control(
            'kk_fontsize',
            array(
                'label'   => esc_html__('Countdown Font Size', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 30
            )
        );

        $this->add_control(
            'kk_numclr',
            array(
                'label'   => esc_html__('Countdown Number Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#3767b9'
            )
        );

        $this->add_control(
            'kk_textclr',
            array(
                'label'   => esc_html__('Countdown Text Color', 'codeboxrflexiblecountdown'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#666333'
            )
        );

        $this->end_controls_section();

        do_action('cbfc_elementor_fields_end', $this);
    }

    /**
     * Convert yes/no to boolean on/off
     *
     * @param  string  $value
     *
     * @return string
     */
    public static function yes_no_to_on_off($value = '')
    {
        if ($value === 'yes') {
            return 'on';
        }

        return 'off';
    }//end yes_no_to_on_off

    /**
     * Convert yes/no switch to boolean 1/0
     *
     * @param  string  $value
     *
     * @return int
     */
    public static function yes_no_to_1_0($value = '')
    {
        if ($value === 'yes') {
            return 1;
        }

        return 0;
    }//end yes_no_to_1_0


    /**
     * Render google maps widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        if ( ! class_exists('CBFC_Settings_API')) {
            require_once plugin_dir_path(dirname(dirname(__FILE__))).'includes/class-codeboxrflexiblecountdown-setting.php';
        }

        $settings_api = new \CBFC_Settings_API();


        $settings = $this->get_settings();

        $attr = array();

        $type = sanitize_text_field($settings['type']);
        $date = sanitize_text_field($settings['date']);

        if ($date == '') {
            $date   = \CBFCHelper::getDefaultDate();
            $hour   = 0;
            $minute = 0;
        } else {

            $date   = explode(" ", $date);
            $hr_min = isset($date[1]) ? $date[1] : '';
            $date   = isset($date[0]) ? $date[0] : '';

            if ($date != '') {
                $date = explode('-', $date);

                $date = $date[1].'/'.$date[2].'/'.$date[0]; //formatted to m/d/Y from y-m-d
            } else {
                $date = \CBFCHelper::getDefaultDate();
            }

            if ($hr_min != '') {
                $hr_min = explode(":", $hr_min);

                $hour   = isset($hr_min[0]) ? intval($hr_min[0]) : 0;
                $minute = isset($hr_min[1]) ? intval($hr_min[1]) : 0;
            } else {
                $hour   = 0;
                $minute = 0;
            }
        }


        $attr = array(
            //default setting
            'type'     => $type,
            'date'     => $date,
            'hour'     => $hour,
            'minute'   => $minute,
            'hide_sec' => $this->yes_no_to_on_off($settings['hide_sec'])
        );

        //light setting
        if ($type == 'light') {
            $attr['l_numclr']     = sanitize_text_field($settings['l_numclr']);//light number color
            $attr['l_resnumclr']  = sanitize_text_field($settings['l_resnumclr']);//light number responsive color
            $attr['l_numbgclr']   = sanitize_text_field($settings['l_numbgclr']);// light number background color
            $attr['l_textclr']    = sanitize_text_field($settings['l_textclr']);//light text color
            $attr['l_restextclr'] = sanitize_text_field($settings['l_restextclr']);    //light text responsive color
            $attr['l_textbgclr']  = sanitize_text_field($settings['l_textbgclr']);//light text background
        }

        //circular setting
        if ($type == 'circular') {
            $attr['c_secbclr']    = sanitize_text_field($settings['c_secbclr']);//sec border color(circular)
            $attr['c_minbclr']    = sanitize_text_field($settings['c_minbclr']);// min border  color(circular)
            $attr['c_hourbclr']   = sanitize_text_field($settings['c_hourbclr']);//hour border color(circular)
            $attr['c_daybclr']    = sanitize_text_field($settings['c_daybclr']);//days border color(circular)
            $attr['c_bgclr']      = sanitize_text_field($settings['c_bgclr']);//canvas background color(circular)
            $attr['c_textclr']    = sanitize_text_field($settings['c_textclr']);//count number and text color(circular)
            $attr['c_restextclr'] = sanitize_text_field($settings['c_restextclr']);//text color on responsive(circular)
            $attr['c_borderw']    = sanitize_text_field($settings['c_borderw']);//text color on responsive(circular)
        }

        //kk setting
        if ($type == 'kk') {
            $attr['kk_fontsize'] = intval($settings['kk_fontsize']);//kk font size
            $attr['kk_numclr']   = sanitize_text_field($settings['kk_numclr']);    //kk count down number color
            $attr['kk_textclr']  = sanitize_text_field($settings['kk_textclr']);//kk countdown text color
        }


        $attr = apply_filters('cbfc_elementor_shortcode_builder_attr', $attr, $settings);

        $attr_html = '';

        foreach ($attr as $key => $value) {
            $attr_html .= ' '.$key.'="'.$value.'" ';
        }

        echo do_shortcode('[cbfccountdown '.$attr_html.']');

    }//end render

    /**
     * Render google maps widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _content_template()
    {
    }
}//end class CodeboxrFlexibleCountdown_ElemWidget

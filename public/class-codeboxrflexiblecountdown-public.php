<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codeboxr.com/
 * @since      1.0.0
 *
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/public
 * @author     Codeboxr <info@codeboxr.com>
 */
class CodeboxrFlexibleCountdown_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * The setting ref of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $settings_api;

    /**
     * Initialize the class and set its properties.
     *
     * @param  string  $plugin_name  The name of the plugin.
     * @param  string  $version  The version of this plugin.
     *
     * @since    1.0.0
     *
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

        //get instance of setting api
        $this->settings_api = new CBFC_Settings_API();
    }//end of constructor

    /**
     * Add this public method for getting countdown using shortcode
     *
     * @return mixed|void
     * @since    1.0.0
     *
     */
    public function get_flexible_countdown($atts)
    {

        $setting = $this->settings_api;

        $general_settings  = get_option('cbfc_general_settings', array());
        $light_settings    = get_option('cbfc_light_settings', array());
        $circular_settings = get_option('cbfc_circular_settings', array());
        $kk_settings       = get_option('cbfc_kk_settings', array());


        $attr = shortcode_atts(array(
            //default setting
            'type'         => CBFCHelper::get_option('type', $general_settings, 'light'),
            'date'         => CBFCHelper::get_option('date', $general_settings, CBFCHelper::getDefaultDate()),
            //'start_date'   => CBFCHelper::get_option( 'date', $general_settings, CBFCHelper::getDefaultDate() ),
            'hour'         => CBFCHelper::get_option('hour', $general_settings, 0),
            'minute'       => CBFCHelper::get_option('min', $general_settings, 0),
            //light setting
            'l_numclr'     => CBFCHelper::get_option('num_color', $light_settings, '#333'),
            //light number color
            'l_resnumclr'  => CBFCHelper::get_option('res_num_color', $light_settings, '#333'),
            //light number responsive color
            'l_numbgclr'   => CBFCHelper::get_option('num_bg_color', $light_settings, '#eaeaea'),
            // light number background color
            'l_textclr'    => CBFCHelper::get_option('text_color', $light_settings, '#fff'),
            //light text color
            'l_restextclr' => CBFCHelper::get_option('res_text_color', $light_settings, '#fff'),
            //light text responsive color
            'l_textbgclr'  => CBFCHelper::get_option('text_bg_color', $light_settings, '#f5832b'),
            //light text background
            //circular setting
            'c_secbclr'    => CBFCHelper::get_option('sec_color', $circular_settings, '#ff6386'),
            //sec border color(circular)
            'c_minbclr'    => CBFCHelper::get_option('min_color', $circular_settings, '#00c1c1'),
            // min border  color(circular)
            'c_hourbclr'   => CBFCHelper::get_option('hour_color', $circular_settings, '#ffcf4a'),
            //hour border color(circular)
            'c_daybclr'    => CBFCHelper::get_option('day_color', $circular_settings, '#00a3ee'),
            //days border color(circular)
            'c_bgclr'      => CBFCHelper::get_option('canvas_color', $circular_settings, '#ffffff'),
            //canvas background color(circular)
            'c_textclr'    => CBFCHelper::get_option('text_color', $circular_settings, '#3B1D82'),
            //count number and text color(circular)
            'c_restextclr' => CBFCHelper::get_option('res_text_color', $circular_settings, '#7995D5'),
            //text color on responsive(circular)
            'c_borderw'    => CBFCHelper::get_option('border_width', $circular_settings, '8'),
            //text color on responsive(circular)
            //kk setting
            'kk_fontsize'  => CBFCHelper::get_option('font_size', $kk_settings, '30'),
            //kk font size
            'kk_numclr'    => CBFCHelper::get_option('num_color', $kk_settings, '#3767b9'),
            //kk count down number color
            'kk_textclr'   => CBFCHelper::get_option('text_color', $kk_settings, '#666333'),

            //common for any
            //'hide_sec'  => CBFCHelper::get_option( 'display', $light_settings, 0 ),
            'hide_sec'     => CBFCHelper::get_option('hide_sec', $general_settings, 'off'),

            //kk countdown text color
        ), $atts, 'cbfccountdown');


        $attr['hide_sec'] = CBFCHelper::on_off_to_10($attr['hide_sec']);

        return CBFCHelper::getFlexibleCountdownHtml($attr);
    }//end get_flexible_countdown

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_register_style('codeboxrflexiblecountdown-public',
            plugin_dir_url(__FILE__).'../assets/css/codeboxrflexiblecountdown-public.css',
            array(),
            $this->version,
            'all');

        wp_enqueue_style('codeboxrflexiblecountdown-public');
    }//end enqueue_styles

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        $translation_strings = array(
            'kkc_day'  => esc_html__('day', 'codeboxrflexiblecountdown'),
            'kkc_days' => esc_html__('days', 'codeboxrflexiblecountdown'),
            'kkc_hr'   => esc_html__('h', 'codeboxrflexiblecountdown'),
            'kkc_min'  => esc_html__('m', 'codeboxrflexiblecountdown'),
            'kkc_sec'  => esc_html__('s', 'codeboxrflexiblecountdown'),
        );

        wp_register_script('codeboxrflexiblecountdown-public',
            plugin_dir_url(__FILE__).'../assets/js/codeboxrflexiblecountdown-public.js',
            array('jquery'),
            $this->version,
            true);
        wp_localize_script('codeboxrflexiblecountdown-public', 'cbfc_strings', $translation_strings);
        wp_enqueue_script('codeboxrflexiblecountdown-public');
    }//end enqueue_scripts

    /**
     * Init shortcodes
     */
    public function init_shortcodes()
    {
        add_shortcode('cbfccountdown', array($this, 'get_flexible_countdown'));
    }//end init_shortcodes

    /**
     * Register widget
     */
    public function init_widgets()
    {
        register_widget("CodeboxrFlexibleCountdownWidget");
    }//end init_widgets

    /**
     * Init elementor widget
     *
     * @throws Exception
     */
    public function init_elementor_widgets()
    {
        //include the file
        require_once plugin_dir_path(dirname(__FILE__)).'widgets/elementor_widgets/class-codeboxrflexiblecountdown-elemwidget.php';

        //register the widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CodeboxrFlexibleCountdownElemWidget\Widgets\CodeboxrFlexibleCountdown_ElemWidget());
    }//end widgets_registered

    /**
     * Add new category to elementor
     *
     * @param $elements_manager
     */
    public function add_elementor_widget_categories($elements_manager)
    {
        $elements_manager->add_category(
            'codeboxr',
            array(
                'title' => esc_html__('Codeboxr Widgets', 'codeboxrflexiblecountdown'),
                'icon'  => 'fa fa-plug',
            )
        );
    }//end add_elementor_widget_categories

    /**
     * Load Elementor Custom Icon
     */
    function elementor_icon_loader()
    {
        wp_register_style('cbfc_elementor_icon',
            CBFC_PLUGIN_ROOT_URL.'widgets/elementor_widgets/elementor-icon/icon.css', false, '1.0.0');
        wp_enqueue_style('cbfc_elementor_icon');
    }//end elementor_icon_loader

    /**
     * // Before VC Init
     */
    public function vc_before_init_actions()
    {

        if ( ! class_exists('CBFC_VCParam_DatePicker')) {
            require_once CBFC_PLUGIN_ROOT_PATH.'widgets/vc_element/params/class-cbfc-vc-param-datepicker.php';
        }

        if ( ! class_exists('CodeboxrFlexibleCountdown_WPBWidget')) {
            require_once CBFC_PLUGIN_ROOT_PATH.'widgets/vc_element/class-codeboxrflexiblecountdown-wpbwidget.php';
        }


        new CodeboxrFlexibleCountdown_WPBWidget();
    }// end method vc_before_init_actions
}//end class CodeboxrFlexibleCountdown_Public

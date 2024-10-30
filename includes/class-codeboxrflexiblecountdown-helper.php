<?php
// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

/**
 * Class CBFCHelper
 *
 */
class CBFCHelper
{

    /**
     * @return mixed|void
     */
    public static function getCountdownStyles()
    {
        $styles = array(
            'light'    => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
            'circular' => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
            'kk'       => esc_html__('KK Countdown', 'codeboxrflexiblecountdown'),
        );

        return apply_filters('cbfc_countdown_styles', $styles);
    }

    /**
     * Get available style reverser
     *
     * @return mixed|void
     */
    public static function get_styles_r()
    {
        $styles   = CBFCHelper::getCountdownStyles();
        $styles_r = array();

        foreach ($styles as $key => $value) {
            $styles_r[$value] = $key;
        }

        return apply_filters('codeboxrflexiblecountdown_$styles_r', $styles_r);
    }//end get_styles_r

    /**
     * Block compatible countdown styles
     *
     * @return mixed|void
     */
    public static function getCountdownStylesBlocks()
    {
        $styles = CBFCHelper::getCountdownStyles();

        $styles_arr = array();
        foreach ($styles as $key => $value) {
            $styles_arr[] = array(
                'label' => $value,
                'value' => $key
            );
        }

        return apply_filters('cbfc_countdown_styles_blocks', $styles_arr);
    }//end getCountdownStylesBlocks


    /**
     * List all global option name with prefix cbxlatesttweets_
     */
    public static function getAllOptionNames()
    {
        global $wpdb;

        $prefix       = 'cbfc_';
        $option_names = $wpdb->get_results("SELECT * FROM {$wpdb->options} WHERE option_name LIKE '{$prefix}%'",
            ARRAY_A);

        return apply_filters('cbfc_option_names', $option_names);
    }//end getAllOptionNames

    /**
     * Return default date
     *
     * @param  string  $date_format
     *
     * @return string
     * @throws Exception
     */
    public static function getDefaultDate($date_format = 'm/d/Y')
    {

        $current_offset = get_option('gmt_offset');
        $tzstring       = get_option('timezone_string');

        $check_zone_info = true;

        // Remove old Etc mappings. Fallback to gmt_offset.
        if (false !== strpos($tzstring, 'Etc/GMT')) {
            $tzstring = '';
        }

        if (empty($tzstring)) { // Create a UTC+- zone if no timezone string exists
            $check_zone_info = false;
            if (0 == $current_offset) {
                $tzstring = '+0';
            } elseif ($current_offset < 0) {
                $tzstring = ''.$current_offset;
            } else {
                $tzstring = '+'.$current_offset;
            }
        }


        //three timezone types:  https://stackoverflow.com/questions/17694894/different-timezone-types-on-datetime-object/17711005#17711005
        $date_time_zone = new DateTimeZone($tzstring);

        $date_time_now = new DateTime('now', $date_time_zone);
        $one_week      = DateInterval::createFromDateString('1 week');
        $date_time_now->add($one_week);
        date_time_set($date_time_now, 0, 0, 0);


        return $date_time_now->format($date_format);
    }//end getDefaultDate

    /**
     * Get countdown
     *
     * @param  array  $attr
     * @param  bool  $echo
     *
     * @return mixed|void
     */
    public static function getFlexibleCountdown($attr, $echo = false)
    {
        $attr_html = '';

        foreach ($attr as $key => $value) {
            $attr_html .= ' '.$key.'="'.$value.'" ';
        }

        //$plugin_public = new CodeboxrFlexibleCountdown_Public( CBFC_PLUGIN_NAME, CBFC_PLUGIN_VERSION );

        /*if($echo == true) echo $plugin_public->get_flexible_countdown($attr);
        else return $plugin_public->get_flexible_countdown($attr);*/

        if ($echo == true) {
            echo do_shortcode('[cbfccountdown '.$attr_html.']');
        } else {
            return do_shortcode('[cbfccountdown '.$attr_html.']');
        }
    }//end getFlexibleCountdown

    /**
     * Return countdown style
     *
     * @param $attr
     *
     * @return string
     */
    public static function getFlexibleCountdownHtml($attr)
    {

        $countdown_html = '';

        if ($attr['type'] == '') {
            $attr['type'] = 'light';
        }

        $type = $attr['type'];


        if ($attr['type'] == 'cbfc_light' or $attr['type'] == 'light' or empty($attr['type'])) {
            //include css and js for light countdown
            //CBFCHelper::loadCBFCLightStyle();
            //CBFCHelper::loadCBFCLightJS();

            //CBFCHelper::loadCSS();
            //CBFCHelper::loadJS();

            static $cbfc_light_counter = 0;
            $cbfc_light_counter++;

            ob_start();

            //include( apply_filters('cbfccountdown_template', CBFC_PLUGIN_ROOT_PATH . 'templates/light.php', 'light', $attr) );
            include(cbfc_locate_template('light.php'));

            $countdown_html = ob_get_contents();
            ob_end_clean();

        } elseif ($attr['type'] == 'cbfc_circular' or $attr['type'] == 'circular') {
            //include css and js for circular countdown
            //CBFCHelper::loadCBFCCircularStyle();
            //CBFCHelper::loadCBFCCircularJS();

            //CBFCHelper::loadCSS();
            //CBFCHelper::loadJS();

            static $cbfc_circular_counter = 0;
            $cbfc_circular_counter++;
            ob_start();

            //include( apply_filters('cbfccountdown_template',CBFC_PLUGIN_ROOT_PATH . 'templates/circular.php', 'circular', $attr) );
            include(cbfc_locate_template('circular.php'));

            $countdown_html = ob_get_contents();
            ob_end_clean();
        } elseif ($attr['type'] == 'cbfc_kk' or $attr['type'] == 'kk') {
            //include css and js for kk countdown
            //CBFCHelper::loadCBFCKKStyle();
            //CBFCHelper::loadCBFCKKJS();

            //CBFCHelper::loadCSS();
            //CBFCHelper::loadJS();

            static $cbfc_kk_counter = 0;
            $cbfc_kk_counter++;
            ob_start();

            //include( apply_filters('cbfccountdown_template', CBFC_PLUGIN_ROOT_PATH . 'templates/kk.php', 'kk', $attr) );
            include(cbfc_locate_template('kk.php'));

            $countdown_html = ob_get_contents();
            ob_end_clean();
        }

        return apply_filters('cbfccountdown_html', $countdown_html, $attr);
    }//end getFlexibleCountdownHtml

    /**
     * Load light count down style
     */
    public static function loadCBFCLightStyle()
    {
        //wp_enqueue_style('cbfc-light-countdown');
    }//end loadCBFCLightStyle

    /**
     * Load light count down JS
     */
    public static function loadCBFCLightJS()
    {
        //wp_enqueue_script( 'cbfc-light-countdown');
        //wp_enqueue_script( 'codeboxrflexiblecountdown-public');
    }//end loadCBFCLightJS


    /**
     * Load circular count down style
     */
    public static function loadCBFCCircularStyle()
    {
        //wp_enqueue_style('cbfc-circular-countdown');
    }//end loadCBFCCircularStyle

    /**
     * Load light count down JS
     */
    public static function loadCBFCCircularJS()
    {
        //wp_enqueue_script( 'kinetic');
        //wp_enqueue_script( 'cbfc-circular-countdown');
        //wp_enqueue_script( 'codeboxrflexiblecountdown-public');
    }//end loadCBFCCircularJS

    /**
     * Load circular count down style
     */
    public static function loadCBFCKKStyle()
    {
        //wp_enqueue_style('cbfc-kk-countdown');
    }//end loadCBFCKKStyle

    /**
     * Load light count down JS
     */
    public static function loadCBFCKKJS()
    {
        //wp_enqueue_script( 'cbfc-kkcountdown-countdown');
        //wp_enqueue_script( 'codeboxrflexiblecountdown-public');
    }//end loadCBFCKKJS

    /**
     * Load all countdown styles
     */
    public static function loadCSS()
    {
        wp_enqueue_style('codeboxrflexiblecountdown-public');
    }//end loadCSS

    /**
     * Load all countdown js
     */
    public static function loadJS()
    {
        wp_enqueue_script('codeboxrflexiblecountdown-public');
    }//end loadJS

    /**
     * Get the value of a settings field
     *
     * @param  string  $option  settings field name
     * @param  array  $section  the section name this field belongs to
     * @param  string  $default  default text if it's not found
     *
     * @return string
     */
    public static function get_option($option, $section = array(), $default = '')
    {

        //$options = get_option( $section );

        if (isset($section[$option])) {
            return $section[$option];
        }

        return $default;
    }//end get_option


    /**
     * @param  string  $value
     *
     * @return int
     */
    public static function on_off_to_10($value = '')
    {
        if ($value === 'on') {
            return 1;
        }

        return 0;
    }//end on_off_to_10


    /**
     * Shortcode builder for display and copy paste purpose
     *
     * @param  array  $general_settings
     * @param  array  $light_settings
     * @param  array  $circular_settings
     * @param  array  $kk_settings
     * @param  string  $type
     *
     * @return string
     * @throws Exception
     */
    public static function shortcode_builder(
        $general_settings = array(),
        $light_settings = array(),
        $circular_settings = array(),
        $kk_settings = array(),
        $type = ''
    ) {

        $type = ($type == '') ? CBFCHelper::get_option('type', $general_settings, 'light') : $type;

        $attr = array(
            //default setting
            'type'     => $type,
            'date'     => CBFCHelper::get_option('date', $general_settings, CBFCHelper::getDefaultDate()),
            'hour'     => CBFCHelper::get_option('hour', $general_settings, 0),
            'minute'   => CBFCHelper::get_option('min', $general_settings, 0),
            'hide_sec' => CBFCHelper::get_option('hide_sec', $general_settings, 'off')//hide sec counter
        );

        //light setting
        if ($type == 'light') {
            $attr['l_numclr']     = CBFCHelper::get_option('num_color', $light_settings, '#333');//light number color
            $attr['l_resnumclr']  = CBFCHelper::get_option('res_num_color', $light_settings,
                '#333');//light number responsive color
            $attr['l_numbgclr']   = CBFCHelper::get_option('num_bg_color', $light_settings,
                '#ffffff');// light number background color
            $attr['l_textclr']    = CBFCHelper::get_option('text_color', $light_settings, '#fff');//light text color
            $attr['l_restextclr'] = CBFCHelper::get_option('res_text_color', $light_settings,
                '#fff');    //light text responsive color
            $attr['l_textbgclr']  = CBFCHelper::get_option('text_bg_color', $light_settings,
                '#00c1c1');//light text background
        }

        //circular setting
        if ($type == 'circular') {
            $attr['c_secbclr']    = CBFCHelper::get_option('sec_color', $circular_settings,
                '#ff6386');//sec border color(circular)
            $attr['c_minbclr']    = CBFCHelper::get_option('min_color', $circular_settings,
                '#00c1c1');// min border  color(circular)
            $attr['c_hourbclr']   = CBFCHelper::get_option('hour_color', $circular_settings,
                '#ffcf4a');//hour border color(circular)
            $attr['c_daybclr']    = CBFCHelper::get_option('day_color', $circular_settings,
                '#00a3ee');//days border color(circular)
            $attr['c_bgclr']      = CBFCHelper::get_option('canvas_color', $circular_settings,
                '#ffffff');//canvas background color(circular)
            $attr['c_textclr']    = CBFCHelper::get_option('text_color', $circular_settings,
                '#3B1D82');//count number and text color(circular)
            $attr['c_restextclr'] = CBFCHelper::get_option('res_text_color', $circular_settings,
                '#7995D5');//text color on responsive(circular)
            $attr['c_borderw']    = CBFCHelper::get_option('border_width', $circular_settings,
                '8');//text color on responsive(circular)
        }

        //kk setting
        if ($type == 'kk') {
            $attr['kk_fontsize'] = CBFCHelper::get_option('font_size', $kk_settings, '30');//kk font size
            $attr['kk_numclr']   = CBFCHelper::get_option('num_color', $kk_settings,
                '#00a3ee');    //kk count down number color
            $attr['kk_textclr']  = CBFCHelper::get_option('text_color', $kk_settings,
                '#00c1c1');//kk countdown text color

        }


        $attr = apply_filters('cbfc_shortcode_builder_attr', $attr);

        $attr_html = '';

        foreach ($attr as $key => $value) {
            $attr_html .= ' '.$key.'="'.$value.'" ';
        }

        return '[cbfccountdown '.$attr_html.']';
    }//end shortcode_builder

    /**
     * Add utm params to any url
     *
     * @param  string  $url
     *
     * @return string
     */
    public static function url_utmy($url = '')
    {
        if ($url == '') {
            return $url;
        }

        $url = add_query_arg(array(
            'utm_source'   => 'plgsidebarinfo',
            'utm_medium'   => 'plgsidebar',
            'utm_campaign' => 'wpfreemium',
        ), $url);

        return $url;
    }//end url_utmy
}//end class CBFCHelper
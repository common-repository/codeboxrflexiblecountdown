<?php
// Prevent direct file access
if ( ! defined('ABSPATH')) {
    exit;
}

class CBFC_VCParam_DatePicker
{
    /**
     * Initiator.
     */
    public function __construct()
    {
        if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
            if (function_exists('vc_add_shortcode_param')) {

                wp_register_style('jquery-ui',
                    plugin_dir_url(__FILE__).'../../../assets/css/ui-lightness/jquery-ui.min.css', array(),
                    CBFC_PLUGIN_VERSION);

                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-datepicker');
                vc_add_shortcode_param('cbfcdate', array($this, 'cbfcdate_render'));
            }
        } else {
            if (function_exists('add_shortcode_param')) {

                wp_register_style('jquery-ui',
                    plugin_dir_url(__FILE__).'../../../assets/css/ui-lightness/jquery-ui.min.css', array(),
                    CBFC_PLUGIN_VERSION);

                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-datepicker');
                add_shortcode_param('cbfcdate', array($this, 'cbfcdate_render'));
            }
        }
    }

    /**
     * Date Picker
     *
     * @param $settings
     * @param $value
     *
     * @return string
     */
    public function cbfcdate_render($settings, $value)
    {
        $dependency = '';
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type       = isset($settings['type']) ? $settings['type'] : '';
        $class      = isset($settings['class']) ? $settings['class'] : '';

        $uni    = uniqid('datetimepicker-'.wp_rand());
        $output = '<div id="cbfcdate-'.esc_attr($uni).'" class="cbfcdate"><input placeholder="mm/dd/yyyy" class=" datepicker cbfcdatepicker wpb_vc_param_value '.esc_attr($param_name).' '.esc_attr($type).' '.esc_attr($class).'" name="'.esc_attr($param_name).'" style="width:100%;" value="'.esc_attr($value).'" '.$dependency.'/></div>';

        $output .= '<script type="text/javascript">
 					jQuery( \'.cbfcdatepicker\' ).datepicker({
 						 dateFormat: \'mm/dd/yy\' 
					});
				</script>';

        return $output;
    }

}

new CBFC_VCParam_DatePicker();
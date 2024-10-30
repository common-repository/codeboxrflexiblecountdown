<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codeboxr.com/
 * @since      1.0.0
 *
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/includes
 * @author     Codeboxr <info@codeboxr.com>
 */
class CodeboxrFlexibleCountdown_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $cbfc_light_settings = get_option('cbfc_light_settings');

        //migration first check if light setting exists or not, if not then either fresh or old install
        if ($cbfc_light_settings === false) {

            //light setting doesn't exists, but still need to check if there was data previously stored
            $cbfc_general_settings = get_option('cbfc_general_settings');

            if ($cbfc_general_settings !== false) {
                //previous data exists but light setting doesn't exists, so need migration
                $cbfc_light_settings                   = array();
                $cbfc_light_settings['num_color']      = $cbfc_general_settings['cbfc_countdown_num_color'];
                $cbfc_light_settings['res_num_color']  = $cbfc_general_settings['cbfc_countdown_res_num_color'];
                $cbfc_light_settings['num_bg_color']   = $cbfc_general_settings['cbfc_countdown_num_bg_color'];
                $cbfc_light_settings['text_color']     = $cbfc_general_settings['cbfc_countdown_text_color'];
                $cbfc_light_settings['res_text_color'] = $cbfc_general_settings['cbfc_countdown_res_text_color'];
                $cbfc_light_settings['text_bg_color']  = $cbfc_general_settings['cbfc_countdown_text_bg_color'];

                //create new light setting from old setting
                update_option('cbfc_light_settings', $cbfc_light_settings);

                //unset unused field in general
                unset($cbfc_general_settings['cbfc_countdown_num_color']);
                unset($cbfc_general_settings['cbfc_countdown_res_num_color']);
                unset($cbfc_general_settings['cbfc_countdown_num_bg_color']);
                unset($cbfc_general_settings['cbfc_countdown_text_color']);
                unset($cbfc_general_settings['cbfc_countdown_res_text_color']);
                unset($cbfc_general_settings['cbfc_countdown_text_bg_color']);


                $cbfc_general_settings['type'] = str_replace('cbfc_',
                    '',
                    $cbfc_general_settings['cbfc_countdown_type']);
                $cbfc_general_settings['date'] = $cbfc_general_settings['cbfc_countdown_date'];
                $cbfc_general_settings['hour'] = $cbfc_general_settings['cbfc_countdown_hour'];
                $cbfc_general_settings['min']  = $cbfc_general_settings['cbfc_countdown_min'];

                unset($cbfc_general_settings['cbfc_countdown_type']);
                unset($cbfc_general_settings['cbfc_countdown_date']);
                unset($cbfc_general_settings['cbfc_countdown_hour']);
                unset($cbfc_general_settings['cbfc_countdown_min']);

                update_option('cbfc_general_settings', $cbfc_general_settings);

                $cbfc_circular_settings = get_option('cbfc_circular_settings');

                $cbfc_circular_settings['sec_color']      = $cbfc_circular_settings['cbfc_countdown_sec_color'];
                $cbfc_circular_settings['min_color']      = $cbfc_circular_settings['cbfc_countdown_mins_color'];
                $cbfc_circular_settings['hour_color']     = $cbfc_circular_settings['cbfc_countdown_hours_color'];
                $cbfc_circular_settings['day_color']      = $cbfc_circular_settings['cbfc_countdown_days_color'];
                $cbfc_circular_settings['canvas_color']   = $cbfc_circular_settings['cbfc_countdown_canvas_color'];
                $cbfc_circular_settings['text_color']     = $cbfc_circular_settings['cbfc_countdown_font_color']; //**
                $cbfc_circular_settings['res_text_color'] = $cbfc_circular_settings['cbfc_countdown_text_color']; //**
                $cbfc_circular_settings['border_width']   = 6; //added extra

                unset($cbfc_circular_settings['cbfc_countdown_sec_color']);
                unset($cbfc_circular_settings['cbfc_countdown_mins_color']);
                unset($cbfc_circular_settings['cbfc_countdown_hours_color']);
                unset($cbfc_circular_settings['cbfc_countdown_days_colo']);
                unset($cbfc_circular_settings['cbfc_countdown_canvas_color']);
                unset($cbfc_circular_settings['cbfc_countdown_font_color']);
                unset($cbfc_circular_settings['cbfc_countdown_text_color']);

                update_option('cbfc_circular_settings', $cbfc_circular_settings);

                $cbfc_kk_settings = get_option('cbfc_kk_settings');

                $cbfc_kk_settings['font_size']  = $cbfc_kk_settings['cbfc_countdown_countdown_font_size'];
                $cbfc_kk_settings['num_color']  = $cbfc_kk_settings['cbfc_countdown_countdown_color'];
                $cbfc_kk_settings['text_color'] = $cbfc_kk_settings['cbfc_countdown_countdown_text_color'];


                unset($cbfc_kk_settings['cbfc_countdown_countdown_font_size']);
                unset($cbfc_kk_settings['cbfc_countdown_countdown_color']);
                unset($cbfc_kk_settings['cbfc_countdown_countdown_text_color']);


                update_option('cbfc_kk_settings', $cbfc_kk_settings);

            }
        }

        set_transient('cbfc_activated_notice', 1);
    }//end activate
}//end class CodeboxrFlexibleCountdown_Activator

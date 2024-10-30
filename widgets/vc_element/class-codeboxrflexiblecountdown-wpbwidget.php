<?php
// Prevent direct file access
if ( ! defined('ABSPATH')) {
    exit;
}


class CodeboxrFlexibleCountdown_WPBWidget extends WPBakeryShortCode
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('init', array($this, 'bakery_shortcode_mapping'), 12);
    }// /end of constructor

    /**
     * Element Mapping
     */
    public function bakery_shortcode_mapping()
    {
        // Map the block with vc_map()
        vc_map(array(
            "name"        => esc_html__("CBX Flexible Countdown", 'codeboxrflexiblecountdown'),
            "description" => esc_html__("CBX Countdown Widget", 'codeboxrflexiblecountdown'),
            "base"        => "cbfccountdown",
            "icon"        => CBFC_PLUGIN_ROOT_URL.'assets/images/icon.png',
            "category"    => esc_html__('CBX Widgets', 'codeboxrflexiblecountdown'),
            "params"      => apply_filters('cbfc_wpbakery_params', array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Style', 'codeboxrflexiblecountdown'),
                        'param_name'  => 'type',
                        'admin_label' => true,
                        'value'       => CBFCHelper::get_styles_r(),
                        'std'         => 'light',
                    ),
                    array(
                        "type"        => "cbfcdate",
                        "class"       => "",
                        'admin_label' => true,
                        "heading"     => esc_html__('Launch Date', 'codeboxrflexiblecountdown'),
                        "param_name"  => "date",
                        "value"       => esc_html__('mm/dd/yyyy', 'codeboxrflexiblecountdown'),
                        'description' => esc_html__('Date format: mm/dd/yyyy', 'codeboxrflexiblecountdown'),
                        'std'         => CBFCHelper::getDefaultDate()
                    ),
                    array(
                        'type'       => 'textfield',
                        "class"      => "",
                        'heading'    => esc_html__('Launch Hour', 'codeboxrflexiblecountdown'),
                        'param_name' => 'hour',
                        'std'        => 0,
                    ),
                    array(
                        'type'       => 'textfield',
                        "class"      => "",
                        'heading'    => esc_html__('Launch Minute', 'codeboxrflexiblecountdown'),
                        'param_name' => 'minute',
                        'std'        => 0,
                    ),
                    array(
                        "type"        => "dropdown",
                        'admin_label' => true,
                        "heading"     => esc_html__("Hide Second", 'codeboxrflexiblecountdown'),
                        "param_name"  => "hide_sec",
                        'value'       => array(
                            esc_html__('Yes', 'codeboxrflexiblecountdown') => 'on',
                            esc_html__('No', 'codeboxrflexiblecountdown')  => 'off',
                        ),
                        'std'         => 'on',
                    ),

                    //Light Countdown
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Count Number Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'l_numclr',
                        'group'      => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#333',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Count Number Color (On Responsive)', 'codeboxrflexiblecountdown'),
                        'param_name' => 'l_resnumclr',
                        'group'      => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#333',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Count Number Background Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'l_numbgclr',
                        'group'      => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#eaeaea',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Text Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'l_textclr',
                        'group'      => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#fff',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                        'param_name' => 'l_restextclr',
                        'group'      => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#fff',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Text Background Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'l_textbgclr',
                        'group'      => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#f5832b',
                    ),
                    // end Light Countdown

                    //Circular Countdown
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Seconds Border Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_secbclr',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#ff6386',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Minutes Border Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_minbclr',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#00c1c1',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Hours Border Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_hourbclr',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#ffcf4a',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Days Border Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_daybclr',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#00a3ee',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Background Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_bgclr',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#ffffff',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Count Number And Text Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_textclr',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#3B1D82',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_restextclr',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#333',
                    ),
                    array(
                        'type'       => 'textfield',
                        "class"      => "",
                        'heading'    => esc_html__('Circle Border Width', 'codeboxrflexiblecountdown'),
                        'param_name' => 'c_borderw',
                        'group'      => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => 8,
                    ),
                    //End Circular Countdown

                    //KK Countdown
                    array(
                        'type'       => 'textfield',
                        "class"      => "",
                        'heading'    => esc_html__('Countdown Font Size', 'codeboxrflexiblecountdown'),
                        'param_name' => 'kk_fontsize',
                        'group'      => esc_html__('KK Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => 30,
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Countdown Number Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'kk_numclr',
                        'group'      => esc_html__('KK Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#3767b9',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        "class"      => "",
                        'heading'    => esc_html__('Countdown Text Color', 'codeboxrflexiblecountdown'),
                        'param_name' => 'kk_textclr',
                        'group'      => esc_html__('KK Countdown', 'codeboxrflexiblecountdown'),
                        'std'        => '#666333',
                    ),
                )
            )
        ));
    }//end bakery_shortcode_mapping
}// end class codeboxrflexiblecountdown_WPBWidget
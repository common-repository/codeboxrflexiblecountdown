<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codeboxr.com/
 * @since      1.0.0
 *
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/admin
 * @author     Codeboxr <info@codeboxr.com>
 */
class CodeboxrFlexibleCountdown_Admin
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
     * The setting of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $settings_api;

    /**
     * The plugin basename of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_basename The plugin basename of the plugin.
     */
    protected $plugin_basename;

    /**
     * Initialize the class and set its properties.
     *
     * @param  string  $plugin_name  The name of this plugin.
     * @param  string  $version  The version of this plugin.
     *
     * @since    1.0.0
     *
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

        $this->plugin_basename = plugin_basename(plugin_dir_path(__DIR__).$plugin_name.'.php');

        //get instance of setting api
        $this->settings_api = new CBFC_Settings_API();
    }

    /**
     * Add admin setting menu under setting
     */
    public function plugin_admin_menu()
    {
        add_options_page(
            esc_html__('CBX Flexible Countdown (CBFC)', 'codeboxrflexiblecountdown'),
            esc_html__('CBX Countdown', 'codeboxrflexiblecountdown'),
            'manage_options',
            'codeboxrflexiblecountdown',
            array($this, 'display_plugin_admin_page')
        );
    }//end plugin_admin_menu

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page()
    {
        $plugin_data = get_plugin_data(plugin_dir_path(__DIR__).'/../'.$this->plugin_basename);
        //include( 'partials/admin-settings-display.php' );


        $doc = isset($_REQUEST['codeboxrflexiblecountdown-help-support']) ? absint($_REQUEST['codeboxrflexiblecountdown-help-support']) : 0;

        if ($doc) {
            include(cbfc_locate_template('admin/dashboard.php'));
        } else {
            include(cbfc_locate_template('admin/admin-settings-display.php'));
        }
    }//end display_plugin_admin_page

    /**
     * Initialize setting
     */
    public function setting_init()
    {
        //set the settings
        $this->settings_api->set_sections($this->get_settings_sections());
        $this->settings_api->set_fields($this->get_settings_fields());
        //initialize settings
        $this->settings_api->admin_init();
    }//end setting_init

    /**
     * Global Setting Sections and titles
     *
     * @return type
     */
    public function get_settings_sections()
    {
        $settings_sections = array(

            array(
                'id'    => 'cbfc_general_settings',
                'title' => esc_html__('Default Settings', 'codeboxrflexiblecountdown'),
            ),
            array(
                'id'    => 'cbfc_light_settings',
                'title' => esc_html__('Light Countdown', 'codeboxrflexiblecountdown'),
            ),
            array(
                'id'    => 'cbfc_circular_settings',
                'title' => esc_html__('Circular Countdown', 'codeboxrflexiblecountdown'),
            ),
            array(
                'id'    => 'cbfc_kk_settings',
                'title' => esc_html__('KK Countdown', 'codeboxrflexiblecountdown'),
            ),
            array(
                'id'    => 'cbfc_tools',
                'title' => esc_html__('Tools', 'codeboxrflexiblecountdown'),
            ),

        );

        return apply_filters('cbfc_setting_sections', $settings_sections);
    }//end get_settings_sections

    /**
     * Global Setting Fields
     *
     * @return array
     */
    public function get_settings_fields()
    {

        global $wpdb;

        $reset_data_link = add_query_arg('cbfc_fullreset', 1,
            admin_url('options-general.php?page=codeboxrflexiblecountdown'));

        $table_data_html = $table_cache_html = '';


        $table_data_html .= '<p><a class="button button-primary" id="cbfc_info_trig" href="#">'.esc_html__('Show/hide details',
                'codeboxrflexiblecountdown').'</a></p>';
        $table_data_html .= '<div id="cbfc_resetinfo" style="display: none;">';
        $table_data_html .= '<p id="cbfc_plg_gfig_info"><strong>'.esc_html__('Following option values created by this plugin(including addon)',
                'codeboxrflexiblecountdown').'</strong></p>';

        //$table_data_html .= '<p id="cbxlatesttweets_tool_fullreset"><strong>' . esc_html__( 'Following option values created by this plugin(including addon)', 'codeboxrflexiblecountdown' ) . '</strong></p>';


        $option_values   = CBFCHelper::getAllOptionNames();
        $table_data_html .= '<table class="widefat" id="cbxwpemaillogger_table_data">
	<thead>
	<tr>
		<th class="row-title">'.esc_attr__('Option Name', 'cbxwpemaillogger').'</th>
		<th>'.esc_attr__('Option ID', 'cbxwpemaillogger').'</th>
		<th>'.esc_attr__('Data', 'cbxwpemaillogger').'</th>
	</tr>
	</thead>
	<tbody>';


        $i = 0;
        foreach ($option_values as $key => $value) {
            $alternate_class = ($i % 2 == 0) ? 'alternate' : '';
            $i++;
            //$table_data_html .= '<p>' .  $value['option_name'] . ' - ' . $value['option_id'] . ' - (<code style="overflow-wrap: break-word; word-break: break-all;">' . $value['option_value'] . '</code>)</p>';

            $table_data_html .= '<tr class="'.esc_attr($alternate_class).'">
									<td class="row-title"><label for="tablecell">'.esc_attr($value['option_name']).'</label></td>
									<td>'.esc_attr($value['option_id']).'</td>
									<td><code style="overflow-wrap: break-word; word-break: break-all;">'.$value['option_value'].'</code></td>
								</tr>';

        }

        $table_data_html .= '</tbody>
	<tfoot>
	<tr>
		<th class="row-title">'.esc_attr__('Option Name', 'cbxwpemaillogger').'</th>
		<th>'.esc_attr__('Option ID', 'cbxwpemaillogger').'</th>
		<th>'.esc_attr__('Data', 'cbxwpemaillogger').'</th>
	</tr>
	</tfoot>
</table>';
        $table_data_html .= '</div>'; //#cbxwpemaillogger_resetinfo


        $general_settings  = get_option('cbfc_general_settings', array());
        $light_settings    = get_option('cbfc_light_settings', array());
        $circular_settings = get_option('cbfc_circular_settings', array());
        $kk_settings       = get_option('cbfc_kk_settings', array());

        $settings_builtin_fields =
            array(
                'cbfc_general_settings'  => array(
                    array(
                        'name'    => 'type',
                        'label'   => esc_html__('Countdown Style', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'select',
                        'options' => CBFCHelper::getCountdownStyles(),
                        'default' => 'light',
                    ),
                    array(
                        'name'    => 'date',
                        'label'   => esc_html__('Launch Date', 'codeboxrflexiblecountdown'),
                        'type'    => 'datepicker',
                        'desc'    => esc_html__('Date format: MM/DD/YYYY', 'codeboxrflexiblecountdown'),
                        'default' => CBFCHelper::getDefaultDate(),
                    ),
                    array(
                        'name'    => 'hour',
                        'label'   => esc_html__('Launch Hour', 'codeboxrflexiblecountdown'),
                        'desc'    => esc_html__('Max value is 23', 'codeboxrflexiblecountdown'),
                        'type'    => 'number',
                        'size'    => 'hour',
                        'default' => 0,
                        'min'     => 0,
                        'max'     => 23,
                    ),
                    array(
                        'name'    => 'min',
                        'label'   => esc_html__('Launch Minutes', 'codeboxrflexiblecountdown'),
                        'desc'    => esc_html__('Max value is 59', 'codeboxrflexiblecountdown'),
                        'type'    => 'number',
                        'default' => 0,
                        'size'    => 'minutes',
                        'min'     => 0,
                        'max'     => 59,
                    ),
                    array(
                        'name'    => 'hide_sec',
                        'label'   => esc_html__('Hide Second', 'codeboxrflexiblecountdown'),
                        'desc'    => esc_html__('Hide Seconds Countdown', 'codeboxrflexiblecountdown'),
                        'type'    => 'checkbox',
                        'default' => 'off',
                    ),
                    array(
                        'name'    => 'shortcode_demo',
                        'label'   => esc_html__('Shortcode & Demo', 'codeboxrflexiblecountdown'),
                        'desc'    => esc_html__('Shortcode and demo based on default setting, please save once to check change.',
                            'codeboxrflexiblecountdown'),
                        'type'    => 'shortcode',
                        'class'   => 'codeboxrflexiblecountdown_demo_copy',
                        'default' => CBFCHelper::shortcode_builder($general_settings, $light_settings,
                            $circular_settings, $kk_settings, ''),
                    ),
                ),
                'cbfc_light_settings'    => array(
                    array(
                        'name'    => 'num_color',
                        'label'   => esc_html__('Count Number Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#333',
                    ),
                    array(
                        'name'    => 'res_num_color',
                        'label'   => esc_html__('Count Number Color (On Responsive)', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#333',
                    ),
                    array(
                        'name'    => 'num_bg_color',
                        'label'   => esc_html__('Count Number Background Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#ffffff',
                    ),
                    array(
                        'name'    => 'text_color',
                        'label'   => esc_html__('Text Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#fff',
                    ),
                    array(
                        'name'    => 'res_text_color',
                        'label'   => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#fff',
                    ),
                    array(
                        'name'    => 'text_bg_color',
                        'label'   => esc_html__('Text Background Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#00c1c1',
                    ),
                    array(
                        'name'    => 'shortcode_demo_light',
                        'label'   => esc_html__('Shortcode & Demo', 'codeboxrflexiblecountdown'),
                        'desc'    => esc_html__('Shortcode and demo for light countdown, please save once to check change.',
                            'codeboxrflexiblecountdown'),
                        'type'    => 'shortcode',
                        'class'   => 'codeboxrflexiblecountdown_demo_copy',
                        'default' => CBFCHelper::shortcode_builder($general_settings, $light_settings,
                            $circular_settings, $kk_settings, 'light'),
                    ),
                ),
                'cbfc_circular_settings' => array(
                    array(
                        'name'    => 'sec_color',
                        'label'   => esc_html__('Seconds Border Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#ff6386',
                    ),
                    array(
                        'name'    => 'min_color',
                        'label'   => esc_html__('Minutes Border Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#00c1c1',
                    ),
                    array(
                        'name'    => 'hour_color',
                        'label'   => esc_html__('Hours Border Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#ffcf4a',
                    ),
                    array(
                        'name'    => 'day_color',
                        'label'   => esc_html__('Days Border Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#00a3ee',
                    ),
                    array(
                        'name'    => 'canvas_color',
                        'label'   => esc_html__('Background Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#ffffff',
                    ),
                    array(
                        'name'    => 'text_color',
                        'label'   => esc_html__('Count Number And Text Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#3B1D82',
                    ),
                    array(
                        'name'    => 'res_text_color',
                        'label'   => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#333',
                    ),
                    array(
                        'name'    => 'border_width',
                        'label'   => esc_html__('Circle Border Width', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'text',
                        'default' => '8',
                    ),
                    array(
                        'name'    => 'shortcode_demo_circular',
                        'label'   => esc_html__('Shortcode & Demo', 'codeboxrflexiblecountdown'),
                        'desc'    => esc_html__('Shortcode and demo for circular countdown, please save once to check change.',
                            'codeboxrflexiblecountdown'),
                        'type'    => 'shortcode',
                        'class'   => 'codeboxrflexiblecountdown_demo_copy',
                        'default' => CBFCHelper::shortcode_builder($general_settings, $light_settings,
                            $circular_settings, $kk_settings, 'circular'),
                    ),

                ),
                'cbfc_kk_settings'       => array(
                    array(
                        'name'    => 'font_size',
                        'label'   => esc_html__('Countdown Font Size', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'text',
                        'default' => '30',
                    ),
                    array(
                        'name'    => 'num_color',
                        'label'   => esc_html__('Countdown Number Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#00a3ee',
                    ),

                    array(
                        'name'    => 'text_color',
                        'label'   => esc_html__('Countdown Text Color', 'codeboxrflexiblecountdown'),
                        'desc'    => '',
                        'type'    => 'color',
                        'default' => '#00c1c1',
                    ),
                    array(
                        'name'    => 'shortcode_demo_kk',
                        'label'   => esc_html__('Shortcode & Demo', 'codeboxrflexiblecountdown'),
                        'desc'    => esc_html__('Shortcode and demo for light countdown, please save once to check change.',
                            'codeboxrflexiblecountdown'),
                        'type'    => 'shortcode',
                        'class'   => 'codeboxrflexiblecountdown_demo_copy',
                        'default' => CBFCHelper::shortcode_builder($general_settings, $light_settings,
                            $circular_settings, $kk_settings, 'kk'),
                    ),
                ),
                'cbfc_tools'             => array(
                    'delete_global_config' => array(
                        'name'    => 'delete_global_config',
                        'label'   => esc_html__('On Uninstall delete plugin data', 'codeboxrflexiblecountdown'),
                        'desc'    => '<p>'.esc_html__('Delete Global Config data created by this plugin on uninstall.',
                                'codeboxrflexiblecountdown').' '.__('Details <a data-target="cbfc_resetinfo" class="cbfc_jump" href="#">option values</a>',
                                'codeboxrflexiblecountdown').'</p>'.'<p>'.__('<strong>Please note that this process can not be undone and it is recommended to keep full database backup before doing this.</strong>',
                                'codeboxrflexiblecountdown').'</p>',
                        'type'    => 'radio',
                        'options' => array(
                            'yes' => esc_html__('Yes', 'codeboxrflexiblecountdown'),
                            'no'  => esc_html__('No', 'codeboxrflexiblecountdown'),
                        ),
                        'default' => 'no',
                    ),
                    'reset_data'           => array(
                        'name'    => 'reset_data',
                        'label'   => esc_html__('Reset all data', 'codeboxrflexiblecountdown'),
                        'desc'    => sprintf(__('Reset option values created by this plugin. 
<a class="button button-primary" onclick="return confirm(\'%s\')" href="%s">Reset Data</a>',
                                'codeboxrflexiblecountdown'),
                                esc_html__('Are you sure to reset all data, this process can not be undone?',
                                    'codeboxrflexiblecountdown'),
                                $reset_data_link).$table_data_html,
                        'type'    => 'html',
                        'default' => 'off',
                    ),


                ),
            );

        $settings_fields = array(); //final setting array that will be passed to different filters

        $sections = $this->get_settings_sections();


        foreach ($sections as $section) {
            if ( ! isset($settings_builtin_fields[$section['id']])) {
                $settings_builtin_fields[$section['id']] = array();
            }
        }

        foreach ($sections as $section) {
            $settings_builtin_fields_section_id = $settings_builtin_fields[$section['id']];
            $settings_fields[$section['id']]    = apply_filters('cbfc_global_'.$section['id'].'_fields',
                $settings_builtin_fields_section_id);
        }


        $settings_fields = apply_filters('cbfc_global_fields', $settings_fields); //final filter if need

        return $settings_fields;
    }//end get_settings_fields

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook)
    {
        $page   = isset($_REQUEST['page']) ? sanitize_text_field($_REQUEST['page']) : '';
        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

        if ($page == 'codeboxrflexiblecountdown') {
            wp_enqueue_style('wp-color-picker');

            wp_register_style('jquery-ui',
                plugin_dir_url(__FILE__).'../assets/css/ui-lightness/jquery-ui.min.css',
                array(),
                $this->version);

            //wp_register_style( 'chosen', plugin_dir_url( __FILE__ ) . '../assets/css/chosen.min.css', array(), $this->version, 'all' );
            wp_register_style('select2',
                plugin_dir_url(__FILE__).'../assets/select2/css/select2.min.css',
                array(),
                $this->version);

            //for demo
            wp_register_style('codeboxrflexiblecountdown-public',
                plugin_dir_url(__FILE__).'../assets/css/codeboxrflexiblecountdown-public.css',
                array(),
                $this->version,
                'all');

            wp_register_style('codeboxrflexiblecountdown-setting',
                plugin_dir_url(__FILE__).'../assets/css/codeboxrflexiblecountdown-setting.css',
                array(
                    'select2',
                    'jquery-ui',
                    'wp-color-picker',
                    'codeboxrflexiblecountdown-public'
                ),
                $this->version,
                'all');

            //wp_enqueue_style( 'chosen' );
            wp_enqueue_style('select2');
            wp_enqueue_style('jquery-ui');
            wp_enqueue_script('codeboxrflexiblecountdown-public');
            wp_enqueue_style('codeboxrflexiblecountdown-setting');


        }//end only for setting page
//Start branding CSS
        if ($page == 'codeboxrflexiblecountdown' || $page == 'codeboxrflexiblecountdown&doc=1') {
            wp_register_style('codeboxrflexiblecountdown-branding',
                plugin_dir_url(__FILE__).'../assets/css/codeboxrflexiblecountdown-branding.css',
                array(),
                $this->version);
            wp_enqueue_style('codeboxrflexiblecountdown-branding');
        }//End branding CSS
    }//end enqueue_styles

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook)
    {
        $page   = isset($_REQUEST['page']) ? sanitize_text_field($_REQUEST['page']) : '';
        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

        if ($page == 'codeboxrflexiblecountdown') {

            wp_register_script('select2',
                plugin_dir_url(__FILE__).'../assets/select2/js/select2.min.js',
                array('jquery'),
                $this->version,
                true);


            //for demo
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


            wp_register_script('codeboxrflexiblecountdown-setting',
                plugin_dir_url(__FILE__).'../assets/js/codeboxrflexiblecountdown-setting.js',
                array(
                    'jquery',
                    'jquery-ui-core',
                    'jquery-ui-datepicker',
                    'select2',
                    'wp-color-picker',
                    'codeboxrflexiblecountdown-public'
                ),
                $this->version,
                true);

            $cbxpetition_setting_js_vars = apply_filters('codeboxrflexiblecountdown_setting_js_vars',
                array(
                    'please_select' => esc_html__('Please Select', 'codeboxrflexiblecountdown'),
                    'upload_title'  => esc_html__('Window Title', 'codeboxrflexiblecountdown'),
                    'copy_success'  => esc_html__('Shortcode copied to clipboard', 'codeboxrflexiblecountdown'),
                    'copy_fail'     => esc_html__('Oops, unable to copy', 'codeboxrflexiblecountdown')
                ));

            wp_localize_script('codeboxrflexiblecountdown-setting',
                'codeboxrflexiblecountdown_setting',
                $cbxpetition_setting_js_vars);


            wp_enqueue_script('jquery');

            wp_enqueue_media();
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('select2');
            wp_enqueue_script('codeboxrflexiblecountdown-public');
            wp_enqueue_script('codeboxrflexiblecountdown-setting');
        }//end only for setting page
        //header scroll
        wp_register_script('codeboxrflexiblecountdown-scroll',
            plugins_url('../assets/js/codeboxrflexiblecountdown-scroll.js', __FILE__), array('jquery'), $this->version);
        if ($page == 'codeboxrflexiblecountdown' || $page == 'codeboxrflexiblecountdown&doc=1') {
            wp_enqueue_script('jquery');
            wp_enqueue_script('codeboxrflexiblecountdown-scroll');
        }
    }//end enqueue_scripts

    /**
     * Full plugin reset and redirect
     */
    public function plugin_fullreset()
    {
        global $wpdb;

        $option_prefix = 'cbfc_';

        $option_values = CBFCHelper::getAllOptionNames();

        foreach ($option_values as $key => $accounting_option_value) {
            delete_option($accounting_option_value['option_name']);
        }

        do_action('cbfc_plugin_option_delete');


        // create plugin's core table tables
        activate_codeboxrflexiblecountdown();


        $this->settings_api->set_sections($this->get_settings_sections());
        $this->settings_api->set_fields($this->get_settings_fields());
        $this->settings_api->admin_init();

        set_transient('cbfc_fullreset_notice', 1);


        wp_safe_redirect(admin_url('options-general.php?page=codeboxrflexiblecountdown#cbfc_tools'));
        exit();
    }//end plugin_fullreset

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function plugin_listing_setting_link($links)
    {
        return array_merge(array(
            'settings' => '<a style="color:#ff2c5e; font-weight: bold;" target="_blank" href="'.admin_url('options-general.php?page=codeboxrflexiblecountdown').'">'.esc_html__('Settings',
                    'codeboxrflexiblecountdown').'</a>'
        ), $links);

    }//end plugin_listing_setting_link

    /**
     * Filters the array of row meta for each/specific plugin in the Plugins list table.
     * Appends additional links below each/specific plugin on the plugins page.
     *
     * @access  public
     *
     * @param  array  $links_array  An array of the plugin's metadata
     * @param  string  $plugin_file_name  Path to the plugin file
     * @param  array  $plugin_data  An array of plugin data
     * @param  string  $status  Status of the plugin
     *
     * @return  array       $links_array
     */
    public function plugin_row_meta($links_array, $plugin_file_name, $plugin_data, $status)
    {
        if (strpos($plugin_file_name, CBFC_PLUGIN_NAME) !== false) {
            if ( ! function_exists('is_plugin_active')) {
                include_once(ABSPATH.'wp-admin/includes/plugin.php');
            }

            $links_array[] = '<a target="_blank" style="color:#ff2c5e !important; font-weight: bold;" href="https://wordpress.org/support/plugin/codeboxrflexiblecountdown/" aria-label="'.esc_attr__('Free Support',
                    'codeboxrflexiblecountdown').'">'.esc_html__('Free Support', 'codeboxrflexiblecountdown').'</a>';
            $links_array[] = '<a target="_blank" style="font-weight: bold; color: #ff2c5e;" href="https://wordpress.org/plugins/codeboxrflexiblecountdown/#reviews" >'.esc_html__('Reviews',
                    'codeboxrflexiblecountdown').'</a>';
            $links_array[] = '<a target="_blank" style="font-weight: bold; color: #ff2c5e;" href="https://codeboxr.com/documentation-for-cbx-countdown-for-wordpress/" >'.esc_html__('Documentation',
                    'codeboxrflexiblecountdown').'</a>';

            if (in_array('codeboxrflexiblecountdownproaddon/codeboxrflexiblecountdownproaddon.php.php',
                    apply_filters('active_plugins',
                        get_option('active_plugins'))) || defined('CBFCADDON_PLUGIN_NAME')) {
                $links_array[] = '<a target="_blank" style="font-weight: bold; color: #ff2c5e;" href="https://codeboxr.com/contact-us/" >'.esc_html__('Pro Support',
                        'codeboxrflexiblecountdown').'</a>';
            } else {
                $links_array[] = '<a target="_blank" style="font-weight: bold; color: #ff2c5e;" href="https://codeboxr.com/product/cbx-flexible-event-countdown-for-wordpress/" >'.esc_html__('Try Pro Addon',
                        'codeboxrflexiblecountdown').'</a>';

            }
        }

        return $links_array;
    }//end plugin_row_meta

    /**
     * If we need to do something in upgrader process is completed for plugin
     *
     * @param $upgrader_object
     * @param $options
     */
    public function plugin_upgrader_process_complete($upgrader_object, $options)
    {
        if ($options['action'] == 'update' && $options['type'] == 'plugin') {
            foreach ($options['plugins'] as $each_plugin) {
                if ($each_plugin == CBFC_PLUGIN_BASE_NAME) {
                    /*if ( ! class_exists( 'CodeboxrFlexibleCountdown_Activator' ) ) {
                        require_once plugin_dir_path( __FILE__ ) . '../includes/class-codeboxrflexiblecountdown-activator.php';
                    }*/

                    //create tables
                    //codeboxrflexiblecountdown_Activator::createTables();
                    //codeboxrflexiblecountdown_Activator::createPages();

                    set_transient('cbfc_upgraded_notice', 1);

                    break;
                }
            }
        }

    }//end plugin_upgrader_process_complete

    /**
     * Show a notice to anyone who has just installed the plugin for the first time
     * This notice shouldn't display to anyone who has just updated this plugin
     */
    public function plugin_activate_upgrade_notices()
    {
        //delete transient for full reset notice if any
        if (get_transient('cbfc_fullreset_notice')) {
            echo '<div style="border-left-color:#fb4e24;" class="notice notice-success is-dismissible">';
            echo '<p style="color: #fb4e24;">'.esc_html__('CBX Flexible CountDown plugin setting has been reset to defaults',
                    'codeboxrflexiblecountdown').'</p>';
            echo '</div>';

            delete_transient('cbfc_fullreset_notice');
        }

        // Check the transient to see if we've just activated the plugin
        if (get_transient('cbfc_activated_notice')) {
            echo '<div class="notice notice-success is-dismissible" style="border-color: #ff2c5e !important;">';
            echo '<p>'.sprintf(__('Thanks for installing/deactivating <strong>CBX Flexible CountDown</strong> V%s - Codeboxr Team',
                    'codeboxrflexiblecountdown'), CBFC_PLUGIN_VERSION).'</p>';
            echo '<p>'.sprintf(__('Check <a href="%s">Plugin Setting</a> | <a href="%s" target="_blank">Learn More</a>',
                    'codeboxrflexiblecountdown'), admin_url('admin.php?page=codeboxrflexiblecountdown'),
                    'https://codeboxr.com/product/cbx-flexible-event-countdown-for-wordpress/').'</p>';
            echo '</div>';
            // Delete the transient so we don't keep displaying the activation message
            delete_transient('cbfc_activated_notice');

            $this->pro_addon_compatibility_campaign();

        }

        // Check the transient to see if we've just activated the plugin
        if (get_transient('cbfc_upgraded_notice')) {
            echo '<div class="notice notice-success is-dismissible" style="border-color: #ff2c5e !important;">';
            echo '<p>'.sprintf(__('Thanks for upgrading <strong>CBX Flexible CountDown</strong> V%s , enjoy the new features and bug fixes - Codeboxr Team',
                    'codeboxrflexiblecountdown'), CBFC_PLUGIN_VERSION).'</p>';
            echo '<p>'.sprintf(__('Check <a href="%s">Plugin Setting</a> | <a href="%s" target="_blank">Learn More</a>',
                    'codeboxrflexiblecountdown'), admin_url('admin.php?page=codeboxrflexiblecountdown'),
                    'https://codeboxr.com/product/cbx-flexible-event-countdown-for-wordpress/').'</p>';
            echo '</div>';
            // Delete the transient so we don't keep displaying the activation message
            delete_transient('cbfc_upgraded_notice');

            $this->pro_addon_compatibility_campaign();

        }
    }//end plugin_activate_upgrade_notices

    /**
     * Check plugin compatibility and pro addon install campaign
     */
    public function pro_addon_compatibility_campaign()
    {

        if ( ! function_exists('is_plugin_active')) {
            include_once(ABSPATH.'wp-admin/includes/plugin.php');
        }

        //if the pro addon is active or installed
        if (in_array('codeboxrflexiblecountdownproaddon/codeboxrflexiblecountdownproaddon.php',
                apply_filters('active_plugins', get_option('active_plugins'))) || defined('CBFCADDON_PLUGIN_NAME')) {
            //plugin is activated

            $plugin_version = CBFCADDON_PLUGIN_VERSION;


            /*if(version_compare($plugin_version,'1.0.11', '<=') ){
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'CBX Flexible CountDown Pro Addon Vx.x.x or any previous version is not compatible with CBX Flexible CountDown Vx.x.x or later. Please update CBX Flexible CountDown Pro Addon to version x.x.0 or later  - Codeboxr Team', 'codeboxrflexiblecountdown' ) . '</p></div>';
            }*/
        } else {
            echo '<div class="notice notice-success is-dismissible" style="border-color: #ff2c5e !important;"><p>'.sprintf(__('<a target="_blank" href="%s">CBX Flexible CountDown Pro Addon</a> has lots of pro and extended features, try it - Codeboxr Team',
                    'codeboxrflexiblecountdown'),
                    'https://codeboxr.com/product/cbx-multi-criteria-rating-review-for-wordpress-pro-addon/').'</p></div>';
        }
    }//end pro_addon_compatibility_campaign


    /**
     * Init all gutenberg blocks
     */
    public function gutenberg_blocks()
    {
        if ( ! function_exists('register_block_type')) {
            return;
        }

        /*$translation_strings = array(
            'kkc_day'  => esc_html__( 'day', 'codeboxrflexiblecountdown' ),
            'kkc_days' => esc_html__( 'days', 'codeboxrflexiblecountdown' ),
            'kkc_hr'   => esc_html__( 'h', 'codeboxrflexiblecountdown' ),
            'kkc_min'  => esc_html__( 'm', 'codeboxrflexiblecountdown' ),
            'kkc_sec'  => esc_html__( 's', 'codeboxrflexiblecountdown' ),
        );

        wp_register_script( 'codeboxrflexiblecountdown-public',
            plugin_dir_url( __FILE__ ) . '../assets/js/codeboxrflexiblecountdown-public.js',
            array( 'jquery' ),
            $this->version,
            true );
        wp_localize_script( 'codeboxrflexiblecountdown-public', 'cbfc_strings', $translation_strings );

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'codeboxrflexiblecountdown-public' );*/

        wp_register_script('codeboxrflexiblecountdown-block',
            plugin_dir_url(__FILE__).'../assets/js/codeboxrflexiblecountdown-block.js', array(
                'wp-blocks',
                'wp-element',
                'wp-components',
                'wp-editor',
                //'jquery',
                //'codeboxrflexiblecountdown-public'
            ), filemtime(plugin_dir_path(__FILE__).'../assets/js/codeboxrflexiblecountdown-block.js'));

        $js_vars = apply_filters('codeboxrflexiblecountdown_block_js_vars',
            array(
                'block_title'            => esc_html__('CBX Flexible Countdown', 'codeboxrflexiblecountdown'),
                'block_category'         => 'codeboxr',
                'block_icon'             => 'universal-access-alt',
                'cbfc_general_settings'  => array(
                    'title'        => esc_html__('Default Settings', 'codeboxrflexiblecountdown'),
                    'type'         => esc_html__('Countdown Style', 'codeboxrflexiblecountdown'),
                    'type_default' => 'light',
                    'type_options' => CBFCHelper::getCountdownStylesBlocks(),
                    'date'         => esc_html__('Select Date & Time', 'codeboxrflexiblecountdown'),
                    'hide_sec'     => esc_html__('Hide Second', 'codeboxrflexiblecountdown'),
                ),
                'cbfc_light_settings'    => array(
                    'title'        => esc_html__('Light Countdown Settings', 'codeboxrflexiblecountdown'),
                    'l_numclr'     => esc_html__('Count Number Color', 'codeboxrflexiblecountdown'),
                    'l_resnumclr'  => esc_html__('Count Number Color (On Responsive)', 'codeboxrflexiblecountdown'),
                    'l_numbgclr'   => esc_html__('Count Number Background Color', 'codeboxrflexiblecountdown'),
                    'l_textclr'    => esc_html__('Text Color', 'codeboxrflexiblecountdown'),
                    'l_restextclr' => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                    'l_textbgclr'  => esc_html__('Text Background Color', 'codeboxrflexiblecountdown'),
                ),
                'cbfc_circular_settings' => array(
                    'title'        => esc_html__('Circular Countdown Settings', 'codeboxrflexiblecountdown'),
                    'c_secbclr'    => esc_html__('Seconds Border Color', 'codeboxrflexiblecountdown'),
                    'c_minbclr'    => esc_html__('Minutes Border Color', 'codeboxrflexiblecountdown'),
                    'c_hourbclr'   => esc_html__('Hours Border Color', 'codeboxrflexiblecountdown'),
                    'c_daybclr'    => esc_html__('Days Border Color', 'codeboxrflexiblecountdown'),
                    'c_bgclr'      => esc_html__('Background Color', 'codeboxrflexiblecountdown'),
                    'c_textclr'    => esc_html__('Count Number And Text Color', 'codeboxrflexiblecountdown'),
                    'c_restextclr' => esc_html__('Text Color (On Responsive)', 'codeboxrflexiblecountdown'),
                    'c_borderw'    => esc_html__('Circle Border Width', 'codeboxrflexiblecountdown'),
                ),
                'cbfc_kk_settings'       => array(
                    'title'       => esc_html__('KK Countdown Settings', 'codeboxrflexiblecountdown'),
                    'kk_fontsize' => esc_html__('Font Size(Numeric only)', 'codeboxrflexiblecountdown'),
                    'kk_numclr'   => esc_html__('Countdown Number Color', 'codeboxrflexiblecountdown'),
                    'kk_textclr'  => esc_html__('Countdown Text Color', 'codeboxrflexiblecountdown'),
                ),
                'pro'                    => false

            ));

        wp_localize_script('codeboxrflexiblecountdown-block', 'cbfc_block', $js_vars);

        register_block_type('codeboxr/codeboxrflexiblecountdown', array(
            'editor_script'   => 'codeboxrflexiblecountdown-block',
            'attributes'      => apply_filters('codeboxrflexiblecountdown_block_attributes', array(
                //general
                'type'         => array(
                    'type'    => 'string',
                    'default' => 'light',
                ),
                'date'         => array(
                    'type'    => 'string',
                    'default' => CBFCHelper::getDefaultDate('Y-m-d'),
                ),
                'hide_sec'     => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                //light
                'l_numclr'     => array(
                    'type'    => 'string',
                    'default' => '#333'
                ),
                'l_resnumclr'  => array(
                    'type'    => 'string',
                    'default' => '#333'
                ),
                'l_numbgclr'   => array(
                    'type'    => 'string',
                    'default' => '#eaeaea'
                ),
                'l_textclr'    => array(
                    'type'    => 'string',
                    'default' => '#fff'
                ),
                'l_restextclr' => array(
                    'type'    => 'string',
                    'default' => '#fff'
                ),
                'l_textbgclr'  => array(
                    'type'    => 'string',
                    'default' => '#f5832b'
                ),
                //circular
                'c_secbclr'    => array(
                    'type'    => 'string',
                    'default' => '#7995D5'
                ),
                'c_minbclr'    => array(
                    'type'    => 'string',
                    'default' => '#ACC742'
                ),
                'c_hourbclr'   => array(
                    'type'    => 'string',
                    'default' => '#ECEFCB'
                ),
                'c_daybclr'    => array(
                    'type'    => 'string',
                    'default' => '#FF9900'
                ),
                'c_bgclr'      => array(
                    'type'    => 'string',
                    'default' => '#9c9c9c'
                ),
                'c_textclr'    => array(
                    'type'    => 'string',
                    'default' => '#7995D5'
                ),
                'c_restextclr' => array(
                    'type'    => 'string',
                    'default' => '#7995D5'
                ),
                'c_borderw'    => array(
                    'type'    => 'number',
                    'default' => '6'
                ),
                //kk
                'kk_fontsize'  => array(
                    'type'    => 'string',
                    'default' => '30'
                ),
                'kk_numclr'    => array(
                    'type'    => 'string',
                    'default' => '#3767b9'
                ),
                'kk_textclr'   => array(
                    'type'    => 'string',
                    'default' => '#666333'
                ),

            )),
            'render_callback' => array($this, 'codeboxrflexiblecountdown_block_render')
        ));

    }//end gutenberg_blocks

    /**
     * Gutenberg server side render
     *
     * @param $attributes
     *
     * @return string
     * @throws Exception
     */
    public function codeboxrflexiblecountdown_block_render($attributes)
    {
        $attr = array();

        $type = isset($attributes['type']) ? sanitize_text_field($attributes['type']) : 'light';
        $date = isset($attributes['date']) ? sanitize_text_field($attributes['date']) : '';

        $attributes['hide_sec'] = isset($attributes['hide_sec']) ? $attributes['hide_sec'] : false;
        $hide_sec               = $attributes['hide_sec'] = ($attributes['hide_sec'] == 'true') ? 'on' : 'off';

        if ($date == '') {
            $date   = \CBFCHelper::getDefaultDate();
            $hour   = 0;
            $minute = 0;
        } else {

            $date   = explode("T", $date);
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
            'hide_sec' => $hide_sec
        );

        //light setting
        if ($type == 'light') {
            if (isset($attributes['l_numclr'])) {
                $attr['l_numclr'] = sanitize_text_field($attributes['l_numclr']);
            }//light number color
            if (isset($attributes['l_resnumclr'])) {
                $attr['l_resnumclr'] = sanitize_text_field($attributes['l_resnumclr']);
            }//light number responsive color
            if (isset($attributes['l_numbgclr'])) {
                $attr['l_numbgclr'] = sanitize_text_field($attributes['l_numbgclr']);
            }// light number background color
            if (isset($attributes['l_textclr'])) {
                $attr['l_textclr'] = sanitize_text_field($attributes['l_textclr']);
            }//light text color
            if (isset($attributes['l_restextclr'])) {
                $attr['l_restextclr'] = sanitize_text_field($attributes['l_restextclr']);
            }    //light text responsive color
            if (isset($attributes['l_textbgclr'])) {
                $attr['l_textbgclr'] = sanitize_text_field($attributes['l_textbgclr']);
            }//light text background
        }

        //circular setting
        if ($type == 'circular') {
            if (isset($attributes['c_secbclr'])) {
                $attr['c_secbclr'] = sanitize_text_field($attributes['c_secbclr']);
            }//sec border color(circular)
            if (isset($attributes['c_minbclr'])) {
                $attr['c_minbclr'] = sanitize_text_field($attributes['c_minbclr']);
            }// min border  color(circular)
            if (isset($attributes['c_hourbclr'])) {
                $attr['c_hourbclr'] = sanitize_text_field($attributes['c_hourbclr']);
            }//hour border color(circular)
            if (isset($attributes['c_daybclr'])) {
                $attr['c_daybclr'] = sanitize_text_field($attributes['c_daybclr']);
            }//days border color(circular)
            if (isset($attributes['c_bgclr'])) {
                $attr['c_bgclr'] = sanitize_text_field($attributes['c_bgclr']);
            }//canvas background color(circular)
            if (isset($attributes['c_textclr'])) {
                $attr['c_textclr'] = sanitize_text_field($attributes['c_textclr']);
            }//count number and text color(circular)
            if (isset($attributes['c_restextclr'])) {
                $attr['c_restextclr'] = sanitize_text_field($attributes['c_restextclr']);
            }//text color on responsive(circular)
            if (isset($attributes['c_borderw'])) {
                $attr['c_borderw'] = sanitize_text_field($attributes['c_borderw']);
            }//text color on responsive(circular)
        }

        //kk setting
        if ($type == 'kk') {
            if (isset($attributes['kk_fontsize'])) {
                $attr['kk_fontsize'] = intval($attributes['kk_fontsize']);
            }//kk font size
            if (isset($attributes['kk_numclr'])) {
                $attr['kk_numclr'] = sanitize_text_field($attributes['kk_numclr']);
            }    //kk count down number color
            if (isset($attributes['kk_textclr'])) {
                $attr['kk_textclr'] = sanitize_text_field($attributes['kk_textclr']);
            }//kk countdown text color
        }


        $attr = apply_filters('cbfc_block_shortcode_builder_attr', $attr, $attributes);

        $attr_html = '';

        foreach ($attr as $key => $value) {
            $attr_html .= ' '.$key.'="'.$value.'" ';
        }

        //return do_shortcode( '[cbfccountdown ' . $attr_html . ']' );
        return '[cbfccountdown '.$attr_html.']';
    }//end codeboxrflexiblecountdown_block_render

    /**
     * Register New Gutenberg block Category if need
     *
     * @param $categories
     * @param $post
     *
     * @return mixed
     */
    public function gutenberg_block_categories($categories, $post)
    {
        $found = false;
        foreach ($categories as $category) {
            if ($category['slug'] == 'codeboxr') {
                $found = true;
                break;
            }
        }

        if ( ! $found) {
            return array_merge(
                $categories,
                array(
                    array(
                        'slug'  => 'codeboxr',
                        'title' => esc_html__('CBX Blocks', 'codeboxrflexiblecountdown'),
                    ),
                )
            );
        }

        return $categories;
    }//end gutenberg_block_categories


    /**
     * Enqueue style for block editor
     */
    public function enqueue_block_editor_assets()
    {
        /*wp_register_style( 'codeboxrflexiblecountdown-public',
            plugin_dir_url( __FILE__ ) . '../assets/css/codeboxrflexiblecountdown-public.css',
            array(),
            $this->version,
            'all' );

        wp_enqueue_style( 'codeboxrflexiblecountdown-public' );

        //for demo
        $translation_strings = array(
            'kkc_day'  => esc_html__( 'day', 'codeboxrflexiblecountdown' ),
            'kkc_days' => esc_html__( 'days', 'codeboxrflexiblecountdown' ),
            'kkc_hr'   => esc_html__( 'h', 'codeboxrflexiblecountdown' ),
            'kkc_min'  => esc_html__( 'm', 'codeboxrflexiblecountdown' ),
            'kkc_sec'  => esc_html__( 's', 'codeboxrflexiblecountdown' ),
        );*/

        /*wp_register_script( 'codeboxrflexiblecountdown-public',
            plugin_dir_url( __FILE__ ) . '../assets/js/codeboxrflexiblecountdown-public.js',
            array( 'jquery' ),
            $this->version,
            true );
        wp_localize_script( 'codeboxrflexiblecountdown-public', 'cbfc_strings', $translation_strings );

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'codeboxrflexiblecountdown-public' );*/
    }//end enqueue_block_editor_assets

    /**
     * Add our self-hosted autoupdate plugin to the filter transient
     *
     * @param $transient
     *
     * @return object $ transient
     */
    public function pre_set_site_transient_update_plugins_pro_addon($transient)
    {
        // Extra check for 3rd plugins
        if (isset($transient->response['codeboxrflexiblecountdownproaddon/codeboxrflexiblecountdownproaddon.php'])) {
            return $transient;
        }

        if ( ! function_exists('get_plugins')) {
            require_once ABSPATH.'wp-admin/includes/plugin.php';
        }

        $plugin_info = array();
        $all_plugins = get_plugins();
        if ( ! isset($all_plugins['codeboxrflexiblecountdownproaddon/codeboxrflexiblecountdownproaddon.php'])) {
            return $transient;
        } else {
            $plugin_info = $all_plugins['codeboxrflexiblecountdownproaddon/codeboxrflexiblecountdownproaddon.php'];
        }


        $remote_version = '1.0.10';

        if (version_compare($plugin_info['Version'], $remote_version, '<')) {
            $obj                                                                                            = new stdClass();
            $obj->slug                                                                                      = 'codeboxrflexiblecountdownproaddon';
            $obj->new_version                                                                               = $remote_version;
            $obj->plugin                                                                                    = 'codeboxrflexiblecountdownproaddon/codeboxrflexiblecountdownproaddon.php';
            $obj->url                                                                                       = '';
            $obj->package                                                                                   = false;
            $obj->name                                                                                      = 'CBX Flexible CountDown Pro Addon';
            $transient->response['codeboxrflexiblecountdownproaddon/codeboxrflexiblecountdownproaddon.php'] = $obj;
        }

        return $transient;
    }//end pre_set_site_transient_update_plugins_pro_addon

    /**
     * Pro Addon update message
     */
    public function plugin_update_message_pro_addon()
    {
        echo ' '.sprintf(__('Check how to <a style="color:#6648fe !important; font-weight: bold;" href="%s"><strong>Update manually</strong></a> , download latest version from <a style="color:#6648fe !important; font-weight: bold;" href="%s"><strong>My Account</strong></a> section of Codeboxr.com',
                'codeboxrflexiblecountdown'), 'https://codeboxr.com/manual-update-pro-addon/',
                'https://codeboxr.com/my-account/');
    }//end plugin_update_message_pro_addon

}//end class CodeboxrFlexibleCountdown_Admin
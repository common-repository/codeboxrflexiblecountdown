<?php

/**
 * The file that defines the core plugin widget class
 *
 *
 * @link       https://codeboxr.com/
 * @since      1.0.0
 *
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/widget
 */

/**
 * The core plugin class.
 *
 * This is used to define widget
 *
 *
 * @since      1.0.0
 * @package    CodeboxrFlexibleCountdown
 * @subpackage CodeboxrFlexibleCountdown/widget
 * @author     Codeboxr <info@codeboxr.com>
 */

// Prevent direct file access
if ( ! defined('ABSPATH')) {
    exit;
}

class CodeboxrFlexibleCountdownWidget extends WP_Widget
{

    /**
     *
     * Unique identifier for your widget.
     *
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'cbfcwidget';


    public function __construct()
    {

        parent::__construct(
            $this->get_widget_slug(),
            esc_html__('CBX Flexible Countdown', 'codeboxrflexiblecountdow'),
            array(
                'classname'   => $this->widget_slug,
                'description' => esc_html__('CBX Countdown Widget', 'codeboxrflexiblecountdown'),
            )
        );

        // Register admin styles and scripts
        add_action('admin_enqueue_scripts', array($this, 'register_admin_styles_scripts'));

    } // end constructor


    /**
     * Return the widget slug.
     *
     * @return    Plugin slug variable.
     * @since    1.0.0
     *
     */
    public function get_widget_slug()
    {
        return $this->widget_slug;
    }

    /*--------------------------------------------------*/
    /* Widget API Functions
    /*--------------------------------------------------*/

    /**
     * Outputs the content of the widget.
     *
     * @param  array args  The array of form elements
     * @param  array instance The current instance of the widget
     */
    public function widget($args, $instance)
    {

        if ( ! isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        extract($args, EXTR_SKIP);

        $title = apply_filters('widget_title',
            empty($instance['title']) ? esc_html__('CBX Flexible Countdown',
                'codeboxrflexiblecountdow') : esc_html($instance['title']),
            $instance,
            $this->id_base);

        $title = $before_title.$title.$after_title;

        $widget_string = $before_widget;
        $widget_string .= $title;

        ob_start();


        $attr = array();

        $attr['type']     = esc_html($instance['cbfc_countdown_style']);
        $attr['date']     = strip_tags($instance['cbfc_date']);
        $attr['hour']     = (int) strip_tags($instance['cbfc_hour']);
        $attr['minute']   = (int) strip_tags($instance['cbfc_min']);
        $attr['hide_sec'] = esc_html($instance['cbfc_hide_sec']);

        $attr = apply_filters('cbxflexiblecountdownwidgetwidget', $attr, $instance);

        $attr_html = '';

        foreach ($attr as $key => $value) {
            $attr_html .= ' '.$key.'="'.$value.'" ';
        }

        //$widget_string .= $plugin_public->get_flexible_countdown($attr);
        $widget_string .= do_shortcode('[cbfccountdown '.$attr_html.']');

        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;

        print $widget_string;

    } // end widget


    /**
     * Processes the widget's options to be saved.
     *
     * @param  array new_instance The new instance of values to be generated via the update.
     * @param  array old_instance The previous instance of values before the update.
     */
    public function update($new_instance, $old_instance)
    {

        $instance = $old_instance;


        $instance                         = $old_instance;
        $instance['title']                = esc_html($new_instance['title']);
        $instance['cbfc_countdown_style'] = esc_html($new_instance['cbfc_countdown_style']);
        $instance['cbfc_date']            = strip_tags($new_instance['cbfc_date']);
        $instance['cbfc_hour']            = (int) strip_tags($new_instance['cbfc_hour']);
        $instance['cbfc_min']             = (int) strip_tags($new_instance['cbfc_min']);
        $instance['cbfc_hide_sec']        = esc_html($new_instance['cbfc_hide_sec']);

        $instance = apply_filters('cbxflexiblecountdownwidgetupdate', $instance, $new_instance, $old_instance);


        return $instance;

    } // end widget

    /**
     * Generates the administration form for the widget.
     *
     * @param  array instance The array of keys and values for the widget.
     */
    public function form($instance)
    {

        $instance = wp_parse_args(
            (array) $instance
        );

        $title                = isset($instance['title']) ? esc_html($instance['title']) : esc_html__('CBX Flexible Countdown',
            'codeboxrflexiblecountdow');
        $cbfc_countdown_style = isset($instance['cbfc_countdown_style']) ? esc_html($instance['cbfc_countdown_style']) : 'light';
        $cbfc_date            = isset($instance['title']) ? strip_tags($instance['cbfc_date']) : CBFCHelper::getDefaultDate();
        $cbfc_hour            = isset($instance['cbfc_hour']) ? (int) strip_tags($instance['cbfc_hour']) : 0;
        $cbfc_min             = isset($instance['cbfc_min']) ? (int) strip_tags($instance['cbfc_min']) : 0;
        $cbfc_hide_sec        = isset($instance['cbfc_hide_sec']) ? esc_html($instance['cbfc_hide_sec']) : 'off';

        wp_enqueue_script('jquery-ui-datepicker');

        // Display the admin form
        include(cbfc_locate_template('classic_widgets/codeboxrflexiblecountdown-admin.php'));

    } // end form


    /**
     * Registers and enqueues widget admin interface specific styles and js
     */
    public function register_admin_styles_scripts()
    {
        wp_register_style('jquery-ui', plugin_dir_url(dirname(__FILE__)).'../assets/css/ui-lightness/jquery-ui.min.css',
            array(), CBFC_PLUGIN_VERSION);
        wp_enqueue_style('jquery-ui');

        wp_register_script('codeboxrflexiblecountdown-widget',
            plugin_dir_url(dirname(__FILE__)).'../assets/js/codeboxrflexiblecountdown-widget.js', array(
                'jquery',
                'jquery-ui-datepicker'
            ), CBFC_PLUGIN_VERSION, true);
        wp_enqueue_script('codeboxrflexiblecountdown-widget');
    }// end register_admin_styles

}// end class CodeboxrFlexibleCountdownWidget
<?php
/**
 * Provides an admin view of widget interface
 *
 *
 * @link       https://www.codeboxr.com
 * @since      1.0.0
 *
 * @package    codeboxrflexiblecountdown
 * @subpackage codeboxrflexiblecountdown/widgets/views
 */

if ( ! defined('WPINC')) {
    die;
}
?>


<?php
$countdown_list = CBFCHelper::getCountdownStyles();
?>

<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:',
            'codeboxrflexiblecountdown'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
           name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
</p>

<p>
    <label for="<?php echo $this->get_field_id('cbfc_countdown_style'); ?>"><?php esc_html_e('Countdown Style',
            'codeboxrflexiblecountdown'); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id('cbfc_countdown_style'); ?>"
            name="<?php echo $this->get_field_name('cbfc_countdown_style'); ?>">
        <?php foreach ($countdown_list as $list_id => $list_name): ?>
            <option value="<?php echo $list_id; ?>"<?php echo ($list_id == $cbfc_countdown_style) ? 'selected="selected"' : ''; ?>><?php echo $list_name; ?></option>
        <?php endforeach; ?>
    </select>
</p>

<p>
    <label for="<?php echo $this->get_field_id('cbfc_date'); ?>"><?php esc_html_e('Launch Date(Date format- mm/dd/yy)',
            'codeboxrflexiblecountdown'); ?></label>
    <input class="widefat datepicker cbfcdatepicker" id="<?php echo $this->get_field_id('cbfc_date'); ?>"
           name="<?php echo $this->get_field_name('cbfc_date'); ?>" type="text" placeholder="mm/dd/yyyy"
           value="<?php echo $cbfc_date; ?>"/>
</p>

<p>
    <label for="<?php echo $this->get_field_id('cbfc_hour'); ?>"><?php esc_html_e('Launch Hour',
            'codeboxrflexiblecountdown'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('cbfc_hour'); ?>"
           name="<?php echo $this->get_field_name('cbfc_hour'); ?>" type="text" value="<?php echo $cbfc_hour; ?>"/>
</p>

<p>
    <label for="<?php echo $this->get_field_id('cbfc_min'); ?>"><?php esc_html_e('Launch Minute',
            'codeboxrflexiblecountdown'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('cbfc_min'); ?>"
           name="<?php echo $this->get_field_name('cbfc_min'); ?>" type="text" value="<?php echo $cbfc_min; ?>"/>
</p>

<p>
    <label for="<?php echo $this->get_field_id('cbfc_hide_sec'); ?>">
        <?php esc_html_e('Hide Second', "cbxtakeatour"); ?>
    </label>
    <select class="widefat" name="<?php echo $this->get_field_name('cbfc_hide_sec'); ?>"
            id="<?php echo $this->get_field_id('cbfc_hide_sec'); ?>">
        <?php
        $options = array(
            'on'  => esc_html__('Yes', 'cbxtakeatour'),
            'off' => esc_html__('No', 'cbxtakeatour'),

        );
        foreach ($options as $key => $value) {
            echo '<option value="'.esc_html($key).'" id="'.esc_html($key).'" '.selected($cbfc_hide_sec,
                    $key, false).'>'.$value.'</option>';
        }
        ?>
    </select>
</p>
<?php
do_action('cbxflexiblecountdownwidgetform', $this, $instance);
?>
<p><a target="_blank"
      href="<?php echo admin_url('options-general.php?page=codeboxrflexiblecountdown'); ?>"><?php esc_html_e('Global Setting',
            'codeboxrflexiblecountdown'); ?></a></p>
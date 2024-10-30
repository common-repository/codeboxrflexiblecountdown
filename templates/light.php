<?php
/**
 * Provide a public view for the plugin
 *
 * This file is used to markup the light countdown template
 *
 * @link       https://www.codeboxr.com
 * @since      1.0.0
 *
 * @package    codeboxrflexiblecountdown
 * @subpackage codeboxrflexiblecountdown/templates
 */

if ( ! defined('WPINC')) {
    die;
}
?>
<?php do_action('cbfccountdown_before_display', $attr, $cbfc_light_counter); ?>
    <style type="text/css">
        #cbfc-light-countdown-<?php echo $cbfc_light_counter; ?> .cbfc-cd-background {
            border: 1px solid<?php echo $attr['l_numclr']; ?>;
            background: none repeat scroll 0 0<?php echo $attr['l_numbgclr']; ?>;
        }

        #cbfc-light-countdown-<?php echo $cbfc_light_counter; ?> .cbfc-cd-number .digit {
            color: <?php echo $attr['l_numclr']; ?>;
        }

        #cbfc-light-countdown-<?php echo $cbfc_light_counter; ?> .cbfc-overlap {
            background-color: <?php echo $attr['l_textbgclr']; ?>;
            color: <?php echo $attr['l_textclr']; ?>;
        }

        #cbfc-light-countdown-<?php echo $cbfc_light_counter; ?>.cbfc-light-countdown-480 .cbfc-cd-number .digit {
            color: <?php echo $attr['l_resnumclr']; ?>;
            width: 65%;
        }

        #cbfc-light-countdown-<?php echo $cbfc_light_counter; ?>.cbfc-light-countdown-480 .cbfc-overlap {
            color: <?php echo $attr['l_restextclr']; ?>;
        }

        <?php
       
         if ( intval($attr['hide_sec'])){
            ?>
        #cbfc-light-countdown-<?php echo $cbfc_light_counter; ?> .cbfc-number-box-sec {
            display: none !important;
        }

        <?php }?>

    </style>


    <ul id="cbfc-light-countdown-<?php echo $cbfc_light_counter; ?>"
        class="cbfc-light-countdown cbfc-light-countdown-<?php echo $cbfc_light_counter; ?> "
        data-date="<?php echo $attr['date']; ?>" data-hour="<?php echo $attr['hour']; ?>"
        data-min="<?php echo $attr['minute']; ?>">
        <li class="cbfc-number-box cbfc-number-box-day">
            <div class="cbfc-cd-main-container">
                <div class="cbfc-cd-background cbfc-cd-background-<?php echo $cbfc_light_counter; ?>">
                    <div class="cbfc-cd-days cbfc-cd-number dash days_dash"
                         data-color="<?php echo $attr['l_numclr']; ?>">
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                    </div>
                    <div class="cbfc-overlap cbfc-overlap-<?php echo $cbfc_light_counter; ?>"><?php esc_html_e('Days',
                            'codeboxrflexiblecountdown'); ?></div>
                </div>
            </div>
        </li>
        <li class="cbfc-number-box cbfc-number-box-hr">
            <div class="cbfc-cd-main-container">
                <div class="cbfc-cd-background">
                    <div class="cbfc-cd-hours cbfc-cd-number dash hours_dash">
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                    </div>

                    <div class="cbfc-overlap cbfc-overlap-<?php echo $cbfc_light_counter; ?>"><?php esc_html_e('Hours',
                            'codeboxrflexiblecountdown'); ?></div>
                </div>
            </div>
        </li>
        <li class="cbfc-number-box cbfc-number-box-min">
            <div class="cbfc-cd-main-container">
                <div class="cbfc-cd-background">
                    <div class="cbfc-cd-minutes cbfc-cd-number dash minutes_dash">
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                    </div>

                    <div class="cbfc-overlap cbfc-overlap-<?php echo $cbfc_light_counter; ?>"><?php esc_html_e('Minutes',
                            'codeboxrflexiblecountdown'); ?></div>
                </div>
            </div>
        </li>
        <li class="cbfc-number-box cbfc-number-box-sec">
            <div class="cbfc-cd-main-container">
                <div class="cbfc-cd-background">
                    <div class="cbfc-cd-seconds cbfc-cd-number dash seconds_dash">
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                        <div class="digit digit-<?php echo $cbfc_light_counter; ?>">0</div>
                    </div>

                    <div class="cbfc-overlap cbfc-overlap-<?php echo $cbfc_light_counter; ?>"><?php esc_html_e('Seconds',
                            'codeboxrflexiblecountdown'); ?></div>
                </div>
            </div>
        </li>
    </ul>
<?php do_action('cbfccountdown_after_display', $attr, $cbfc_light_counter);
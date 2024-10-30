<?php
/**
 * Provide a public view for the plugin
 *
 * This file is used to markup the circular countdown template
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

<?php do_action('cbfccountdown_before_display', $attr, $cbfc_circular_counter); ?>
    <style type="text/css">
        #cbfc-circular-countdown<?php echo $cbfc_circular_counter; ?> .cbfc-circular-clock-canvas {
            background-color: <?php echo $attr['c_bgclr']; ?>;
        }

        #cbfc-circular-countdown<?php echo $cbfc_circular_counter; ?> .cbfc-circular-text {
            color: <?php echo $attr['c_textclr']; ?>;
        }

        #cbfc-circular-countdown<?php echo $cbfc_circular_counter; ?>.cbfc-circular-countdown-container-480 .cbfc-circular-text .cbfc-circular-type-time {
            color: <?php echo $attr['c_restextclr']; ?>;
        }

        <?php
        if ( intval($attr['hide_sec']))
        {
            ?>
        #cbfc-circular-countdown<?php echo $cbfc_circular_counter; ?> .cbfc-circular-clock-seconds {
            display: none !important;
        }

        <?php } ?>
    </style>

    <!-- Circular countdown -->
    <div id="cbfc-circular-countdown<?php echo $cbfc_circular_counter; ?>"
         class="cbfc-circular-countdown cbfc-circular-countdown-container" data-date="<?php echo $attr['date']; ?>"
         data-hour="<?php echo $attr['hour']; ?>" data-min="<?php echo $attr['minute']; ?>"
         data-sec-border-clr="<?php echo $attr['c_secbclr']; ?>" data-min-border-clr="<?php echo $attr['c_minbclr']; ?>"
         data-hour-border-clr="<?php echo $attr['c_hourbclr']; ?>"
         data-days-border-clr="<?php echo $attr['c_daybclr']; ?>"
         data-borderw="<?php echo intval($attr['c_borderw']); ?>">
        <div class="cbfc-clock-container clock">
            <div class="cbfc-circular-clock-item cbfc-circular-clock-days cbfc-circular-countdown-time-value">
                <div class="cbfc-wrap">
                    <div class="cbfc-circular-inner">
                        <div id="cbfc-circular-canvas-days<?php echo $cbfc_circular_counter; ?>"
                             class="cbfc-circular-clock-canvas cbfc-circular-clock-canvas<?php echo $cbfc_circular_counter; ?>"></div>
                        <div class="cbfc-circular-text cbfc-circular-text<?php echo $cbfc_circular_counter; ?>">
                            <div class="cbfc-circular-val">0</div>
                            <div class="cbfc-circular-type-days cbfc-circular-type-time"><?php esc_html_e('Days',
                                    'codeboxrflexiblecountdown'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cbfc-circular-clock-item cbfc-circular-clock-hours cbfc-circular-countdown-time-value">
                <div class="cbfc-wrap">
                    <div class="cbfc-circular-inner">
                        <div id="cbfc-circular-canvas-hours<?php echo $cbfc_circular_counter; ?>"
                             class="cbfc-circular-clock-canvas cbfc-circular-clock-canvas<?php echo $cbfc_circular_counter; ?>"></div>
                        <div class="cbfc-circular-text cbfc-circular-text<?php echo $cbfc_circular_counter; ?>">
                            <div class="cbfc-circular-val">0</div>
                            <div class="cbfc-circular-type-hours cbfc-circular-type-time"><?php esc_html_e('Hours',
                                    'codeboxrflexiblecountdown'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cbfc-circular-clock-item cbfc-circular-clock-minutes cbfc-circular-countdown-time-value">
                <div class="cbfc-wrap">
                    <div class="cbfc-circular-inner">
                        <div id="cbfc-circular-canvas-minutes<?php echo $cbfc_circular_counter; ?>"
                             class="cbfc-circular-clock-canvas cbfc-circular-clock-canvas<?php echo $cbfc_circular_counter; ?>"></div>
                        <div class="cbfc-circular-text cbfc-circular-text<?php echo $cbfc_circular_counter; ?>">
                            <div class="cbfc-circular-val">0</div>
                            <div class="cbfc-circular-type-minutes cbfc-circular-type-time"><?php esc_html_e('Minutes',
                                    'codeboxrflexiblecountdown'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cbfc-circular-clock-item cbfc-circular-clock-seconds cbfc-circular-countdown-time-value">
                <div class="cbfc-wrap">
                    <div class="cbfc-circular-inner">
                        <div id="cbfc-circular-canvas-seconds<?php echo $cbfc_circular_counter; ?>"
                             class="cbfc-circular-clock-canvas cbfc-circular-clock-canvas<?php echo $cbfc_circular_counter; ?>"></div>
                        <div class="cbfc-circular-text cbfc-circular-text<?php echo $cbfc_circular_counter; ?>">
                            <div class="cbfc-circular-val">0</div>
                            <div class="cbfc-circular-type-seconds cbfc-circular-type-time"><?php esc_html_e('Seconds',
                                    'codeboxrflexiblecountdown'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p style="clear:both;"></p>
<?php do_action('cbfccountdown_after_display', $attr, $cbfc_circular_counter);
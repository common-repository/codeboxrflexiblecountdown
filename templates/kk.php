<?php
/**
 * Provide a public view for the plugin
 *
 * This file is used to markup the kk countdown template
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
<?php do_action('cbfccountdown_before_display', $attr, $cbfc_kk_counter); ?>
    <style type="text/css">
        #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkcountdown-box {
            font-weight: 300;
            font-size: <?php echo $attr['kk_fontsize']; ?>px;
            color: <?php echo $attr['kk_numclr']; ?>;
        }

        #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkcountdown-box .kkc-days-text,
        #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkcountdown-box .kkc-hours-text,
        #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkcountdown-box .kkc-min-text,
        #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkcountdown-box .kkc-sec-text {
            color: <?php echo $attr['kk_textclr']; ?>;
        }

        <?php
       
        if ( intval($attr['hide_sec']))
        {
            ?>
        #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkc-sec, #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkc-sec-text {
            display: none !important;
        }

        <?php } ?>

        @media (max-width: 767px) {
            #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkcountdown-box {
                font-size: 43px;
            }
        }

        @media (max-width: 480px) {
            #cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?> .kkcountdown-box {
                font-size: 21px;
            }
        }
    </style>
<?php $kk_count_down = explode('/', $attr['date']); ?>
    <div id="cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?>"
         class="cbfc-kkcountdown cbfc-kkcountdown<?php echo $cbfc_kk_counter; ?>"
         data-time="<?php echo mktime($attr['hour'],
             $attr['minute'],
             0,
             $kk_count_down[0],
             $kk_count_down[1],
             $kk_count_down[2]); ?>"></div> <!-- End of KKCountdown Div -->
<?php do_action('cbfccountdown_after_display', $attr, $cbfc_kk_counter);
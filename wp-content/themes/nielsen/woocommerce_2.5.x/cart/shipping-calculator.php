<?php
/**
 * Shipping Calculator
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ) {
    return;
}

?>

<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>


    <h3 class="head"><?php _e( 'Calculate Shipping', 'yit' ); ?></h3>

    <table class="shop_table shipping" cellspacing="0">
        <tr>
            <td>

                <section class="clearfix shipping-calculator-form">

                    <p class="form-row form-row-wide">
                        <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
                            <option value=""><?php _e( 'Select a country&hellip;', 'yit' ); ?></option>
                            <?php
                            foreach( WC()->countries->get_shipping_countries() as $key => $value )
                                echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
                            ?>
                        </select>
                    </p>

                    <p class="form-row form-row-wide">
                        <?php
                        $current_cc = WC()->customer->get_shipping_country();
                        $current_r  = WC()->customer->get_shipping_state();
                        $states     = WC()->countries->get_states( $current_cc );

                        // Hidden Input
                        if ( is_array( $states ) && empty( $states ) ) {

                            ?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e( 'State / county', 'yit' ); ?>" /><?php

                            // Dropdown Input
                        } elseif ( is_array( $states ) ) {

                            ?><span>
                            <select name="calc_shipping_state" id="calc_shipping_state" class="state_select" placeholder="<?php _e( 'State / county', 'yit' ); ?>">
                                <option value=""><?php _e( 'Select a state&hellip;', 'yit' ); ?></option>
                                <?php
                                foreach ( $states as $ckey => $cvalue )
                                    echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . __( esc_html( $cvalue ), 'yit' ) .'</option>';
                                ?>
                            </select>
                            </span><?php

                            // Standard Input
                        } else {

                            ?><input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php _e( 'State / county', 'yit' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php

                        }
                        ?>
                    </p>

                    <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

                        <p class="form-row form-row-wide">
                            <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php _e( 'City', 'yit' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
                        </p>

                    <?php endif; ?>

                    <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

                        <p class="form-row form-row-wide form-row-wide-last">
                            <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php _e( 'Postcode / Zip', 'yit' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                        </p>

                    <?php endif; ?>

                    <div class="clearfix"></div>

                    <button type="submit" name="calc_shipping" value="1" class="btn btn-flat-red"><?php _e( 'Update', 'yit' ); ?></button>

                    <?php wp_nonce_field( 'woocommerce-cart' ); ?>

                </section>

            </td>
        </tr>
    </table>


<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
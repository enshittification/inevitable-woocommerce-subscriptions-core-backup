<?php
/**
 * Display a row in the related orders table for a subscription or order
 *
 * @var array $order A WC_Order or WC_Subscription order object to display
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<tr>
	<td style="border-top: 0;">
		<a href="<?php echo esc_url( get_edit_post_link( $order->id ) ); ?>">
			<?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce-subscriptions' ) . $order->get_order_number() ); ?>
		</a>
	</td>
	<td style="border-top: 0;">
		<?php esc_html_e( ucfirst( $order->relationship ) ); ?>
	</td>
	<td style="border-top: 0;">
		<?php

		$timestamp_gmt = strtotime( $order->post->post_date_gmt );

		if ( $timestamp_gmt > 0 ) {

			$t_time    = get_the_time( __( 'Y/m/d g:i:s A', 'woocommerce-subscriptions' ), $post );
			$time_diff = $timestamp_gmt - current_time( 'timestamp', true );

			if ( $time_diff > 0 && $time_diff < WEEK_IN_SECONDS ) {
				$date_to_display = sprintf( __( 'In %s', 'woocommerce-subscriptions' ), human_time_diff( current_time( 'timestamp', true ), $timestamp_gmt ) );
			} elseif ( $time_diff < 0 && absint( $time_diff ) < WEEK_IN_SECONDS ) {
				$date_to_display = sprintf( __( '%s ago', 'woocommerce-subscriptions' ), human_time_diff( current_time( 'timestamp', true ), $timestamp_gmt ) );
			} else {
				$timestamp_site  = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $timestamp_gmt ) );
				$date_to_display = date_i18n( wc_date_format(), $timestamp_site ) . ' ' . date_i18n( wc_time_format(), $timestamp_site );
			}
		} else {
			$t_time = $date_to_display = __( 'Unpublished', 'woocommerce-subscriptions' );
		} ?>
		<abbr title="<?php echo esc_attr( $t_time ); ?>">
			<?php echo esc_html( apply_filters( 'post_date_column_time', $date_to_display, $order->post ) ); ?>
		</abbr>
	</td>
	<td style="border-top: 0;">
		<?php echo esc_html( ucwords( $order->get_status() ) ); ?>
	</td>
	<td style="border-top: 0; text-align:right;">
		<span class="amount"><?php echo $order->get_formatted_order_total(); ?></span>
	</td>
</tr>

<?php
/**
 * WooCommerce wrapper (shop, product, cart, checkout).
 *
 * @package Barakah_Paths
 */

get_header();
?>
<div class="wrap section">
	<?php woocommerce_content(); ?>
</div>
<?php
get_footer();

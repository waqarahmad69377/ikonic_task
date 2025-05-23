<?php

/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$footer_nav_menu = wp_nav_menu([
	'theme_location' => 'menu-2',
	'fallback_cb' => false,
	'container' => false,
	'echo' => false,
]);
?>
<footer id="site-footer" class="site-footer">
	<?php if ($footer_nav_menu) : ?>
		<?php echo '<img src="' . hs_give_me_coffee() . '" alt="Here is your coffee!" style="width:100px;height:auto;display:inline-block;border-radius:10px;" />'; ?>
		<nav class="site-navigation" aria-label="<?php echo esc_attr__('Footer menu', 'hello-elementor'); ?>">
			<?php
			// PHPCS - escaped by WordPress with "wp_nav_menu"
			echo $footer_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</nav>
	<?php endif; ?>
</footer>
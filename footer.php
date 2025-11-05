<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
?>

<footer id="site-footer" class="site-footer" role="contentinfo">
<div id="copyright">
<?php echo sprintf( __( '%1$s %2$s %3$s.', 'dezinux' ), '&copy;', date( 'Y' ), esc_html( get_bloginfo( 'name' ) ) ); echo sprintf( __( ' Theme By: %1$s.', 'dezinux' ), '<a href="https://dezinux.com/">Dezinux</a>' ); ?>
</div>	
</footer>

<?php
}
?>

<?php wp_footer(); ?>

</body>
</html>

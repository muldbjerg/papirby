<?php
/**
 * Template Name: Afdelinger Template
 * Template Post Type: page
 *
 */

 get_header();

 $post_slug = $post->post_name;
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to storefront_page add_action
	 *
	 * @hooked storefront_page_header          - 10
	 * @hooked storefront_page_content         - 20
	 */
	do_action( 'storefront_page' );
	?>
</article><!-- #post-## -->

 <div class="about-group-map">
        <?php get_template_part( 'inc/map' ) ?>
    </div>
    
</div>

<?php
    get_footer();
    ?>


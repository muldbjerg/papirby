<?php
 get_header();
?>


<?php while ( have_posts() ) : the_post(); // standard WordPress loop. ?>

<div class="single-content">
    <a class="back-link" href="<?php echo get_site_url(); ?>/gruppen/nyheder/">← Tilbage til nyheder</a>

    <p class="post-meta-data"><?php echo get_the_date(); ?>  <?php edit_post_link('Rediger nyhed'); ?></p>
    <h1><?php the_title(); ?></h1>
    <div><?php  the_content() ?></div>
   
</div>

<?php endwhile; // end of the loop. ?>



<?php
    get_footer();
?>


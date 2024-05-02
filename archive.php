<?php
 get_header();
?>

<h1>
    <?php single_cat_title( ); ?>
</h1>

<?php while ( have_posts() ) : the_post(); // standard WordPress loop. ?>

<h3><?php the_title(); ?></h3>
<div><?php  the_content() ?></div>

<?php endwhile; // end of the loop. ?>



<?php
    get_footer();
?>


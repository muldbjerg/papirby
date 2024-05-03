<?php
 get_header();
?>

<h1 class="nyheds-page">
    <?php single_post_title(); ?>
</h1>

<div class="nyheds-posts">


    <?php while ( have_posts() ) : the_post(); // standard WordPress loop. ?>

        <a class="post" href="<?php the_permalink(); ?>">

            
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
            
            <div class="post-content">
                <h2><?php the_title(); ?></h2>
                <p class="post-meta-data"><?php echo get_the_date(); ?></p>
                <div><?php  the_excerpt() ?></div>
            </div>
            
        </a>

    <?php endwhile; // end of the loop. ?>
</div>

<div class="nyheds-posts-pagination">
    <?php the_posts_pagination(); ?>
</div>
 

<?php
    get_footer();
?>


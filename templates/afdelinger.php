<?php
/**
 * Template Name: Afdelinger Template
 * Template Post Type: page
 *
 */

 get_header();

 $post_slug = $post->post_name;
?>

<h1>
    <?php single_cat_title( ); ?>
</h1>

<?php while ( have_posts() ) : the_post(); // standard WordPress loop. ?>

<h2><?php the_title(); ?></h2>
<div><?php  the_content() ?></div>

 <?php endwhile; // end of the loop. ?>




    <div id="afdelinger-enheder">
    <?php
        $args = array(
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_type' => 'enheder',
            'tax_query' => array(
                array (
                    'taxonomy' => 'afdelinger',
                    'field' => 'slug',
                    'terms' => $post_slug,
                )
            ),
        );

        $enheds_query = new WP_Query( $args ); ?>


    <?php if ( $enheds_query->have_posts() ) : ?>

        <?php while ( $enheds_query->have_posts() ) : $enheds_query->the_post(); ?>
           
            <?php // print_r( get_the_terms(get_post) ) 
                $terms = get_the_terms( $post->ID, 'afdelinger' );
            ?>


            <h2><?php the_title(); ?></h2>
            <div class="enheds-card-info-sub">
                <p><?php the_field('aldersgruppe'); ?></p>
                <p><?php the_field('modetidspunkt'); ?></p>
            </div>


            <!-- <a href="<?php echo site_url('afdelinger/' . $terms[0] -> slug); ?>">
                <div class="enheds-card" style="background-image:url('<?php the_field('enheds_billed'); ?>')">
                    <div class="enheds-card-info">
                        <h2><?php the_title(); ?></h2>
                        <div class="enheds-card-info-sub">
                            <p><?php the_field('aldersgruppe'); ?></p>
                            <p><?php the_field('modetidspunkt'); ?></p>
                        </div>
                    </div>
                </div>
            </a> -->
        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

        <?php endif; ?>
    </div>

<?php
    get_footer();
?>


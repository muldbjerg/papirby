<?php
/**
 * Template Name: Forside Template
 * Template Post Type: page
 *
 */

 get_header();
?>
        
<div id="forside-page">

    <div class="hero-spot">
        <div class="hero-spot-image">
            <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/hero-spot.webp" alt="" > -->
            <img src="<?php echo get_field('herospot_billed') ?>" alt="" >

            <?php if(get_field('herospot_billed_kredit')) : ?>
            <p class="caption">Foto: <?php the_field('herospot_billed_kredit', false, false) ?></p>
            <?php endif; ?>

            <div class="blob"></div>
            <div class="blob two"></div>
            <div class="blob three"></div>
            
        </div>
        <div class="hero-spot-text">
            <h1><span>Få oplevelser,</span> <span>og venner</span> <span>inde i naturen</span></h1>
            <p><?php the_field('herospot_tekst'); ?></p>

            <div class="hero-spot-actions">
                <a href="bliv-spejder" class="btn-primary">Bliv spejder</a>
                <!-- <a href="" class="btn-tertiary">Hvad er spejder?</a> -->
            </div>
        </div>

    </div>

    <div class="about-group">
        <h2>Bliv spejder <br/> overalt i Silkeborg</h2>

        <div class="about-group-text">
            <?php the_field('map_tekst') ?>
        </div>

        <div class="about-group-map">
            <?php get_template_part( 'inc/map' ) ?>
        </div>
    </div>

    <div class="forside-nyheder">
        <div class="forside-nyheder-title">
            <h2>Nyheder</h2>
            <p>Følg med i hvad der sker hos Silkeborg Spejderne</p>
        </div>

        <div class="forside-nyheder-posts">
            <?php $latest_post = get_posts( 'numberposts=4' ); ?>
            <?php foreach( $latest_post as $post ) : setup_postdata( $post ); ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="forside-nyheder-post-card">
                        <div class="thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>

                        <p class="forside-nyheder-post-card-meta"><?php echo get_the_date(); ?></p>
                        <h3><?php the_title(); ?></h3>
                        <p class="forside-nyheder-post-card-teaser"><?php the_field('forside_teaser'); ?></p>
                        <div class="forside-nyheder-post-card-read-more">
                            <p>Læs mere</p> 
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="12" height="12"><rect width="26" height="26" fill="none"/><line x1="64" y1="192" x2="192" y2="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="88 64 192 64 192 168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php wp_reset_query(); ?>

        </div>
    </div>

</div>


<?php
    get_footer();
?>
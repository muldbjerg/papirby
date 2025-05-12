<?php
/**
 * Template Name: Afdelings Template
 * Template Post Type: page
 *
 */

 get_header();

 $post_slug = $post->post_name;
?>



<?php while ( have_posts() ) : the_post(); // standard WordPress loop. ?>
<div class="afdeling-page">


    <h1><?php the_title(); ?></h1>
    <div class="afdeling-content">
        <div class="afdeling-text">
            <?php  the_content() ?>
        </div>

        <div>
            <img src="<?php the_field('afdelings_billed'); ?>" alt="">
        </div>
    </div>

    <div class="afdeling-info">
        <div>
            <div>
                <div class="afdeling-info-icon">
                    <svg width="36" height="29" viewBox="0 0 36 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 8.59517L18.317 1L35.634 8.59517" stroke="currentColor"/>
                        <path d="M1 12.5444L18.317 4.94922L35.634 12.5444" stroke="currentColor"/>
                        <path d="M13.1562 9.80859H23.4857" stroke="currentColor"/>
                        <path d="M9.20312 13.457H27.4315" stroke="currentColor"/>
                        <path d="M9.20312 16.4961H27.4315" stroke="currentColor"/>
                        <path d="M9.20312 20.1406H14.6716M27.4315 20.1406H21.3554" stroke="currentColor"/>
                        <path d="M9.20312 23.7852H14.6716M27.4315 23.7852H21.3554" stroke="currentColor"/>
                        <path d="M9.20312 27.4336H14.6716M27.4315 27.4336H21.3554" stroke="currentColor"/>
                        <path d="M21.3556 27.8889V16.4961M14.6719 27.8889V16.4961" stroke="currentColor"/>
                        <circle cx="31.6883" cy="15.8875" r="2.43045" stroke="currentColor"/>
                        <circle cx="4.94608" cy="15.8875" r="2.43045" stroke="currentColor"/>
                        <circle cx="31.6883" cy="20.7469" r="2.43045" stroke="currentColor"/>
                        <circle cx="4.94608" cy="20.7469" r="2.43045" stroke="currentColor"/>
                        <circle cx="31.6883" cy="25.6062" r="2.43045" stroke="currentColor"/>
                        <circle cx="4.94608" cy="25.6062" r="2.43045" stroke="currentColor"/>
                    </svg>
                </div>
            </div>
            <div class="afdeling-info-text">
                <p class="afdeling-info-label">Adresse</p>
                <?php the_field('afdelings_adresse'); ?>
            </div>
        </div>
        <div>
            <div>

                <div class="afdeling-info-icon">
                    <svg width="24" height="38" viewBox="0 0 24 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.97656 11.6914L10.5963 15.3922" stroke="currentColor"/>
                        <path d="M14.0191 30.6072L12.6484 29.9219" stroke="currentColor"/>
                        <path d="M11.5547 34.0317L14.5701 36.4989L13.6107 24.5742" stroke="currentColor"/>
                        <path d="M11.9653 18.6815L4.70077 1C4.70077 1 3.46718 1.95946 2.78185 2.64479C2.09653 3.33012 1 4.56371 1 4.56371L10.1834 21.1486" stroke="currentColor" stroke-linejoin="round"/>
                        <path d="M11.0057 21.0116L18.9555 1C18.9555 1 20.1891 1.95946 20.8744 2.64479C21.5597 3.33012 22.6562 4.56371 22.6562 4.56371L13.6099 21.0116" stroke="currentColor" stroke-linejoin="round"/>
                        <path d="M4.70312 1H18.958" stroke="currentColor"/>
                        <rect x="9.90625" y="21.0117" width="3.83784" height="3.56371" stroke="currentColor"/>
                        <path d="M6.48438 5.24609H17.1755" stroke="currentColor"/>
                        <path d="M10.1832 24.5742L8.8125 35.9507L12.2391 33.4835L13.1986 24.5742" stroke="currentColor"/>
                        <path d="M9.49219 30.1956L12.7818 28.5508" stroke="currentColor"/>
                        <path d="M22.6544 4.5625L15.6641 9.08567" stroke="currentColor"/>
                        <path d="M18.8186 11.5547L13.3359 15.1184" stroke="currentColor"/>
                        <path d="M1 4.5625L8.12741 9.3598" stroke="currentColor"/>
                    </svg>
                </div>
            </div>
            <div class="afdeling-info-text">
                <p class="afdeling-info-label">Kontakt</p>
                <?php the_field('afdelings_kontakt'); ?>
            </div>
        </div>
    </div>
    
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
            $enheds_query = new WP_Query( $args ); 
            ?>

    <?php if ( $enheds_query->have_posts() ) : ?>

        <h2>Enheder</h2>
        
        <?php 
            while ( $enheds_query->have_posts() ) : $enheds_query->the_post(); 

            $terms = get_the_terms( $post->ID, 'afdelinger' );
        ?>
            <div class="afdelings-enheds-card">

                <h3><?php the_title(); ?></h3>
                <div class="afdelings-enheds-card-content">
                    <div>
                        <div class="enheds-card-info-sub">
                            <p><?php the_field('aldersgruppe'); ?></p>
                            <p><?php the_field('modetidspunkt'); ?></p>
                        </div>
                        <?php the_content(); ?>
                    </div>
                    <div class="afdelings-enheds-card-content-additional">
                        <h4>Enhedsleder</h4>
                        <div class="enhedsleder-info">
                            <div>
                                <?php if(get_field('enhedsleder_billed')) : ?>
                                    <img class="enhedsleder-billed" src="<?php the_field('enhedsleder_billed') ?>" alt="">
                                <?php endif; ?>
                            </div>

                            <div>
                                <?php the_field('enhedsleder') ?>
                            </div>
                        </div>

                        <?php
                            $dateToCheck = get_field('enheds_programmet_udlober');
                            $currentDate = date('d-m-Y'); 

                            if(get_field('enheds_program') && (empty($dateToCheck) || $dateToCheck >= $currentDate)) :
                        ?>
                        
                            <h4>Program</h4>
                            <a href="<?php the_field('enheds_program'); ?>" class="btn-secondary" download>Download program</a>

                
                        <?php 
                            endif; 
                        ?>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>

    <?php wp_reset_postdata(); ?>

    <?php endif; ?>
    <div style="width: 100%; clear:both;"></div>
    </div>
</div>

<?php
    get_footer();
    ?>


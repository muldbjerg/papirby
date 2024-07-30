<?php
/**
 * Template Name: Bliv Spejder Template
 * Template Post Type: page
 *
 */

 get_header();

 $foto_credits = array();
?>


<div id="bliv-spejder-page">

    <div class="bliv-spejder-header">
        <p>Kom med ind i naturen</p>
        <h1><?php the_title(); ?></h1>
        <img class="bliv-spejder-scarf" src="<?php echo get_stylesheet_directory_uri(); ?>/images/scarf.webp" alt="">
    </div>

    <div class="bliv-spejder-page-content">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        the_content();
        endwhile; else: ?>
        <p>Sorry, no posts matched your criteria.</p>
        <?php endif; ?>
    </div>
    
<div class="bliv-spejder-enheds-oversigt">
    <!-- <div class="bliv-spejder-enheds-filtre">
        <div>
            <button class="filterButton" data-value="alderslyst">Alderslyst</button>
            <button class="filterButton" data-value="funder">Funder</button>
            <button class="filterButton" data-value="goedvad">G<span class="kerning">ø</span>dvad</button>
            <button class="filterButton" data-value="virklund">Virklund</button>
        </div>
    </div> -->

    <div id="bliv-spejder-enheds-oversigt-container">
        <?php
            $args = array(
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'post_type' => 'enheder',
                'posts_per_page' => -1,
            );
            $enheds_query = new WP_Query( $args ); ?>

            <?php if ( $enheds_query->have_posts() ) : ?>

                <?php while ( $enheds_query->have_posts() ) : $enheds_query->the_post(); ?>
                    <!-- Saves photo credits to be shown at the bottom -->
                    <?php  array_push($foto_credits, get_field('enheds_billed_kredit')) ?>

                    <?php 
                        $terms = get_the_terms( $post->ID, 'afdelinger' );
                    ?>


                    <a href="<?php echo site_url('afdelinger/' . $terms[0] -> slug); ?>">
                    <div class="enheds-card" style="background-image:url('<?php the_field('enheds_billed'); ?>')">
                            <div class="enheds-card-info">
                                <h2><?php the_title(); ?></h2>
                                <div class="enheds-card-info-sub">
                                    <p><?php the_field('aldersgruppe'); ?></p>
                                    <p><?php the_field('modetidspunkt'); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php endif; ?>
    </div>

    <div class="bliv-spejder-enheds-oversigt-photo-credits">
        Foto: <?php 
        foreach (array_unique($foto_credits) as &$value) {
            if(isset($value )) {
                
                echo '<span class="foto-credit">' . $value . '</span>';
            }
        };
        ?>
    </div>
</div>



<?php //print_r(array_unique($foto_credits)) ?>
    
</div>

<!-- <script>
    (function(){
        let enheder = document.querySelectorAll('.filterButton');
        let oversigt = document.querySelector('#bliv-spejder-enheds-oversigt-container');

        enheder.forEach(enhedFilterBtn => {
            enhedFilterBtn.addEventListener('click', () => {
                removeAllActive();
                console.log(enhedFilterBtn.getAttribute('data-value'));

                oversigt.removeAttribute("class")
                var selectedFilter = enhedFilterBtn.getAttribute('data-value');
               oversigt.classList.add(selectedFilter)


                setTimeout(() => {
                    enhedFilterBtn.classList.toggle('active');
                }, 0);
            });
        });

        function removeAllActive(){
            enheder.forEach(enhedFilterBtn => {
                enhedFilterBtn.classList.remove('active');
            });
        }
    })()
</script> -->


<?php
    get_footer();
?>
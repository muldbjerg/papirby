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
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/hero-spot.webp" alt="" >
            <p class="caption">Foto: frederik-kehlet.com</p>
            <div class="blob"></div>
            <div class="blob two"></div>
            <div class="blob three"></div>
            
        </div>
        <div class="hero-spot-text">
            <h1><span>Få oplevelser</span> <span>og venner</span> <span>inde i naturen</span></h1>
            <p>Kom og vær med til spejder 4 forskellige steder i Silkeborg.</p>
            <div class="hero-spot-actions">
                <a href="index.php/bliv-spejder/" class="btn-primary">Bliv spejder</a>
                <a href="" class="btn-tertiary">Hvad er spejder?</a>
            </div>
        </div>

    </div>

</div>


<?php
    get_footer();
?>
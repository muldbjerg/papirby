<?php
/**
 * Title: Afdelings Map
 * Slug: papirby/map
 * Categories: papirby-layout
 * Description: Displays the KFUM Silkeborg locations map
 */
?>
<!-- wp:group {"className":"map"} -->
<div class="wp-block-group map">
    <!-- wp:image {"id":0,"sizeSlug":"full","linkDestination":"none"} -->
    <figure class="wp-block-image size-full">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/Frame67.png'); ?>" alt="Map" />
    </figure>
    <!-- /wp:image -->
    
    <!-- wp:group {"className":"location-markers"} -->
    <div class="wp-block-group location-markers">
        
        <!-- wp:html  -->
        <a href="<?php echo get_site_url(); ?>/afdelinger/alderslyst/" class="location alderslyst">
            <div class="location alderslyst">
            
                <!-- wp:template-part {"slug":"header","tagName":"header"} /-->

                <p>Alderslyst</p>
            </div>
        </a>
        <!-- /wp:html -->

        <!-- wp:group {"className":"location funder"} -->
        <div class="wp-block-group location funder">
            <!-- wp:group {"className":"location-marker background"} -->
            <div class="wp-block-group location-marker background"></div>
            <!-- /wp:group -->
            <!-- wp:paragraph -->
            <p>Funder</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"className":"location goedvad"} -->
        <div class="wp-block-group location goedvad">
            <!-- wp:group {"className":"location-marker background"} -->
            <div class="wp-block-group location-marker background"></div>
            <!-- /wp:group -->
            <!-- wp:paragraph -->
            <p>Gødvad</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"className":"location virklund"} -->
        <div class="wp-block-group location virklund">
            <!-- wp:group {"className":"location-marker background"} -->
            <div class="wp-block-group location-marker background"></div>
            <!-- /wp:group -->
            <!-- wp:paragraph -->
            <p>Virklund</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
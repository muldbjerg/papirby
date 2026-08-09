<?php
/**
 * Single Event Template for Begivenheder CPT
 */

get_header();

while (have_posts()) : the_post();
    $start_raw        = get_field('start_dato');
    $slut_raw         = get_field('slut_dato');
    $tilmeldingsfrist = get_field('tilmeldingsfrist');
    $tilmeldings_link = get_field('tilmeldings_link');

    $event_afdelinger = get_the_terms(get_the_ID(), 'afdelinger');
    $event_kategorier = get_the_terms(get_the_ID(), 'begivenhed_kategori');

    // Format dates cleanly
    $start_formatted = $start_raw ? date('d.m.Y H:i', strtotime($start_raw)) : '';
    $slut_formatted  = $slut_raw ? date('d.m.Y H:i', strtotime($slut_raw)) : '';
    $frist_formatted = $tilmeldingsfrist ? date('d.m.Y', strtotime($tilmeldingsfrist)) : '';

    $info_items = array_filter(array(
        'Dato'             => $start_formatted ? ($start_formatted . ($slut_formatted ? ' - ' . $slut_formatted : '')) : null,
        'Tidspunkt'        => get_field('tidspunkt_tekst'),
        'Mødested'         => get_field('location_sted'),
        'Pris'             => get_field('pris'),
        'Tilmeldingsfrist' => $frist_formatted,
        'Kontakt'          => get_field('kontaktperson'),
    ));
?>

<div class="single-event-container">
    <div class="single-event-header">
        <a class="back-link" href="<?php echo home_url('/praktisk/kalender/'); ?>">← Tilbage til kalender</a>

        <div class="event-tags">
            <?php if (!empty($event_afdelinger) && !is_wp_error($event_afdelinger)) : ?>
                <?php foreach ($event_afdelinger as $afdel) : ?>
                    <span class="tag tag-afdeling"><?php echo esc_html($afdel->name); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($event_kategorier) && !is_wp_error($event_kategorier)) : ?>
                <?php foreach ($event_kategorier as $kat) : ?>
                    <span class="tag tag-kategori"><?php echo esc_html($kat->name); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h1><?php the_title(); ?></h1>
        <?php edit_post_link('Rediger begivenhed', '<p class="admin-edit-link">', '</p>'); ?>
    </div>

    <div class="single-event-layout">
        <!-- Main Content Column -->
        <div class="single-event-content">
            <?php if (has_post_thumbnail()) : ?>
                <div class="single-event-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>

        <!-- Sidebar / Event Info Box -->
        <aside class="single-event-sidebar">
            <div class="event-info-card">
                <h3>Praktisk information</h3>

                <?php if (!empty($info_items)) : ?>
                    <ul class="event-info-list">
                        <?php foreach ($info_items as $label => $val) : ?>
                            <li>
                                <strong class="label"><?php echo esc_html($label); ?>:</strong>
                                <span><?php echo esc_html($val); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($tilmeldings_link) : ?>
                    <div class="sidebar-signup-action">
                        <a href="<?php echo esc_url($tilmeldings_link); ?>" target="_blank" rel="noopener" class="btn-sidebar-signup">
                            Gå til tilmelding
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<?php
endwhile;
get_footer();
?>

<?php
/**
 * Single Event Template for Begivenheder CPT
 */

get_header();

while (have_posts()) : the_post();
    $start_raw = get_field('start_dato');
    $slut_raw = get_field('slut_dato');
    $tidspunkt_tekst = get_field('tidspunkt_tekst');
    $location = get_field('location_sted');
    $pris = get_field('pris');
    $tilmeldings_link = get_field('tilmeldings_link');
    $tilmeldingsfrist = get_field('tilmeldingsfrist');
    $kontaktperson = get_field('kontaktperson');

    $event_afdelinger = get_the_terms(get_the_ID(), 'afdelinger');
    $event_kategorier = get_the_terms(get_the_ID(), 'begivenhed_kategori');

    // Format dates
    $start_formatted = '';
    $slut_formatted = '';
    if ($start_raw) {
        $dt_start = DateTime::createFromFormat('Y-m-d H:i:s', $start_raw);
        if ($dt_start) {
            $start_formatted = $dt_start->format('d.m.Y H:i');
        }
    }
    if ($slut_raw) {
        $dt_slut = DateTime::createFromFormat('Y-m-d H:i:s', $slut_raw);
        if ($dt_slut) {
            $slut_formatted = $dt_slut->format('d.m.Y H:i');
        }
    }
    $frist_formatted = '';
    if ($tilmeldingsfrist) {
        $dt_frist = DateTime::createFromFormat('Y-m-d', $tilmeldingsfrist);
        if ($dt_frist) {
            $frist_formatted = $dt_frist->format('d.m.Y');
        } else {
            $frist_formatted = $tilmeldingsfrist;
        }
    }
?>

<div class="single-event-container">
    <div class="single-event-header">
        <a class="back-link" href="<?php echo home_url('/kalender/'); ?>">← Tilbage til kalender</a>

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

                <ul class="event-info-list">
                    <?php if ($start_formatted) : ?>
                        <li>
                            <strong class="label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Dato:
                            </strong>
                            <span><?php echo esc_html($start_formatted); ?><?php echo $slut_formatted ? ' - ' . esc_html($slut_formatted) : ''; ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ($tidspunkt_tekst) : ?>
                        <li>
                            <strong class="label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Tidspunkt:
                            </strong>
                            <span><?php echo esc_html($tidspunkt_tekst); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ($location) : ?>
                        <li>
                            <strong class="label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Mødested:
                            </strong>
                            <span><?php echo esc_html($location); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ($pris) : ?>
                        <li>
                            <strong class="label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                Pris:
                            </strong>
                            <span><?php echo esc_html($pris); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ($frist_formatted) : ?>
                        <li>
                            <strong class="label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Tilmeldingsfrist:
                            </strong>
                            <span><?php echo esc_html($frist_formatted); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ($kontaktperson) : ?>
                        <li>
                            <strong class="label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Kontakt:
                            </strong>
                            <span><?php echo esc_html($kontaktperson); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

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

<?php
/**
 * Template Name: Kalender Template
 * Template Post Type: page
 *
 */

get_header();

// Danish month translations helper
if (!function_exists('get_da_month')) {
    function get_da_month($month_num) {
        $months = array(
            1 => 'JAN', 2 => 'FEB', 3 => 'MAR', 4 => 'APR',
            5 => 'MAJ', 6 => 'JUN', 7 => 'JUL', 8 => 'AUG',
            9 => 'SEP', 10 => 'OKT', 11 => 'NOV', 12 => 'DEC'
        );
        return isset($months[(int)$month_num]) ? $months[(int)$month_num] : '';
    }
}

// Current taxonomy filters from GET request
$selected_afdeling = isset($_GET['afdeling']) ? sanitize_text_field($_GET['afdeling']) : '';
$selected_kategori = isset($_GET['kategori']) ? sanitize_text_field($_GET['kategori']) : '';
$show_past = isset($_GET['vis']) && $_GET['vis'] === 'tidligere';

// Query arguments for begivenheder
$today = date('Y-m-d H:i:s');
$meta_query = array();

if (!$show_past) {
    // Show current and future events
    $meta_query[] = array(
        'relation' => 'OR',
        array(
            'key'     => 'start_dato',
            'value'   => date('Y-m-d 00:00:00'),
            'compare' => '>=',
            'type'    => 'DATETIME'
        ),
        array(
            'key'     => 'start_dato',
            'compare' => 'NOT EXISTS'
        )
    );
}

$tax_query = array('relation' => 'AND');

if (!empty($selected_afdeling)) {
    $tax_query[] = array(
        'taxonomy' => 'afdelinger',
        'field'    => 'slug',
        'terms'    => $selected_afdeling,
    );
}

if (!empty($selected_kategori)) {
    $tax_query[] = array(
        'taxonomy' => 'begivenhed_kategori',
        'field'    => 'slug',
        'terms'    => $selected_kategori,
    );
}

$args = array(
    'post_type'      => 'begivenheder',
    'posts_per_page' => -1,
    'meta_key'       => 'start_dato',
    'orderby'        => 'meta_value',
    'order'          => $show_past ? 'DESC' : 'ASC',
    'meta_query'     => $meta_query,
    'tax_query'      => $tax_query,
);

$events_query = new WP_Query($args);
$afdelinger_terms = get_terms(array('taxonomy' => 'afdelinger', 'hide_empty' => false));
$kategori_terms = get_terms(array('taxonomy' => 'begivenhed_kategori', 'hide_empty' => false));
?>

<div id="kalender-page" class="kalender-container">
    <div class="kalender-header">
        <h1><?php the_title(); ?></h1>
        <?php if (get_the_content()) : ?>
            <div class="kalender-intro">
                <?php the_content(); ?>
            </div>
        <?php else: ?>
            <p class="kalender-subtitle">Se kommende møder, ture, lejres og aktiviteter hos KFUM-Spejderne.</p>
        <?php endif; ?>
    </div>

    <!-- Filter Bar -->
    <div class="kalender-filter-bar">
        <form method="GET" action="" class="kalender-filter-form">
            <div class="filter-group">
                <label for="filter-afdeling">Afdeling:</label>
                <select name="afdeling" id="filter-afdeling" onchange="this.form.submit()">
                    <option value="">Alle afdelinger</option>
                    <?php if (!is_wp_error($afdelinger_terms) && !empty($afdelinger_terms)) : ?>
                        <?php foreach ($afdelinger_terms as $term) : ?>
                            <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($selected_afdeling, $term->slug); ?>>
                                <?php echo esc_html($term->name); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-kategori">Kategori:</label>
                <select name="kategori" id="filter-kategori" onchange="this.form.submit()">
                    <option value="">Alle kategorier</option>
                    <?php if (!is_wp_error($kategori_terms) && !empty($kategori_terms)) : ?>
                        <?php foreach ($kategori_terms as $term) : ?>
                            <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($selected_kategori, $term->slug); ?>>
                                <?php echo esc_html($term->name); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <?php if (!empty($selected_afdeling) || !empty($selected_kategori) || $show_past) : ?>
                <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="btn-reset-filter">Nulstil filter</a>
            <?php endif; ?>

            <div class="filter-toggle-past">
                <?php if ($show_past) : ?>
                    <a href="<?php echo add_query_arg('vis', 'kommende'); ?>" class="toggle-past-link">Vis kommende begivenheder</a>
                <?php else : ?>
                    <a href="<?php echo add_query_arg('vis', 'tidligere'); ?>" class="toggle-past-link">Vis tidligere begivenheder</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Events List -->
    <div class="kalender-events-list">
        <?php if ($events_query->have_posts()) : ?>
            <?php while ($events_query->have_posts()) : $events_query->the_post(); 
                $start_raw = get_field('start_dato');
                $slut_raw = get_field('slut_dato');
                $tidspunkt_tekst = get_field('tidspunkt_tekst');
                $location = get_field('location_sted');
                $pris = get_field('pris');
                $tilmeldings_link = get_field('tilmeldings_link');
                $tilmeldingsfrist = get_field('tilmeldingsfrist');
                
                $day_str = '';
                $month_str = '';
                $year_str = '';
                $time_str = '';

                if ($start_raw) {
                    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $start_raw);
                    if ($dt) {
                        $day_str = $dt->format('j');
                        $month_str = get_da_month($dt->format('n'));
                        $year_str = $dt->format('Y');
                        $time_str = $dt->format('H:i');
                    }
                } else {
                    $day_str = get_the_date('j');
                    $month_str = get_da_month(get_the_date('n'));
                }

                $event_afdelinger = get_the_terms(get_the_ID(), 'afdelinger');
                $event_kategorier = get_the_terms(get_the_ID(), 'begivenhed_kategori');
            ?>
                <div class="kalender-event-card">
                    <!-- Date Badge -->
                    <div class="event-date-badge">
                        <span class="event-date-day"><?php echo esc_html($day_str); ?></span>
                        <span class="event-date-month"><?php echo esc_html($month_str); ?></span>
                    </div>

                    <!-- Main Content -->
                    <div class="event-details">
                        <!-- Tags / Categories -->
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

                        <!-- Title -->
                        <h2 class="event-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <!-- Meta Info Row -->
                        <div class="event-meta-info">
                            <?php if ($tidspunkt_tekst) : ?>
                                <span class="meta-item time">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <?php echo esc_html($tidspunkt_tekst); ?>
                                </span>
                            <?php elseif ($time_str && $time_str !== '00:00') : ?>
                                <span class="meta-item time">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    Kl. <?php echo esc_html($time_str); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($location) : ?>
                                <span class="meta-item location">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <?php echo esc_html($location); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($pris) : ?>
                                <span class="meta-item price">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    <?php echo esc_html($pris); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Teaser / Excerpt -->
                        <?php if (has_excerpt() || get_the_content()) : ?>
                            <div class="event-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt() ? get_the_excerpt() : get_the_content(), 25, '...'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="event-actions">
                        <a href="<?php the_permalink(); ?>" class="btn-event-more">Læs mere</a>

                        <?php if ($tilmeldings_link) : ?>
                            <a href="<?php echo esc_url($tilmeldings_link); ?>" target="_blank" rel="noopener" class="btn-event-signup">
                                Tilmelding
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="kalender-no-events">
                <p>Der er ingen <?php echo $show_past ? 'tidligere' : 'kommende'; ?> begivenheder<?php echo (!empty($selected_afdeling) || !empty($selected_kategori)) ? ' der matcher det valgte filter.' : '.'; ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?>

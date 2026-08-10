<?php
/**
 * Template Name: Kalender Template
 * Template Post Type: page
 */

get_header();

// Danish month name lookups
$da_months_short = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Maj', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dec');
$da_months_full  = array(1 => 'JANUAR', 2 => 'FEBRUAR', 3 => 'MARTS', 4 => 'APRIL', 5 => 'MAJ', 6 => 'JUNI', 7 => 'JULI', 8 => 'AUGUST', 9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DECEMBER');

// GET Filters
$selected_afdeling = isset($_GET['afdeling']) ? sanitize_text_field($_GET['afdeling']) : '';
$selected_kategori = isset($_GET['kategori']) ? sanitize_text_field($_GET['kategori']) : '';
$search_query      = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
$show_past         = isset($_GET['vis']) && $_GET['vis'] === 'tidligere';

// Query arguments for begivenheder
$meta_query = array();
if (!$show_past) {
    $meta_query[] = array(
        'relation' => 'OR',
        array('key' => 'start_dato', 'value' => date('Y-m-d 00:00:00'), 'compare' => '>=', 'type' => 'DATETIME'),
        array('key' => 'start_dato', 'compare' => 'NOT EXISTS')
    );
}

$tax_query = array('relation' => 'AND');
if (!empty($selected_afdeling)) {
    $tax_query[] = array('taxonomy' => 'afdelinger', 'field' => 'slug', 'terms' => $selected_afdeling);
}
if (!empty($selected_kategori)) {
    $tax_query[] = array('taxonomy' => 'begivenhed_kategori', 'field' => 'slug', 'terms' => $selected_kategori);
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
if (!empty($search_query)) {
    $args['s'] = $search_query;
}

$events_query    = new WP_Query($args);
$afdelinger_terms = get_terms(array('taxonomy' => 'afdelinger', 'hide_empty' => false));
$kategori_terms   = get_terms(array('taxonomy' => 'begivenhed_kategori', 'hide_empty' => false));
$current_page_url = strtok($_SERVER["REQUEST_URI"], '?');
?>

<div id="kalender-page" class="kalender-container">
    <h1><?php the_title(); ?></h1>
    <div class="kalender-content">
        <?php  the_content() ?>
    </div>

    <!-- Filter Control Bar -->
    <div class="kalender-filter-wrapper">
        <form method="GET" action="" class="kalender-search-form">
            <?php if (!empty($selected_afdeling)) : ?><input type="hidden" name="afdeling" value="<?php echo esc_attr($selected_afdeling); ?>"><?php endif; ?>
            <?php if ($show_past) : ?><input type="hidden" name="vis" value="tidligere"><?php endif; ?>

            <div class="search-input-group">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="q" value="<?php echo esc_attr($search_query); ?>" placeholder="Søg i arrangementer..." />
                <?php if (!empty($search_query)) : ?>
                    <a href="<?php echo esc_url(remove_query_arg('q')); ?>" class="clear-search" title="Ryd søgning">&times;</a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Afdeling Filter Pills -->
        <div class="kalender-pills-bar">
            <div class="pills-scroll-container">
                <a href="<?php echo esc_url(remove_query_arg('afdeling')); ?>" class="pill-chip <?php echo empty($selected_afdeling) ? 'active' : ''; ?>">
                    Alle afdelinger
                </a>
                <?php if (!is_wp_error($afdelinger_terms) && !empty($afdelinger_terms)) : ?>
                    <?php foreach ($afdelinger_terms as $term) : ?>
                        <a href="<?php echo esc_url(add_query_arg('afdeling', $term->slug)); ?>" class="pill-chip <?php echo ($selected_afdeling === $term->slug) ? 'active' : ''; ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sub Filter (Tabs & Reset) -->
        <!-- <div class="kalender-sub-filter">
            <div class="toggle-past-tabs">
                <a href="<?php echo esc_url(remove_query_arg('vis')); ?>" class="tab-link <?php echo !$show_past ? 'active' : ''; ?>">Kommende arrangementer</a>
                <a href="<?php echo esc_url(add_query_arg('vis', 'tidligere')); ?>" class="tab-link <?php echo $show_past ? 'active' : ''; ?>">Tidligere arrangementer</a>
            </div>

            <?php if (!empty($selected_afdeling) || !empty($selected_kategori) || !empty($search_query)) : ?>
                <a href="<?php echo esc_url($current_page_url); ?>" class="btn-reset-all">Ryd alle filtre</a>
            <?php endif; ?>
        </div> -->
    </div>

    <!-- Events List grouped by Month -->
    <div class="kalender-events-stream">
        <?php if ($events_query->have_posts()) : ?>
            <?php 
                $current_month_year = '';
                while ($events_query->have_posts()) : $events_query->the_post(); 
                    $start_raw        = get_field('start_dato');
                    $slut_raw         = get_field('slut_dato');
                    $tidspunkt_tekst = get_field('tidspunkt_tekst');
                    $location        = get_field('location_sted');
                    $pris            = get_field('pris');
                    $tilmeldings_link = get_field('tilmeldings_link');
                    $tilmeldingsfrist = get_field('tilmeldingsfrist');
                    
                    $start_ts = $start_raw ? strtotime($start_raw) : strtotime(get_the_date('Y-m-d H:i:s'));
                    $slut_ts  = $slut_raw ? strtotime($slut_raw) : null;

                    $month_num = (int) date('n', $start_ts);
                    $day_num   = date('j', $start_ts);
                    $year_num  = date('Y', $start_ts);

                    $day_display = ($slut_ts && date('Y-m-d', $slut_ts) !== date('Y-m-d', $start_ts)) ? ($day_num . '–' . date('j', $slut_ts)) : $day_num;
                    $month_short = $da_months_short[$month_num];
                    $event_month_year = $da_months_full[$month_num] . ' ' . $year_num;
                    $time_str   = date('H:i', $start_ts);

                    $event_afdelinger = get_the_terms(get_the_ID(), 'afdelinger');
                    $event_kategorier = get_the_terms(get_the_ID(), 'begivenhed_kategori');

                    $frist_ts = $tilmeldingsfrist ? strtotime($tilmeldingsfrist) : null;
                    $frist_display = $frist_ts ? (date('j. ', $frist_ts) . strtolower($da_months_short[(int)date('n', $frist_ts)])) : '';
            ?>
                <!-- Month Section Header -->
                <?php if ($event_month_year !== $current_month_year) : 
                    $current_month_year = $event_month_year;
                ?>
                    <div class="month-divider">
                        <h2><?php echo esc_html($current_month_year); ?></h2>
                        <span class="divider-line"></span>
                    </div>
                <?php endif; ?>

                <!-- Event Card -->
                <a href="<?php the_permalink(); ?>" class="kalender-card">
                    <div class="post-thumbnail">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <div class="fallback-date-tile">
                                <span class="date-day"><?php echo esc_html($day_display); ?></span>
                                <span class="date-month"><?php echo esc_html($month_short); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="post-content">
                        <div class="event-tags">
                            <?php if (!empty($event_afdelinger) && !is_wp_error($event_afdelinger)) : ?>
                                <?php foreach ($event_afdelinger as $afdel) : ?>
                                    <span class="tag tag-afdeling"><?php echo esc_html($afdel->name); ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <h2><?php the_title(); ?></h2>
                        <p class="post-meta-data">
                            <?php if ($tidspunkt_tekst) : ?>
                                <?php echo esc_html($tidspunkt_tekst); ?> 
                            <?php else : ?>
                                <?php echo esc_html($day_display); ?>. <?php echo esc_html(strtolower($month_short)); ?> <?php echo esc_html($year_num); ?>
                                <?php if ($time_str && $time_str !== '00:00') echo ' - Kl. ' . esc_html($time_str); ?>
                            <?php endif; ?>
                            <?php if ($location) : ?>
                                | <?php echo esc_html($location); ?>
                            <?php endif; ?>
                        </p>
                        <div class="post-teaser">
                            <?php echo wp_trim_words(get_the_excerpt() ? get_the_excerpt() : get_the_content(), 28, '...'); ?>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="kalender-empty-state">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <h3>Ingen begivenheder fundet</h3>
                <p>Der er ingen <?php echo $show_past ? 'tidligere' : 'kommende'; ?> arrangementer, der matcher din søgning eller dine filtre.</p>
                <a href="<?php echo esc_url($current_page_url); ?>" class="btn-reset-empty">Nulstil filtre</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?>

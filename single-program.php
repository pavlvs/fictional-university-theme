<?php
get_header();
while (have_posts()) {
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs </a> <span class="metabox__main"><?php the_title(); ?></span></p>
            </div>
            <?php the_content(); ?>
        </div>
        <?php
        $relatedProfessors = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',
                ]
            ]
        ]);
        ?>
        <?php if ($relatedProfessors->have_posts()) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium"><?= get_the_title(); ?> Professors</h2>
            <ul class="professor-cards">
                <?php while ($relatedProfessors->have_posts()) :
                    $relatedProfessors->the_post();
                ?>
                    <li class="professor-card__list-item">
                        <a class="professor-card" href="<?php the_permalink(); ?>">
                            <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="">
                            <span class="professor-card__name"><?php the_title(); ?></span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

        <?php
        wp_reset_postdata();

        $today = date('Ymd');
        $homepageEvents = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                ],
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',
                ]
            ]
        ]);
        ?>
        <?php if ($homepageEvents->have_posts()) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Upcoming <?= get_the_title(); ?> Events</h2>
            <?php while ($homepageEvents->have_posts()) :
                $homepageEvents->the_post();
                get_template_part('template-parts/content', 'event');
            ?>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php
        wp_reset_postdata();
        $relatedCampuses = get_field('related_campus');
        if ($relatedCampuses) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium"><?php the_title(); ?> is available at these campuses:</h2>
            <ul class="min-list link-list">
                <?php foreach ($relatedCampuses as $campus) : ?>
                    <li><a href="<?= get_the_permalink($campus) ?>"><?= get_the_title($campus); ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php }
get_footer();
?>
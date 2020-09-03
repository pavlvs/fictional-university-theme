<?php
get_header();
while (have_posts()) {
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('event') ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home </a> <span class="metabox__main"><?php the_title(); ?></span></p>
            </div>
            <?php the_content(); ?>
        </div>
        <?php
        $relatedPrograms = get_field('related_programs');
        if ($relatedPrograms) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Related Program(s)</h2>
            <ul class="link-list min-list">
                <?php foreach ($relatedPrograms as $program) : ?>
                    <li><a href="<?= get_the_permalink($program); ?>"><?= get_the_title($program); ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php }
get_footer();
?>
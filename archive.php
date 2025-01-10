<?php get_header(); ?>
<div class="px-4 lg:px-20 w-full pt-20 lg:pt-0">
    <div class="w-full py-12 flex flex-col gap-2.5">
        <h1 class="w-full font-semibold text-2xl lg:text-4xl">
            Today's Headlines: Stay Informed
        </h1>
        <div class="w-full font-medium text-sm lg:text-base text-[#999999]">
            Explore the latest news from around the world. We bring you up-to-the-minute updates on the most significant events, trends, and stories. Discover the world through our news coverage.
        </div>
    </div>

    <?php
    // Fetch all posts
    $query = new WP_Query(array(
        'posts_per_page' => -1, // Retrieve all posts
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    if ($query->have_posts()) :
        $post_count = 0;

        while ($query->have_posts()) : $query->the_post();
            $post_count++;

            // First post
            if ($post_count !== 1) :
                break;
            endif;
                ?>
                <div class="w-full pt-0 lg:pt-14 lg:py-14 flex gap-10 flex-col lg:flex-row">
                    <div class="w-full h-52 lg:w-[532px] lg:h-[336px] rounded-lg">
                        <img class="w-full h-full object-cover" alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('large'); ?>" />
                    </div>
                    <div class="grow w-full flex flex-col gap-3.5 justify-center">
                        <h2 class="w-full font-semibold text-lg lg:text-2xl">
                            <a href="<?php the_permalink(); ?>" class="hover:underline">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <div class="font-medium text-base lg:text-lg text-[#999999]">
                            <?php echo wp_trim_words(get_the_content(), 50); ?>
                        </div>
                    </div>
                </div>
            <?php
        endwhile;
        ?>
        <?php get_template_part('template-parts/commons/post-card', null, ['cean_wp_exclude_posts_id' => [], 'cean_wp_exclude_container_class' => 'gap-y-28 py-14']); ?>

        <?php
        wp_reset_postdata();
    else :
        ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>

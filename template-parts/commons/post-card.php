<div class="w-full flex flex-wrap gap-y-10 gap-x-7 <?php echo $args['cean_wp_exclude_container_class'] ?? ''; ?>">
    <?php
    $query = new WP_Query(array(
        'posts_per_page' => -1, // Retrieve all posts
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));
    ?>
    <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php if(in_array(get_the_ID(), [...($args['cean_wp_exclude_posts_id'] ?? [])])): ?>
                <?php continue; ?>
            <?php endif; ?>
            <div class="w-[calc((100% - 84px) / 3)] min-w-[350px] h-[291px] flex flex-col gap-2.5">
                <div class="w-full h-3/5 bg-green-500">
                    <img class="w-full h-full object-cover" alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('medium'); ?>" />
                </div>
                <div class="w-full h-2/5 flex flex-col gap-4">
                    <h2 class="w-full font-semibold text-base">
                        <a href="<?php the_permalink(); ?>" class="hover:underline">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="w-full"></div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
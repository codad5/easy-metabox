<div class="w-full px-20">
    <div class="w-full flex flex-col gap-7">
        <div class="w-full flex">
            <div class="w-full flex flex-col basis-5/6 gap-2.5">
                <h3 class="text-4xl font-semibold">News & Resources</h3>
                <div class="font-medium text-base text-[#999999]">
                    Delivering unparalleled movie-going experiences
                </div>
            </div>
            <div class="grid place-items-center h-full basis-1/6">
                <div class="">
                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="hover:underline">
                        View All
                    </a>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-wrap justify-between">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="w-[47%] grow-0 py-7 flex flex-col gap-5">
                        <div class="w-full bg-green-500 h-[471px]">
                            <!-- Thumbnail or placeholder -->
                            <a href="<?php the_permalink(); ?>">
                                <img class="w-full h-full object-cover" alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url(null, 'large'); ?>" />
                            </a>
                        </div>
                        <div class="w-full h-16">
                            <div class="w-full font-semibold text-xl">
                                <a href="<?php the_permalink(); ?>" class="hover:underline">
                                    <?php the_title(); ?>
                                </a>
                            </div>
                            <div class="w-full text-[#999999] text-base font-medium">
                                Post in <?php the_category(', '); ?> <?php echo get_the_date(); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No posts available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

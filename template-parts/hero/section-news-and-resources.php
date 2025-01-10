<div class="w-full px-4 lg:px-20">
    <div class="w-full flex flex-col  gap-5 lg:gap-7">
        <div class="w-full flex flex-col lg:flex-row gap-5 lg:gap-0">
            <div class="w-full flex flex-col basis-5/6 gap-2.5">
                <h3 class="text-2xl lg:text-4xl font-semibold">News & Resources</h3>
                <div class="font-medium text-sm lg:text-base text-[#999999]">
                    Delivering unparalleled movie-going experiences
                </div>
            </div>
            <div class="grid lg:place-items-center h-full lg:basis-1/6">
                <div class="px-5 py-3.5 lg:px-0 lg:py-0">
                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="hover:underline">
                        View All
                    </a>
                </div>
            </div>
        </div>
        <div class="w-full flex lg:flex-wrap flex-col lg:flex-row gap-16 lg:gap-0 lg:justify-between">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="w-full lg:w-[47%] grow-0 lg:py-7 flex flex-col gap-5">
                        <div class="w-full bg-green-500 h-52 lg:h-[471px]">
                            <!-- Thumbnail or placeholder -->
                            <a href="<?php the_permalink(); ?>">
                                <img class="w-full h-full object-cover" alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url(null, 'large'); ?>" />
                            </a>
                        </div>
                        <div class="w-full h-16">
                            <div class="w-full font-semibold text-lg lg:text-xl">
                                <a href="<?php the_permalink(); ?>" class="hover:underline">
                                    <?php the_title(); ?>
                                </a>
                            </div>
                            <div class="w-full text-[#999999] text-sm lg:text-base font-medium">
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

<div class=" w-full px-4 lg:px-20 py-6">
    <div class=" w-full flex lg:h-24 flex-col lg:flex-row gap-4 lg:gap-0 py-6 lg:py-0">
        <div class="w-full lg:w-3/5 lg:h-full flex flex-col lg:inline-block gap-2.5 lg:gap-0">
            <div class="w-full font-medium text-sm lg:text-base">
                Dive into the Details
            </div>
            <h3 class="w-full font-semibold text-3xl lg:text-4xl">
                Top 10 Movies This Week
            </h3>
        </div>
        <div class="w-full lg:w-2/5 h-full grid place-items-center">
            <div class="w-full h-full flex lg:p-2.5 gap-2.5 lg:gap-0 justify-between lg:justify-start">
                <?php foreach(['week', 'month', 'year'] as $timeframe): ?>
                    <button class="h-full w-1/3 font-medium text-sm py-3 lg:py-0 px-5 lg:px-0">
                       This <?php echo ucfirst($timeframe); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class=" w-full h-12 flex lg:justify-end">
        <a href="/movies" class="inline-block font-medium text-sm px-5 py-3.5">
            View All
        </a>
    </div>
    <div class="swiper cean-content-hero-top-movies-swiper py-10 gap-5 overflow-x-hidden">
        <?php $top_movies = CeanWP_Functions::get_all_time_top_grossing_movies(); ?>
        <div class="swiper-wrapper w-full flex gap-4 pb-14 scrollbar scrollbar-h-2 scrollbar-thumb-[#E4E4E7] scrollbar-track-transparent">
            <?php foreach ($top_movies as $i => $movie_d): ?>
                <div class="swiper-slide w-60 inline-block relative shrink-0 rounded-t-lg">
                    <div class="w-full h-[308px] relative rounded-t-lg">
                        <img src="<?php echo !empty($movie_d['movie_poster']) ? wp_get_attachment_image_url($movie_d['movie_poster'], 'large') : get_theme_file_uri("assets/images/gang-of-lagos.jpg");?>" alt="movie image" class="w-full h-full object-cover" />
                        <div class="w-full h-full absolute inset-0 bg-gradient-to-b from-black/0 to-black/90"></div>
                    </div>
                    <div class="w-full  h-11">
                        <h4 class="font-semibold text-sm"><a href="<?php echo $movie_d['permalink']; ?>" class="text-white"><?php echo $movie_d['title']; ?></a></h4>
                        <div class="font-normal text-xs text-[#78828A]"><?php echo $movie_d['distributor']  ?? ''; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="w-full flex items-center lg:pt-8 justify-between text-right">
            <div class="cean-content-hero-top-movies-swiper-scrollbar w-4/5">
                <div class="cean-hero-top-movies-slider-scrollbar-drag bg-white min-w-1 rounded-full" >

                </div>
            </div>
            <div class="flex gap-2.5">
                <button class="p-2 cean-content-hero-top-movies-swiper-prev">
                    <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-left-arrow'); ?>"  class="w-6 aspect-square" alt="Prev">
                </button>
                <button class="p-2 cean-content-hero-top-movies-swiper-next">
                    <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-right-arrow'); ?>"  class="w-6 aspect-square" alt="Next">
                </button>
            </div>
        </div>
    </div>
</div>
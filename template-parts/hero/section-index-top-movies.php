<div class=" w-full px-20 py-6">
    <div class=" w-full flex h-24">
        <div class="w-3/5 h-full">
            <div class="w-full font-medium text-base">
                Dive into the Details
            </div>
            <h3 class="w-full font-semibold text-4xl">
                Top 10 Movies This Week
            </h3>
        </div>
        <div class="w-2/5 h-full grid place-items-center">
            <div class="w-full h-full flex p-2.5">
                <?php foreach(['week', 'month', 'year'] as $timeframe): ?>
                    <button class="h-full w-1/3 font-medium text-sm">
                       This <?php echo ucfirst($timeframe); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class=" w-full h-12 flex justify-end">
        <a href="/movies" class="inline-block font-medium text-sm px-5 py-3.5">
            View All
        </a>
    </div>
    <div class=" py-10">
        <?php $top_movies = CeanWP_Functions::get_all_time_top_grossing_movies(); ?>
        <div class=" w-full overflow-x-scroll flex gap-4 pb-14 scrollbar scrollbar-h-2 scrollbar-thumb-[#E4E4E7] scrollbar-track-transparent">
            <?php foreach ($top_movies as $i => $movie_d): ?>
                <div class="w-60 inline-block relative shrink-0 rounded-t-lg">
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
    </div>
</div>

<?php
/** @var array $args */
    [
        'title' => $title,
        'swiper_class_name_suffix' => $swiper_class_name_suffix,
        'movies' => $movies
    ] = $args;
?>

<div class="swiper cean-content-swiper-<?php echo esc_attr($swiper_class_name_suffix); ?> w-full flex flex-col gap-5 lg:gap-10 overflow-hidden">
    <div class="w-full flex justify-between items-center">
        <h5 class="h-full font-semibold text-xl lg:text-3xl "><?php echo $title; ?></h5>
        <div class="h-full p-3 hidden lg:flex gap-3 justify-center items-center bg-[#0F0F0F]">
            <div class="cean-content-swiper-<?php echo esc_attr($swiper_class_name_suffix); ?>-prev p-2.5 aspect-square rounded-full border border-[#262626] grid place-items-center">
                <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-left-arrow'); ?>"  class="w-6 aspect-square" alt="Prev">
            </div>
            <div class="cean-content-swiper-<?php echo esc_attr($swiper_class_name_suffix); ?>-pagination h-11 grow w-16">
            </div>
            <div class="cean-content-swiper-<?php echo esc_attr($swiper_class_name_suffix); ?>-next p-2.5 aspect-square rounded-full border border-[#262626] grid place-items-center">
                <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-right-arrow'); ?>"  class="w-6 aspect-square" alt="Next">
            </div>
        </div>
    </div>
    <div class="swiper-wrapper w-full h-64 lg:h-[308px] flex">
        <?php foreach ($movies as $movie): ?>
            <div class="swiper-slide h-full w-[181px] lg:w-56 p-3 lg:p-4 inline-flex shrink-0 flex-col gap-4">
                <a href="<?php echo $movie['permalink']; ?>" class="w-full h-full inline-block">
                    <div class="w-full h-4/5 basis-4/5 rounded-xl bg-amber-500">
                        <img src="<?php echo $movie['poster']; ?>" class="w-full h-full object-cover rounded-xl" alt="<?php echo $movie['title']; ?>">
                    </div>
                    <div class="w-full flex justify-between items-center text-[#999999]">
                        <div class="p-1 text-xs bg-[#141414] grow-0 rounded-full">
                            <?php echo date('H\h i\m', strtotime($movie['duration'])); ?>
                        </div>
                        <div class="py-2.5 px-3.5 text-xs bg-[#141414] grow-0 rounded-full">
                            <?php echo $movie['rating']; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
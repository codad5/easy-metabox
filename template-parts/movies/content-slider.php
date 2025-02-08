
<?php
/** @var array $args */
    [
        'title' => $title,
        'swiper_class_name_suffix' => $swiper_class_name_suffix,
        'movies' => $movies,
    ] = $args;
?>

<?php if(!empty($movies)): ?>
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
    <div class="swiper-wrapper w-full h-72 lg:h-[308px] flex">
        <?php foreach ($movies as $movie): ?>
            <div class="swiper-slide w-60 inline-block relative shrink-0 rounded-t-lg">
                <div class="w-full h-4/5 lg:h-[308px] relative rounded-t-lg">
                    <img class="h-full w-full object-cover rounded-t-lg" src="<?php echo !empty($movie['poster']) ? $movie['poster'] : get_theme_file_uri("assets/images/gang-of-lagos.jpg"); ?>" alt="<?php echo $movie['title']; ?>">
                    <div class="w-full h-full absolute inset-0 bg-gradient-to-b from-black/0 to-black/90"></div>
                </div>
                <div class="w-full  h-11">
                    <h4 class="font-semibold text-sm"><a <?php if(!empty($movie['permalink'])) : ?>  href="<?php echo $movie['permalink']; ?>" <?php endif; ?> ><?php echo $movie['title']; ?></a></h4>
                    <div class="font-normal text-xs text-[#78828A]"><?php echo isset($args['sub']) && is_callable($args['sub']) ? $args['sub']($movie) :  ($movie['distributor'] ?? ''); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?php
    $slideshow = CeanWP_Functions::get_best_slide_show_content();
?>
<div class="w-full px-4 lg:px-20 py-20 lg:py-14">
    <div class="w-full relative">
        <?php foreach ($slideshow as $i => $slide) : ?>
        <div class="cean-slideshow-item w-full relative h-[709px] rounded-xl overflow-hidden">
            <img class="w-full h-full object-cover lg:object-center lg:object-contain" src="<?php echo $slide['movie_poster']; ?>" alt="<?php echo $slide['title']; ?>">
            <div class="w-full h-full flex items-end py-24 absolute inset-0 bg-gradient-to-b from-black/0 to-black/90">
                <div class="w-full flex flex-col justify-center items-center gap-0.5">
                    <h3 class="w-full text-center font-bold text-2xl lg:text-4xl">
                       <a href="<?php echo $slide['permalink']; ?>" class="text-white hover:text-[#FFD700]"><?php echo $slide['title']; ?></a>
                    </h3>
                    <div class="w-4/5 text-center font-semibold text-sm lg:text-base text-[#999999]">
                        <?php echo $slide['content'] ?? ''; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="absolute w-full h-full inset-0 py-4 px-6 lg:px-10 flex justify-center items-end">
            <div class="w-full flex justify-between items-center">
                <button class="cean-slideshow-left-btn p-2.5 aspect-square">
                    <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-left-arrow'); ?>"  class="w-6 aspect-square" alt="Next">
                </button>
                <button class="cean-slideshow-right-btn p-2.5 aspect-square">
                    <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-right-arrow'); ?>"  class="w-6 aspect-square" alt="Next">
                </button>
            </div>
        </div>
    </div>

</div>
<div class="w-full px-20 py-14">
    <div class="w-full relative">
        <?php for($i = 0; $i < 3; $i++): ?>
        <div class="cean-slideshow-item w-full relative h-[709px] rounded-xl overflow-hidden">
            <img class="w-full h-full object-center" src="<?php echo get_theme_file_uri("assets/images/spiderman-no-way-home.jpg") ?>" alt="Spider man no way home" />
            <div class="w-full h-full flex items-end py-24 absolute inset-0 bg-gradient-to-b from-black/0 to-black/90">
                <div class="w-full flex flex-col justify-center items-center gap-0.5">
                    <h3 class="w-full text-center font-bold text-4xl">
                        Spider-man: No Way Home <?php echo $i + 1?>
                    </h3>
                    <div class="w-4/5 text-center font-semibold text-base text-[#999999]">
                        Peter Parker is unmasked and no longer able to separate his normal life from the high-stakes of being a super-hero. When he asks for help from Doctor Strange the stakes become even more dangerous, forcing him to discover what it truly means to be Spider-Man.
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
        <div class="absolute w-full h-full inset-0 py-4 px-10 flex justify-center items-end">
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
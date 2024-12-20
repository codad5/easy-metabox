<div class=" w-full px-20">
    <h3 class="font-semibold text-4xl">New Releases</h3>
    <div class=" font-medium text-base text-[#999999]">Discover the Latest Blockbusters and Hidden Gems on the Big Screen.</div>
    <div class=" py-10">
        <div class=" w-full overflow-x-scroll flex gap-4 pb-14 scrollbar scrollbar-h-2 scrollbar-thumb-[#E4E4E7] scrollbar-track-transparent">
            <?php for($i = 0; $i < 9; $i++): ?>
            <div class="w-60 inline-block relative shrink-0 rounded-t-lg">
                <div class="w-full h-[308px] relative rounded-t-lg">
                    <img src="<?php echo get_theme_file_uri("assets/images/gang-of-lagos.jpg") ?>" class="h-full w-full object-cover rounded-t-lg" />
                    <div class="w-full h-full absolute inset-0 bg-gradient-to-b from-black/0 to-black/90"></div>
                </div>
                <div class="w-full  h-11">
                    <h4 class="font-semibold text-sm">Gangs of Lagos</h4>
                    <div class="font-normal text-xs text-[#78828A]">Film One</div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
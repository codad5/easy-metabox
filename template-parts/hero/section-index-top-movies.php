<div class="container w-full px-20 py-6">
    <div class="container w-full flex h-24">
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
    <div class="container w-full h-12 flex justify-end">
        <a href="#" class="inline-block font-medium text-sm px-5 py-3.5">
            View All
        </a>
    </div>
    <div class="container py-10">
        <div class="container w-full overflow-x-scroll flex gap-4 pb-14 scrollbar scrollbar-h-2 scrollbar-thumb-[#E4E4E7] scrollbar-track-transparent">
            <?php for($i = 0; $i < 9; $i++): ?>
                <div class="w-60 inline-block relative shrink-0 rounded-t-lg">
                    <div class="w-full h-[308px] relative rounded-t-lg">
                        <img src="<?php echo get_theme_file_uri("assets/images/gang-of-lagos.jpg") ?>" class="h-full w-full object-cover rounded-t-lg" />
                        <div class="w-full h-full absolute inset-0 bg-gradient-to-b from-black/0 to-black/90"></div>
                    </div>
                    <div class="w-full container h-11">
                        <h4 class="font-semibold text-sm">Gangs of Lagos</h4>
                        <div class="font-normal text-xs text-[#78828A]">Film One</div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
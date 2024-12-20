<?php get_header(); ?>
<div class="px-20 w-full">
    <div class="w-full py-12 flex flex-col gap-2.5">
        <h1 class="w-full font-semibold text-4xl">
            Today's Headlines: Stay Informed
        </h1>
        <div class="w-full font-medium text-base text-[#999999]">
            Explore the latest news from around the world. We bring you up-to-the-minute updates on the most significant events, trends, and stories. Discover the world through our news coverage.
        </div>
    </div>
    <div class="w-full py-14 flex gap-10">
        <div class="w-[532px] h-[336px] rounded-lg">
            <img class="w-full h-full object-cover" alt="" src=""/>
        </div>
        <div class="grow w-full flex flex-col gap-3.5 justify-center">
            <h2 class="w-full font-semibold text-2xl">A Decisive Victory for Progressive Policies</h2>
            <div class="font-medium text-lg text-[#999999]">
                Nigeria’s cinema sector is perhaps, the most evolving in the nation’s creative industry, as movie-going has become a norm amongst many working-class youths and millennials in the recent past. In metropolitan cities such as Lagos, Abuja and Port Harcourt, the usual #TGIF aura on Fridays is commonly dominated by scenarios of young corporate workers, couples and students, storming cinemas as soon as the clock ticks to call it a day.

                Unfortunately, like several other happy moments, the global pandemic has attempted to push all that into an archive, forcing the shutdown of cinemas across the country...
            </div>
        </div>
    </div>
    <div class="py-14 w-full flex flex-wrap gap-x-7 gap-y-28">
        <?php for($i = 0; $i < 5; $i++): ?>
            <div class="w-[350px] h-[291px] flex flex-col gap-2.5">
                <div class="w-full h-3/5 bg-green-500">

                </div>
                <div class="w-full h-2/5 flex flex-col gap-4">
                    <h2 class="w-full font-semibold text-base">Nigerian Cinemas Prepare for POST-COVID –19</h2>
                    <div class="w-full">

                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>
<?php get_footer(); ?>
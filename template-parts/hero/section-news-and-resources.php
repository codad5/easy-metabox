<div class="w-full px-20">
    <div class="w-full flex flex-col gap-7">
        <div class="w-full flex">
            <div class="w-full flex flex-col basis-5/6 gap-2.5">
                <h3 class="text-4xl font-semibold">News & Resources</h3>
                <div class="font-medium text-base text-[#999999]">
                    Delivering unparalleled movie-going experiences
                </div>
            </div>
            <div class="grid place-items-center h-full basis-1/6">
                <div class="">
                    <A>View All</A>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-wrap justify-between">
            <?php if(have_posts()): ?>
                <?php while(have_posts()): the_post(); ?>
                    <div class="w-[47%] grow-0 py-7 flex flex-col gap-5">
                        <div class="w-full bg-green-500 h-[471px]">
                            h
                        </div>
                        <div class="w-full h-16">
                            <div class="w-full font-semibold text-xl">
                                <?php the_title(); ?>
                            </div>
                            <div class="w-full text-[#999999] text-base font-medium">
                                Post in <?php the_category(','); ?> <?php the_date(); ?>
                            </div>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php for($i =0; $i < 4;$i++): ?>
                <div class="w-[47%] grow-0 py-7 flex flex-col gap-5">
                    <div class="w-full bg-green-500 h-[471px]">
                        h
                    </div>
                    <div class="w-full h-16">
                        <div class="w-full font-semibold text-xl">
                            Nigerian Cinemas Prepare for POST-COVID –19
                        </div>
                        <div class="w-full text-[#999999] text-base font-medium">
                            Post in News 09.12.2018
                        </div>

                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
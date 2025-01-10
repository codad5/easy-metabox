<div class="w-full px-4 lg:px-20 flex flex-col gap-2.5 space-y-2.5">
    <div class="w-full flex flex-col gap-2.5">
        <h3 class="w-full font-semibold text-3xl lg:text-4xl">Top Gross Box Office (Nigeria)</h3>
        <div class="font-medium text-sm lg:text-base text-[#999999]">The best selling films shaping Nigeria’s cinema scene.</div>
    </div>
    <div class="w-full lg:inline-block flex flex-col gap-5">
        <div class="w-full font-semibold text-base lg:text-xl pb-5">
            January 22
        </div>
        <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-2.5">
            <?php $top_grossing = CeanWP_Functions::get_all_time_top_grossing_movies(); ?>
            <?php foreach($top_grossing as $i => $movie_d): ?>
                <div class="w-full lg:w-2/3 h-24 p-5 border-l-4 border-l-[#262626]">
                    <div class="w-full h-full flex">
                        <div class="grid h-full aspect-square place-items-center text-[#018B8D] text-base font-semibold">
                            <?php echo $i+1; ?>
                        </div>
                        <div class="h-full w-full grow flex flex-col gap-1">
                            <div class="w-full h-1/2 font-semibold text-xl">
                                <?php echo $movie_d['title']; ?>
                            </div>
                            <div class="font-medium text-base text-[#999999]">
                                ₦ <?php echo number_format($movie_d['box_office']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
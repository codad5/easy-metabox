<div class="w-full px-20 flex flex-col gap-2.5 space-y-2.5">
    <div class="w-full flex flex-col gap-2.5">
        <h3 class="w-full font-semibold text-4xl">Top Gross Box Office (Nigeria)</h3>
        <div class="font-medium text-base text-[#999999]">The best selling films shaping Nigeria’s cinema scene.</div>
    </div>
    <div class="w-full">
        <div class="w-full font-semibold text-xl pb-5">
            January 22
        </div>
        <div class="w-full grid grid-cols-2 grid-rows-5 grid-flow-col gap-x-10 gap-y-2.5">
            <?php for($i = 0;$i<10;$i++) : ?>
            <div class="w-1/2 h-24 p-5 border-l-4 border-l-[#262626]">
                <div class="w-full h-full flex">
                    <div class="grid h-full aspect-square place-items-center text-[#018B8D] text-base font-semibold">
                        <?php echo $i+1; ?>
                    </div>
                    <div class="h-full grow flex flex-col gap-1">
                        <div class="w-full h-1/2 font-semibold text-xl">
                            Citation
                        </div>
                        <div class="font-medium text-base text-[#999999]">
                            N 360
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>

    </div>
</div>
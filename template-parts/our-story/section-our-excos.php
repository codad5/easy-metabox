<div class="px-20 w-full flex flex-col gap-10">
    <div class="w-full">
        <div class="w-full text-center"> <h2 class="font-semibold text-4xl">Our Excos</h2> </div>
        <div class="w-full pt-3.5 font-medium text-base text-[#999999] text-center">
            Get to know our team of exceptional individuals steering the Cinema Exhibitors Association of Nigeria (CEAN). These leaders are dedicated to shaping the future of the cinema industry in Nigeria and beyond.
        </div>
    </div>
    <div class="w-full flex gap-5">
        <?php for($i = 0; $i < 4; $i++): ?>
            <div class="h-96 w-1/4">
                <div class="w-full h-2/3 flex justify-center items-center">
                    <div class="h-full flex flex-col gap-4 items-center justify-center">
                        <div class="w-28 rounded-full aspect-square">
                            <img class="w-full h-full object-cover rounded-full" src="<?php echo get_theme_file_uri("assets/images/patrick-lee.png"); ?>" alt="" />
                        </div>
                        <div class="text-center font-semibold text-lg">
                            Patrick Lee
                        </div>
                        <div class="text-center font-medium text-base">
                            Chairman
                        </div>
                    </div>
                </div>
                <div class="w-full h-1/3 flex gap-2.5 justify-center items-center">
                    <?php for($j = 0; $j < 3; $j++): ?>
                        <div class="w-12 grid place-items-center aspect-square bg-green-500">h</div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endfor; ?>
    </div>


</div>
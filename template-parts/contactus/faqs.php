<div class="w-full px-36 py-10">
    <div class="w-full flex flex-col gap-10">
        <div class="w-full flex flex-col gap-2.5 ">
            <h2 class="font-semibold text-4xl">
                Asked question
            </h2>
            <div class="w-full font-normal text-base text-[#999999]">
                If the question is not available on our FAQ section, Feel free to contact us personally, we will resolve your respective doubts.
            </div>
        </div>
        <pre>
            <?php
                $faqs = CeanWP_Functions::get_faqs(8);
            ?>
        </pre>
        <div class="w-full flex justify-between flex-wrap">
            <?php foreach ($faqs as $i => $faq) : ?>
                <div class="w-1/2 p-6">
                    <details class="w-full group">
                        <summary class="flex justify-between items-center cursor-pointer">
                            <div class="flex items-center gap-4">
                                <span class="text-base font-semibold"><?php echo $i + 1; ?></span>
                                <span class="text-white font-medium text-lg"><?php echo esc_html($faq['title']); ?></span>
                            </div>
                            <div class="relative">
                                <svg class="w-5 h-5 text-white transition-opacity group-open:opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                                </svg>
                                <svg class="w-5 h-5 text-white absolute top-0 left-0 opacity-0 group-open:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                                </svg>
                            </div>
                        </summary>
                        <div class="px-6 pb-4 text-[#999999] font-normal text-base py-3">
                            <?php echo $faq['content']; ?>
                        </div>
                    </details>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
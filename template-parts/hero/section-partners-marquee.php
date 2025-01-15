<div class="w-full text-white px-4 lg:px-20">
    <div class="w-full text-center text-lg font-bold mb-4">
        Our Partners
    </div>
    <div class="relative overflow-hidden h-24">
        <div class="flex w-full h-full animate-marquee whitespace-nowrap">
            <?php
            $partners = CeanWP_Functions::get_partners_list(); // Fetch the partners list
            ?>
            <?php foreach ($partners as ['title' => $title, 'description' => $description, 'logo' => $logo]) : ?>
                <div class="h-full py-5 px-7 grid place-items-center shrink-0">
                    <img src="<?php echo esc_url(CeanWP_Functions::get_common_icon_url($logo)); ?>" class="w-28 h-10 object-contain" alt="<?php echo $title; ?>" />
                </div>
            <?php endforeach; ?>
            <!-- Duplicate the partners list for smooth looping -->
            <?php foreach ($partners as ['title' => $title, 'description' => $description, 'logo' => $logo]) : ?>
                <div class="h-full py-5 px-7 grid place-items-center shrink-0">
                    <img src="<?php echo esc_url(CeanWP_Functions::get_common_icon_url($logo)); ?>" class="w-28 h-10 object-contain" alt="<?php echo $title; ?>" />
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

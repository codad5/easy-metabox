<div class="w-full text-white px-4 lg:px-20">
    <div class="w-full text-center text-sm lg:text-lg">
        Trusted By Top Distributors
    </div>
    <div class="w-full h-24 overflow-x-hidden">
        <div class="w-full h-full flex justify-center items-center">
            <?php $distribution_partners = CeanWP_Functions::get_distributors_list(); ?>
            <?php foreach ($distribution_partners as ['title' => $title, 'description' => $description, 'logo' => $logo]) : ?>
                <div class="h-full py-5 px-7 grid place-items-center shrink-0 lg:shrink">
                    <img src="<?php echo esc_url(CeanWP_Functions::get_common_icon_url($logo)); ?>" class="w-12 lg:w-28 h-6 lg:h-10 object-cover" alt="<?php echo $title; ?>" />
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

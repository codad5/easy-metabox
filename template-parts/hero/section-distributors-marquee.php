<div class="w-full text-white px-20">
    <div class="w-full text-center">
        Trusted By Top Distributors
    </div>
    <div class="container h-24">
        <div class="w-full h-full flex justify-center items-center">
            <?php $distribution_partners = CeanWP_Functions::get_distributors_list(); ?>
            <?php foreach ($distribution_partners as ['title' => $title, 'description' => $description, 'logo' => $logo]) : ?>
                <div class="h-full py-5 px-7 grid place-items-center">
                    <img src="<?php echo esc_url(CeanWP_Functions::get_common_icon_url($logo)); ?>" class="w-28 h-10 object-cover" alt="<?php echo $title; ?>" />
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="w-full text-white px-20">
    <div class="w-full text-center">
        Our Partners
    </div>
    <div class="container h-24">
        <div class="w-full h-full flex justify-center items-center">
            <?php
            $partners = CeanWP_Functions::get_partners_list(); // Fetch the partners list
            ?>
            <?php foreach ($partners as ['title' => $title, 'description' => $description, 'logo' => $logo]) : ?>
                <div class="h-full py-5 px-7 grid place-items-center">
                    <img src="<?php echo get_theme_file_uri("assets/images/partners/{$logo}"); ?>" class="w-28 h-10 object-cover" alt="<?php echo $title; ?>" />
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="w-full px-4 lg:px-20 flex flex-col flex-wrap items-center">
    <!-- Left Section: Title and Description -->
    <div class="w-full  lg:basis-2/5 h-full grid  py-7 lg:py-0">
        <div class="w-full flex flex-col gap-5 lg:gap-7">
            <!-- Icon Placeholder -->
            <div class="w-full h-20">
                <div class="h-full aspect-square  grid place-items-center">
                    <img src="<?php echo esc_url($args['section_icon'] ?? ''); ?>" alt="icon" class="h-14 aspect-square">
                </div>
            </div>
            <!-- Section Title -->
            <div class="w-full">
                <h3 class="font-semibold text-2xl lg:text-3xl">
                    <?php echo esc_html($args['section_title'] ?? 'Default Title'); ?>
                </h3>
            </div>
            <!-- Section Description -->
            <div class="w-full font-normal text-sm lg:text-base text-[#999999]">
                <?php echo esc_html($args['section_description'] ?? 'Default Description'); ?>
            </div>
        </div>
    </div>
    <!-- Right Section: Dynamic Grid -->
    <div class="w-full lg:basis-3/5 py-7 lg:py-14">
        <div class="w-full gap-x-3.5 gap-y-5 grid grid-cols-3 lg:grid-cols-6 grid-flow-row">
            <?php
            $items = $args['section_items'] ?? [];
            foreach ($items as $item) : ?>
                <div class="w-full p-7">
                    <div class="w-full grid place-items-center">
                        <img src="<?php echo esc_url(CeanWP_Functions::get_common_icon_url($item['logo'])); ?>" alt="icon" class="w-full  object-contain">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

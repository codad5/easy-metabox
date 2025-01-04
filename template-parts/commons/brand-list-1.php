<div class="w-full px-20 flex flex-wrap items-center">
    <!-- Left Section: Title and Description -->
    <div class="w-2/5 basis-2/5 h-full grid place-items-center">
        <div class="w-3/4 flex flex-col gap-7">
            <!-- Icon Placeholder -->
            <div class="w-full h-14">
                <div class="h-full aspect-square bg-primary-green"></div>
            </div>
            <!-- Section Title -->
            <div class="w-full">
                <h3 class="font-semibold text-3xl">
                    <?php echo esc_html($args['section_title'] ?? 'Default Title'); ?>
                </h3>
            </div>
            <!-- Section Description -->
            <div class="w-full font-normal text-base text-[#999999]">
                <?php echo esc_html($args['section_description'] ?? 'Default Description'); ?>
            </div>
        </div>
    </div>
    <!-- Right Section: Dynamic Grid -->
    <div class="w-3/5 basis-3/5 py-14">
        <div class="w-full gap-x-3.5 gap-y-5 grid grid-cols-2 grid-flow-row">
            <?php
            $items = $args['section_items'] ?? [];
            foreach ($items as $item) : ?>
                <div class="w-full p-7">
                    <div class="w-full flex flex-col gap-y-1">
                        <!-- Since Year -->
                        <div class="w-full text-[#999999] font-normal text-base">
                            <?php echo esc_html($item['since'] ?? 'Unknown Year'); ?>
                        </div>
                        <!-- Item Name -->
                        <div class="w-full font-semibold text-xl">
                            <?php echo esc_html($item['name'] ?? 'Default Name'); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

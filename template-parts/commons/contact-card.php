<div class="w-full flex flex-col justify-center items-center gap-7">
    <div class="w-full ">
        <h3 class="font-normal text-lg">
            <?php echo esc_html($args['section_title'] ?? 'Default Title'); ?>
        </h3>
    </div>
    <div class="w-full flex flex-col gap-2.5 px-5 lg:px-0">
        <?php foreach ($args['contact_methods'] as $contact_method) : ?>
            <div class="w-max py-3.5 px-5 border border-[#262626] bg-[#1A1A1A] rounded-md">
                <a class="font-normal text-sm text-[#999999] flex gap-1"  href="<?php echo esc_url($contact_method['url'] ?? 'https://ceanigeria.com'); ?>">
                    <?php echo esc_html($contact_method['title'] ?? 'Default Title'); ?>
                    <div class="inline-block w-5 aspect-square">
                        <img src="<?php echo CeanWP_Functions::get_common_icon_url('external-link'); ?>" alt="external-link" class="w-full h-full object-contain" />
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
<!--        <div class="py-3.5 px-5 border border-[#262626] bg-[#1A1A1A]">-->
<!--            <a class="font-normal text-sm text-[#999999]" href="--><?php //echo esc_url($args['location_url'] ?? 'https://ceanigeria.com'); ?><!--">-->
<!--                --><?php //echo esc_html($args['location'] ?? 'Default Location'); ?>
<!--            </a>-->
<!--        </div>-->
<!--        <div class="py-3.5 px-5 border border-[#262626] bg-[#1A1A1A]">-->
<!--            <a class="font-normal text-sm text-[#999999]" href="tel:(084) 168-993-7763">-->
<!--                (084) 168-993-7763-->
<!--            </a>-->
<!--        </div>-->
    </div>
</div>
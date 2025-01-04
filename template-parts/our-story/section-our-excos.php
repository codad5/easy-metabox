<div class="px-20 w-full flex flex-col gap-10">
    <div class="w-full">
        <div class="w-full text-center">
            <h2 class="font-semibold text-4xl">Our Excos</h2>
        </div>
        <div class="w-full pt-3.5 font-medium text-base text-[#999999] text-center">
            Get to know our team of exceptional individuals steering the Cinema Exhibitors Association of Nigeria (CEAN). These leaders are dedicated to shaping the future of the cinema industry in Nigeria and beyond.
        </div>
    </div>

    <div class="w-full flex gap-5">
        <?php
        // Retrieve the team members from the function
        $team_members = CeanWP_Functions::get_team_members_list(); // Call the method to get the list

        // Loop through each team member
        foreach ($team_members as $member): ?>
            <div class="h-96 w-1/4">
                <div class="w-full h-2/3 flex justify-center items-center">
                    <div class="h-full flex flex-col gap-4 items-center justify-center">
                        <div class="w-28 rounded-full aspect-square">
                            <!-- Dynamically use the image from the member's name -->
                            <img class="w-full h-full object-cover rounded-full"
                                 src="<?php echo get_theme_file_uri('assets/images/people/' . strtolower(str_replace(' ', '-', $member['name'])) . '.png'); ?>"
                                 alt="<?php echo esc_attr($member['name']); ?>" />
                        </div>
                        <div class="text-center font-semibold text-lg">
                            <?php echo esc_html($member['name']); ?>
                        </div>
                        <div class="text-center font-medium text-base">
                            <?php echo esc_html($member['title']); ?>
                        </div>
                    </div>
                </div>
                <div class="w-full h-1/3 flex gap-2.5 justify-center items-center">
                    <!-- Loop through social media links and display icons -->
                    <?php foreach ($member['socials'] as $platform => $url): ?>
                        <!-- Get the icon URL dynamically using the get_common_icon_url method -->
                        <?php $icon_url = CeanWP_Functions::get_common_icon_url($platform); ?>
                        <?php if ($icon_url): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" class="w-12 grid place-items-center aspect-square rounded-full bg-gradient-to-b from-[#1A1A1A]/100 to-[#1A1A1A]/0 border border-[#262626]">
                                <img src="<?php echo esc_url($icon_url); ?>"
                                     alt="<?php echo esc_attr($platform); ?>"
                                     class="w-6 h-6" />
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

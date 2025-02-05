<div class="w-full px-4 lg:px-20">
    <div class="w-full flex flex-col gap-8">
        <div class="w-full flex flex-col gap-2.5">
            <h3 class="w-full font-semibold text-2xl lg:text-4xl">
                Meet our Professional Team
            </h3>
            <div class="text-[#999999] text-sm lg:text-base font-medium">
                At CEAN, our success is driven by the dedication and expertise of our team. Get to know the people behind our mission to transform the movie industry in Nigeria.
            </div>
        </div>
        <div class="w-full">
            <div class="w-full lg:h-[444px] flex flex-col lg:flex-row justify-center items-center gap-2.5">
                <?php
                $team_members = CeanWP_Functions::get_team_members_list();
                foreach ($team_members as $member):
                    $image_file = strtolower($member['img'] ?? (str_replace(' ', '-', $member['name']) . '.png'));
                    ?>
                    <div class="w-[305px] h-full p-6 flex flex-col gap-5">
                        <div class="w-full aspect-square">
                            <img class="" src="<?php echo get_theme_file_uri("assets/images/people/{$image_file}"); ?>" alt="<?php echo $member['name']; ?>" />
                        </div>
                        <div class="flex w-full flex-grow flex-col gap-1">
                            <div class="w-full font-semibold text-lg lg:text-xl">
                                <?php echo $member['name']; ?>
                            </div>
                            <div class="w-full text-[#018B8D] text-sm lg:text-base font-semibold">
                                <?php echo $member['title']; ?>
                            </div>
                            <div class="w-full text-sm lg:text-base font-medium text-[#999999]">
                                <?php echo substr($member['description'], 0, 120); ?>...
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="w-full flex justify-center items-end pt-8 hidden">
            <div class="py-4 px-5 flex gap-5 justify-around items-center">
                <span class="font-normal text-sm">
                    Meet Our Team
                </span>
            </div>
        </div>
    </div>
</div>

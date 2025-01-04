<div class="w-full px-20">
    <div class="w-full flex flex-col gap-8">
        <div class="w-full flex flex-col gap-2.5">
            <h3 class="w-full font-semibold text-4xl">
                Meet our Professional Team
            </h3>
            <div class="text-[#999999] text-base font-medium">
                At CEAN, our success is driven by the dedication and expertise of our team. Get to know the people behind our mission to transform the movie industry in Nigeria.
            </div>
        </div>
        <div class="w-full">
            <div class="w-full h-[444px] flex justify-center items-center gap-2.5">
                <?php
                $team_members = [
                    [
                        'name' => 'Patrick Lee',
                        'title' => 'Chairman',
                        'description' => 'Patrick is a conscientious and professional Executive with extensive experience in the Nigerian Cinema Industry.'
                    ],
                    [
                        'name' => 'Moses Babatope',
                        'title' => 'Secretary',
                        'description' => 'Moses is passionate about taking Nigerian films across the globe, accessing new markets and delivering returns to stakeholders.'
                    ],
                    [
                        'name' => 'Opeyemi Agayi',
                        'title' => 'Treasurer',
                        'description' => 'Opeyemi has over 15 years of combined business management, entertainment, advisory, and entrepreneurship experience.'
                    ],
                    [
                        'name' => 'Michael Ndiomu',
                        'title' => 'Exco',
                        'description' => 'Michael is a financial services expert with experience in several banks including UBA and Access Bank Plc.'
                    ]
                ];

                foreach ($team_members as $member):
                    $image_file = strtolower(str_replace(' ', '-', $member['name'])) . '.png';
                    ?>
                    <div class="w-[305px] h-full p-6 flex flex-col gap-5">
                        <div class="w-full aspect-square">
                            <img class="" src="<?php echo get_theme_file_uri("assets/images/people/{$image_file}"); ?>" alt="<?php echo $member['name']; ?>" />
                        </div>
                        <div class="flex w-full flex-grow flex-col gap-1">
                            <div class="w-full font-semibold text-xl">
                                <?php echo $member['name']; ?>
                            </div>
                            <div class="w-full text-[#018B8D] text-base font-semibold">
                                <?php echo $member['title']; ?>
                            </div>
                            <div class="w-full text-base font-medium text-[#999999]">
                                <?php echo $member['description']; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="w-full flex justify-center items-end pt-8">
            <div class="py-4 px-5 flex gap-5 justify-around items-center">
                <span class="font-normal text-sm">
                    Meet Our Team
                </span>
            </div>
        </div>
    </div>
</div>

<div class="w-full px-20">
    <div class="w-full flex">
        <div class="basis-2/5 w-2/5 flex items-center">
            <div class="w-4/5 flex flex-col gap-2.5">
                <h2 class="text-4xl font-semibold">Our Values</h2>
                <div class="font-medium text-base text-[#999999]">
                    Our story is one of continuous growth and evolution. We started as a small team with big dreams, determined to promote the big screen and transform the movie-going experience in Nigeria.
                </div>
            </div>
        </div>
        <div class="basis-3/5 w-3/5 p-7 flex flex-col gap-12">
            <?php
            $values = [
                [
                    'title' => 'Trust',
                    'description' => 'Trust is the cornerstone of every successful real estate transaction.',
                    'icon' => 'star-5-stroke.png'
                ],
                [
                    'title' => 'Excellence',
                    'description' => 'We set the bar high for ourselves. From the properties we list to the services we provide.',
                    'icon' => 'academic-cap.png'
                ],
                [
                    'title' => 'Client-Centric',
                    'description' => 'Your dreams and needs are at the center of our universe. We listen, understand.',
                    'icon' => 'group.png'
                ],
                [
                    'title' => 'Our Commitment',
                    'description' => 'We are dedicated to providing you with the highest level of service and professionalism.',
                    'icon' => 'star-5-stroke.png'
                ]
            ];
            ?>

            <?php foreach (array_chunk($values, 2) as $row): ?>
                <div class="w-full flex gap-12 justify-center">
                    <?php foreach ($row as ['title' => $title, 'description' => $description, 'icon' => $icon]): ?>
                        <div class="h-full basis-1/2 flex-col flex gap-4">
                            <div class="flex gap-2.5 items-center w-full">
                                <div class="w-14 aspect-square rounded-full border border-primary-green grid place-items-center">
                                    <img src="<?php echo get_theme_file_uri("assets/images/icons/{$icon}"); ?>" alt="<?php echo $title; ?>" class="w-8 h-8" />
                                </div>
                                <div class="font-semibold text-xl">
                                    <?php echo $title; ?>
                                </div>
                            </div>
                            <div class="w-full font-medium text-base text-[#999999]">
                                <?php echo $description; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

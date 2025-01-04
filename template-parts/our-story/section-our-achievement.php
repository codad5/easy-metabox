<div class="w-full px-20">
    <div class="w-full flex flex-col gap-10">
        <div class="w-full flex flex-col gap-2 justify-center items-center">
            <h2 class="w-full text-center text-4xl font-semibold">
                Company Achievements
            </h2>
            <div class="w-3/5 text-[#999999] text-base">
                At CEAN, we take pride in our accomplishments and the positive impact we have made on the lives of our members. Here are some of our notable achievements
            </div>

        </div>
        <div class="w-full">
            <div class="flex flex-wrap">
                <?php
                $achivements = [
                    [
                        'title' => 'Advancing Local Content',
                        'description' => 'Championed the promotion of Nollywood films, boosting local content in cinemas and driving significant growth in Nigeria’s film industry.',
                    ],
                    [
                        'title' => __('Recognition for Excellence', 'cean-wp-theme'),
                        'description' => __('Achieved record-breaking audience attendance through innovative marketing campaigns and partnerships with major film distributors.', 'cean-wp-theme'),
                    ],
                    [
                        'title' => __('Promoting Collaboration and Community', 'cean-wp-theme'),
                        'description' => __('Successfully unified cinema exhibitors across Nigeria, fostering a collaborative platform that enhances industry standards and practices.', 'cean-wp-theme'),
                    ],
                    [
                        'title' => __('Stay Ahead of the Curve', 'cean-wp-theme'),
                        'description' => __('Advocating for favorable policies and support from the government, ensuring sustainable growth and development for the Nigerian cinema industry.', 'cean-wp-theme'),
                    ],
                ]
                ?>
                <?php foreach ($achivements as ['title' => $title, 'description' => $description]) : ?>
                    <div class="p-10 w-1/2">
                        <div class="w-full flex flex-col gap-5">
                            <div class="w-full h-14 flex">
                                <div class="bg-primary-green h-14 aspect-square">
                                </div>
                                <div class="h-full flex items-center w-full p-2.5 font-semibold text-xl">
                                    <?php echo $title; ?>
                                </div>
                            </div>
                            <div class="w-full text-[#999999] font-medium text-base">
                                <?php echo $description; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
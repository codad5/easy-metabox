<div class="w-full px-4 lg:px-20">
    <div class="w-full">
        <div class="w-full flex flex-col gap-2.5">
            <h3 class="font-semibold text-3xl lg:text-4xl">Our Mission</h3>
            <div class="w-full lg:w-4/5 font-medium text-sm lg:text-base text-[#999999]">CEAN's mission is to promote and to protect the value of cinema exhibition in Nigeria: Providing CEAN members with up-to-date information on best practices and identifying ways to preserve, and promote Nigerian exhibitors.</div>
        </div>
        <?php
        $items = [
            [
                "title" => "10+ years of Excellence",
                "description" => "With over 10 years in the industry, we've amassed a wealth of knowledge and experience.",
            ],
            [
                "title" => "Happy Clients",
                "description" => "Our greatest achievement is the satisfaction of our clients. Their success stories fuel our passion for what we do.",
            ],
            [
                "title" => "Industry Recognition",
                "description" => "We've earned the respect of our peers and industry leaders, with accolades and awards that reflect our commitment to excellence.",
            ],
        ];
        ?>

        <div class="w-full flex flex-col lg:flex-row justify-between gap-5 lg:gap-7">
            <?php foreach ($items as $item): ?>
                <div class="w-full lg:h-48 lg:w-1/3 px-7 py-4 lg:py-7 flex flex-col gap-6">
                    <div class="container font-semibold text-2xl">
                        <?= htmlspecialchars($item['title']); ?>
                    </div>
                    <div class="container font-medium text-base text-[#999999]">
                        <?= htmlspecialchars($item['description']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
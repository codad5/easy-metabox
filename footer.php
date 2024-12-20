<footer class="w-full px-20">
    <div class="w-full py-14">
        <div class="w-full flex h-28">
            <div class="basis-9/12 w-9/12 flex flex-col gap-2.5">
                <div class="w-full font-semibold text-4xl">
                    Start Your Journey Today
                </div>
                <div class="w-full text-base font-medium text-[#999999]">
                    Immerse yourself in the world of Cinema. Explore our comprehensive resources, connect with fellow industry enthusiasts, and drive innovation in the cinema industry. Join a dynamic community of forward-thinkers.
                </div>
            </div>
            <div class="basis-3/12 w-3/12 h-full flex justify-end items-center px-3.5">
                <a class="h-fit bg-primary-green rounded-md font-semibold text-sm text-center px-5 py-3.5">
                    Join Now
                </a>
            </div>
        </div>
    </div>
    <div class="w-full py-14">
        <div class="w-full flex justify-between h-full">
            <div class="w-80 h-36 flex flex-col justify-between gap-8">
                <div class="w-full">
                    <img class="h-28 aspect-square" alt="" src="<?php echo get_theme_file_uri("assets/images/cean-logo.png"); ?>"/>
                </div>

                <div class="w-full border border-[#262626] py-2.5 px-5">
                    <div class="w-full flex justify-start gap-1.5">
                        <div class="bg-[#999999] w-5 aspect-square">

                        </div>
                        <div class="h-full grow-1 ">
                            <input class="w-full h-full bg-transparent placeholder-[#262626] placeholder:text-sm" type="email" placeholder="Enter Your Email"/>
                        </div>
                        <div class="h-6 aspect-square bg-green-500">

                        </div>
                    </div>
                </div>
            </div>
            <nav class="w-4/6 flex" aria-label="Footer Navigation">
                <?php
                $footer_nav = [
                    "Useful Links" => [
                        "/home" => "Home",
                        "/services" => "Services",
                        "/news" => "News",
                        "/testimonials" => "Testimonials",
                        "/advisors" => "Advisors",
                        "/contact-us" => "Contact Us"
                    ],
                    "Services" => [
                        "/market-research" => "Market Research",
                        "/financial-modeling" => "Financial Modeling",
                        "/service-management" => "Service Management",
                        "/human-resource" => "Human Resource",
                        "/corporate-management" => "Corporate Management",
                        "/legal-solutions" => "Legal Solutions",
                        "/tax-planning" => "Tax Planning",
                        "/financial-planning" => "Financial Planning"
                    ],
                    "Support" => [
                        "/documentation" => "Documentation",
                        "/faq" => "F.A.Q",
                        "/support-policy" => "Support Policy",
                        "/privacy" => "Privacy / Terms of Use",
                        "/advertise" => "Advertise"
                    ],
                    "Careers" => [
                        "/deals-coupons" => "Deals & Coupons",
                        "/how-it-works" => "How it Works",
                        "/articles-tips" => "Articles & Tips",
                        "/terms-of-service" => "Terms of Service"
                    ],
                    "Terms & Privacy" => [
                        "/get-the-theme" => "Get The Theme",
                        "/privacy-security" => "Privacy & Security",
                        "/terms-conditions" => "Terms & Conditions",
                        "/cookie-policy" => "Cookie Policy"
                    ]
                ];

                foreach ($footer_nav as $section => $links): ?>
                    <div class="basis-1/5 w-1/5 flex flex-col gap-7">
                        <h3 class="w-full font-medium text-lg">
                            <?php echo $section; ?>
                        </h3>
                        <ul class="w-full text-sm font-medium text-[#999999] list-none flex flex-col justify-between gap-3">
                            <?php foreach ($links as $url => $link): ?>
                                <li class="w-full">
                                    <a href="<?php echo $url; ?>" class="text-[#999999]">
                                        <?php echo $link; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>
    <div class="w-full bg-[#1A1A1A] px-20">
        <div class="w-full h-16 flex justify-between">
            <div class="font-semibold text-sm text-[#999999]">
                © <?php echo date("Y"); ?> CEAN. All rights reserved
            </div>
            <div class="h-5 flex justify-evenly gap-3.5">
                <div class="h-full aspect-square bg-primary-green">

                </div>
                <div class="h-full aspect-square bg-blue-700">

                </div>
                <div class="h-full aspect-square bg-amber-500">

                </div>
            </div>
            <div class="font-semibold text-sm text-[#999999]">
                Designed by Fusion Intelligence
            </div>
        </div>
    </div>
</footer>
</main>
<?php wp_footer(); ?>
</body>
</html>
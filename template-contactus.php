<?php
/*
 * Template Name: Contact Us
 */
?>
<?php get_header(); ?>
<div class="w-full px-20 py-14">
    <div class="w-full h-full flex gap-x-7 items-center">
        <div class="w-1/4 px-7 border-r border-r-[#262626]">
            <?php get_template_part('template-parts/commons/contact-card', null, [
                'section_title' => __('General Inquiries', 'cean-wp-theme'),
                'contact_methods' => [
                    [
                        'title' => 'https://ceanigeria.com',
                        'url' => 'https://ceanigeria.com',
                    ],
                    [
                        'title' => '(084) 168-993-7763',
                        'url' => 'tel:(084) 168-993-7763',
                    ]
                ]]); ?>
        </div>
        <div class="w-1/4 px-7 border-r border-r-[#262626]">
            <?php get_template_part('template-parts/commons/contact-card', null, [
                'section_title' => __('Technical Support', 'cean-wp-theme'),
                'contact_methods' => [
                    [
                        'title' => 'contact@ceanigeria.com',
                        'url' => 'mailto:contact@ceanigeria.com'
                    ],
                    [
                        'title' => '0802 000 0000',
                        'url' => 'tel:0802 000 0000',
                    ]
                ]]); ?>
        </div>
        <div class="w-1/4 px-7 border-r border-r-[#262626]">
            <div class="w-full flex flex-col justify-center items-center gap-7">
                <div class="w-full ">
                    <h3 class="font-normal text-lg">
                        Our Office
                    </h3>
                </div>
                <div class="w-full flex flex-col gap-2.5">
                    <div class="w-full text-base font-normal text-[#999999]">
                        15 Commercial Avenue, Sabo Yaba, Lagos
                    </div>
                    <div class="py-3.5 px-5 border border-[#262626] bg-[#1A1A1A] rounded-md">
                        <a class="font-normal text-sm text-[#999999] flex gap-1" href="tel:(084) 168-993-7763">
                            Get Directions
                            <div class="inline-block w-5 aspect-square">
                                <img src="<?php echo CeanWP_Functions::get_common_icon_url('external-link'); ?>" alt="external-link" class="w-full h-full object-contain" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-1/4">
            <div class="w-full flex flex-col justify-center items-center gap-7">
                <div class="w-full ">
                    <h3 class="font-normal text-lg">
                        Connect with Us
                    </h3>
                </div>
                <div class="w-full flex gap-2.5 h-12">
                    <?php
                        $socials = CeanWP_Functions::get_contact_socials();
                    ?>
                    <?php foreach ($socials as $social) : ?>
                        <div class="h-full grid place-items-center px-3.5 bg-[#1A1A1A] rounded-md">
                            <a href="<?php echo esc_url($social['url']); ?>">
                                <img class="h-full" src="<?php echo esc_url(CeanWP_Functions::get_common_icon_url($social['icon'])); ?>" alt="<?php echo esc_attr($social['title']); ?>" />
                            </a>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

</div>
<div class="w-full px-20 bg-[#1A1A1A] py-16">
    <div class="w-full flex flex-col gap-2.5">
        <div class="w-full">
            <h3 class="font-semibold text-4xl">
                Get in Touch
            </h3>
        </div>
        <div class="w-full font-normal text-base text-[#999999]">
            We value your feedback, questions, and concerns at Nutritionist. Our dedicated team is here to assist you and provide the support you need on your nutritional journey. Please don't hesitate to reach out to us using any of the following contact methods
        </div>
    </div>
</div>
<?php get_template_part('template-parts/contactus/contact-us-form'); ?>
<?php get_footer(); ?>

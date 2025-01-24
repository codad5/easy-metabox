<?php
/*
 * Template Name: Our story
 */
?>
<?php get_header(); ?>
<div class="w-full px-4 lg:px-20 py-5 pt-28 lg:pt-0 lg:py-12 pb-0">
    <div class="w-full lg:px-20 lg:py-20 py-4 flex flex-col items-center lg:items-start lg:flex-row gap-7 lg:gap-20">
        <div class="w-full lg:w-1/2 lg:h-full flex flex-col gap-4">
            <h2 class="w-full font-bold text-2xl lg:text-4xl">
                We only see the Big <span class="text-primary-green">Picture..</span>
            </h2>
            <p class="w-full font-normal text-sm lg:text-base text-[#E6E6E6]">
                <?php the_content(); ?>
            </p>
        </div>
        <div class="w-full lg:w-1/2 grid place-items-center">
            <img class="w-full aspect-square object-cover" src="<?php echo get_theme_file_uri("assets/images/ceanwp-globe.png"); ?>" alt="" />
        </div>

    </div>
</div>
<div class="w-full h-12 lg:h-16 hidden">

</div>
<?php get_template_part('template-parts/our-story/section', 'our-excos'); ?>
<div class="w-full h-12 lg:h-16">

</div>
<?php get_template_part('template-parts/our-story/section', 'our-achievement'); ?>
<div class="w-full h-12 lg:h-16">

</div>
<div class="w-full px-4 lg:px-20 bg-[#1A1A1A] lg:bg-transparent">
    <div class="w-full flex flex-col gap-2.5 justify-center items-center py-12">
        <div class="w-full">
            <span class="py-1 px-2 font-medium text-sm lg:text-base bg-[#333333]">
                Meet the Visionaries
            </span>
        </div>
        <div class="w-full font-semibold text-2xl lg:text-4xl">
            Uniting Leadership and Expertise to Shape Cinema's Future
        </div>
    </div>
</div>
<?php
//get_template_part(
//    'template-parts/commons/brand-list-1',
//    null,
//    [
//        'section_title' => 'Board of Trustees',
//        'section_description' => 'Guiding the Vision and Mission of CEAN with Wisdom and Leadership',
//        'section_items' => CeanWP_Functions::get_board_of_trustees_list(),
//    ]
//);
//?>

<?php
get_template_part(
    'template-parts/commons/brand-list-2',
    null,
    [
        'section_title' => 'Esteemed Members',
        'section_description' => 'Our Esteemed Members represent a distinguished network of pioneers, innovators, and leaders who are shaping the future of the cinema industry. Bound by a shared passion for storytelling and entertainment, they champion creativity, drive technological advancements, and inspire growth within the industry. As the backbone of the cinema exhibition landscape in Nigeria, these trailblazers are committed to setting new benchmarks for excellence, fostering collaboration, and ensuring the sustained development of a vibrant and inclusive cinematic experience for audiences nationwide.',
        'section_icon' => CeanWP_Functions::get_common_icon_url('est-meb'),
        'section_items' => CeanWP_Functions::get_esteemed_members_list()
    ]
);

?>

<?php get_footer(); ?>

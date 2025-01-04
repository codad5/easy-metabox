<?php
/*
 * Template Name: Our story
 */
?>
<?php get_header(); ?>
<div class="w-full px-20 py-12">
    <div class="w-full px-20 py-20 flex gap-20">
        <div class="w-1/2 h-full flex flex-col gap-4">
            <h2 class="w-full font-bold text-4xl">
                We only see the Big <span class="text-primary-green">Picture..</span>
            </h2>
            <p class="w-full font-normal text-base text-[#E6E6E6]">
                <?php the_content(); ?>
            </p>
        </div>
        <div class="w-1/2 grid place-items-center">
            <img class="w-full aspect-square object-cover" src="<?php echo get_theme_file_uri("assets/images/ceanwp-globe.png"); ?>" alt="" />
        </div>

    </div>
</div>
<div class="w-full h-14">

</div>
<?php get_template_part('template-parts/our-story/section', 'our-excos'); ?>
<div class="w-full h-14">

</div>
<?php get_template_part('template-parts/our-story/section', 'our-achievement'); ?>
<div class="w-full h-14">

</div>
<div class="w-full px-20">
    <div class="w-full flex flex-col gap-2.5 justify-center items-center py-12">
        <div class="w-full">
            <span class="py-1 px-2 font-medium text-base bg-[#333333]">
                Meet the Visionaries
            </span>
        </div>
        <div class="w-full font-semibold text-4xl">
            Uniting Leadership and Expertise to Shape Cinema's Future
        </div>
    </div>
</div>
<?php
get_template_part(
    'template-parts/commons/brand-list-1',
    null,
    [
        'section_title' => 'Board of Trustees',
        'section_description' => 'Guiding the Vision and Mission of CEAN with Wisdom and Leadership',
        'section_items' => CeanWP_Functions::get_board_of_trustees_list(),
    ]
);
?>

<?php
get_template_part(
    'template-parts/commons/brand-list-1',
    null,
    [
        'section_title' => 'Esteemed Members',
        'section_description' => 'United by Passion, Driving Growth and Innovation in the Cinema Industry',
        'section_items' => CeanWP_Functions::get_esteemed_members_list()
    ]
);
?>

<?php get_footer(); ?>

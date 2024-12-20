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
<?php get_footer(); ?>

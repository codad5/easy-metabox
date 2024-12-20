<?php get_header(); ?>
<!--<main>-->
<!--    --><?php //the_title(); ?>
<!--</main>-->
<?php get_template_part('template-parts/hero/section', 'hero'); ?>
<div class="container h-14"></div>
<?php get_template_part('template-parts/hero/section', 'partners-marquee'); ?>
<div class="container h-16"></div>
<?php get_template_part('template-parts/hero/section', 'index-new-release'); ?>
<?php get_template_part('template-parts/hero/section', 'index-top-movies'); ?>
<div class="container h-16"></div>
<?php get_template_part('template-parts/hero/section', 'our-mission'); ?>
<div class="container h-16"></div>
<?php get_template_part('template-parts/hero/section', 'our-value'); ?>
<div class="container h-16"></div>
<?php get_template_part('template-parts/hero/section', 'our-vision'); ?>
<?php get_template_part('template-parts/hero/section', 'distributors-marquee'); ?>
<div class="container h-20"></div>
<?php get_template_part('template-parts/hero/section', 'top-grossing-box-office'); ?>
<div class="container h-20"></div>
<?php get_template_part('template-parts/hero/section', 'meet-our-professional'); ?>
<div class="container h-14"></div>
<div class="w-full px-20 flex flex-col gap-9">
    <div class="w-full p-8">
        <span class="text-[#999999] text-base font-semibold">
            Working with CEAN was a pleasure. Our team has created a stunning landscape that perfectly captures our brand's essence. The feedback from our members has been overwhelmingly positive.
        </span>
    </div>
    <div class="w-full flex gap-2.5 h-12">
        <img class="h-full aspect-square border rounded-full" src="<?php  echo get_theme_file_uri('assets/images/patrick-lee.png'); ?>" alt="" />
        <div>
            <div class="w-full font-semibold text-xl">
                Patrick Lee
            </div>
            <div class="w-full text-[#999999] text-base font-semibold">
                Chairman
            </div>
        </div>
    </div>
</div>
<div class="container h-24"></div>
<?php get_template_part('template-parts/hero/section', 'news-and-resources'); ?>


<?php get_footer(); ?>
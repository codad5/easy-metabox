<?php get_header(); ?>
<?php $cean_current_page_id = get_the_ID(); ?>
<?php //if(have_posts()) : ?>
<!--    --><?php //while(have_posts()) : the_post(); ?>
<!--        <h2>--><?php //the_title(); ?><!--</h2>-->
<!--        --><?php //the_content(); ?>
<!--    --><?php //endwhile; ?>
<?php //endif; ?>

<div class="w-full h-[439px] relative bg-green-500">
    <img class="w-full h-full object-cover" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
    <div class="absolute inset-0 w-full h-full bg-gradient-to-b from-black/0 to-black/90"></div>
</div>
<div class="w-full px-20 pt-14">
    <div class="w-full flex flex-col gap-5">
        <h1 class="font-medium text-2xl">
            <?php the_title(); ?>
        </h1>
        <div class="w-full text-[#999999] text-base font-normal">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<div class="w-full px-20 py-7 flex flex-col gap-10">
    <h2 class="font-medium w-full text-xl">Similar News</h2>
    <?php get_template_part('template-parts/commons/post-card', null, ['cean_wp_exclude_posts_id' => [$cean_current_page_id]]); ?>
</div>
<?php get_footer(); ?>

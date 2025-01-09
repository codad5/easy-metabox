<?php get_header(); ?>
<?php $cean_current_page_id = get_the_ID(); ?>
<?php $post = CeanWP_Functions::get_report($cean_current_page_id); ?>

<div class="w-full px-20 py-16 flex flex-col gap-5">
    <div class="w-full">
        <a class="border border-[#1F1F1F] p-3 hover:underline text-[#666666]" href="/box-office-reports">
           <span class="inline-block">
               <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-left-arrow'); ?>"  class="w-3 aspect-square" alt="Back to Reports">
           </span>
            Back to Reports
        </a>
    </div>
    <div class="w-full flex gap-5 items-center">
        <h1 class="text-4xl font-semibold"><?php echo $post['title']; ?> <?php echo $post['report_date']; ?></h1>
        <div class="font-semibold text-base">
            Box office - <?php echo date('d F Y', strtotime($post['date_modified'])); ?>
        </div>
    </div>
    <div class="w-full flex flex-col gap-5">
        <!--                    --><?php //var_dump($value['image_id']); ?>
        <?php foreach ($post['image_ids'] as $image_id) : ?>
            <div class="w-full rounded-3xl">
                <img class="w-full h-full object-cover" src="<?php echo wp_get_attachment_image_url($image_id, 'large'); ?>" alt="report image" />
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>

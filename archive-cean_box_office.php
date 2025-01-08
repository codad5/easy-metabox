<?php get_header(); ?>
<?php
// Fetch all posts
$post = CeanWP_Functions::get_reports();
?>
<?php if (!empty($post)) : ?>
<div class="w-full px-20 py-16">

    <?php $value = $post[0]; ?>
    <div class="w-full  flex flex-col gap-5">
        <div class="w-full flex gap-5 items-center">
            <h1 class="font-semibold text-4xl inline-block">
                <?php echo $value['title']; ?> <?php echo $value['report_date']; ?>
            </h1>
            <div class="font-semibold text-base">
<!--                         date in this format  18 December 2023-->
                Box office - <?php echo date('d F Y', strtotime($value['date_modified'])); ?>
            </div>
        </div>
        <div class="w-full flex flex-col gap-5">
<!--                    --><?php //var_dump($value['image_id']); ?>
            <?php foreach ($value['image_ids'] as $image_id) : ?>
                <div class="w-full rounded-3xl">
                    <img class="w-full h-full object-cover" src="<?php echo wp_get_attachment_image_url($image_id, 'large'); ?>" alt="report image" />
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="w-full px-20">
    <div class="w-full flex flex-col">
        <div class="w-full flex flex-col gap-4 py-14">
            <div>
                <div class="font-medium text-base py-1 px-2 bg-[#333333] rounded w-fit">
                    Stay Informed with Fresh Content
                </div>
            </div>
            <h2 class="w-full font-medium text-5xl">
                Latest Comscore Reports
            </h2>
        </div>
        <div class="w-full flex flex-wrap gap-12">
            <?php foreach ($post as $key => $value) : ?>
                 <?php if ($key !== 0) : ?>
                    <div class="w-1/4 h-[476px] pt-14 flex flex-col gap-5">
                        <div class="w-full h-3/5 basis-3/5 rounded-lg relative">
                            <img class="w-full h-full object-cover" src="<?php echo wp_get_attachment_image_url($value['image_ids'][0], 'large'); ?>" alt="report image" />
                            <div class="w-full h-full absolute inset-0 bg-gradient-to-b from-black/0 to-black/90"></div>
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <div class="w-full font-medium text-base text-[#999999]">
                                Box Office - <?php echo date('d F Y', strtotime($value['date_modified'])); ?>
                            </div>
                            <div class="w-full font-bold text-lg hover:underline">
                                <a href="<?php echo esc_url($value['permalink']); ?>">
                                    <?php echo $value['title']; ?> <?php echo $value['report_date']; ?>
                                </a>
                            </div>
                        </div>
                        <div class="w-full">
                            <a class="inline-block px-5 py-3.5 text-[#999999] text-sm font-medium border border-[#262626]" href="<?php echo esc_url($value['pdf_url']); ?>" target="_blank">
                                View Full Report <span class="inline-block">
                                    <img src="<?php echo CeanWP_Functions::get_common_icon_url('external-link'); ?>" alt="external-link" class="w-3 aspect-square" />
                                </span>
                            </a>
                        </div>
                    </div>
                 <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>

<?php get_header(); ?>
<?php $cean_current_page_id = get_the_ID(); ?>
<?php $movie_id = get_query_var('movie_id') ?? false; ?>

<?php $post = empty($movie_id) ? CeanWP_Functions::get_movie($cean_current_page_id) : CeanWP_Functions::get_movie_details_from_reach($movie_id); ?>

<div class="w-full px-20 py-16 flex flex-col gap-12">
    <div class="w-full">
        <a class="border border-[#1F1F1F] p-3 hover:underline text-[#666666]" href="/movies">
           <span class="inline-block">
               <img src="<?php echo CeanWP_Functions::get_common_icon_url('white-left-arrow'); ?>"  class="w-3 aspect-square" alt="Back to Reports">
           </span>
            Back to Movies
        </a>
    </div>
    <?php if (!empty($post['title'])): ?>
    <div class="w-full max-h-[709px] relative overflow-hidden">
        <img src="<?php echo !empty($post['movie_poster']) ? $post['movie_poster'] : get_theme_file_uri("assets/images/gang-of-lagos.jpg");?>"  class="w-full h-full object-cover" alt="<?php echo $post['title']; ?>">
        <div class="flex flex-col gap-5 justify-end py-4 items-center w-full h-full absolute inset-0 bg-gradient-to-b from-black/0 to-black/90">
            <div class="w-full text-center">
                <h1 class="font-bold text-4xl">
                    <?php echo $post['title']; ?>
                </h1>
            </div>
            <div class="w-full text-center">
                <a href="<?php echo $post['trailer_url']; ?>" class="inline-block font-semibold text-sm px-5 py-3.5 bg-[#018B8D] text-white rounded-lg" target="_blank">
                    Play Trailer
                </a>
            </div>
        </div>
    </div>
    <div class="w-full flex flex-col gap-5">
        <div class="flex bg-[#1A1A1A] px-10 py-8 rounded-lg">
            <div class="w-1/3 basis-1/3 flex flex-col gap-2.5 grow-0">
                <div class="w-full text-[#999999] text-base font-semibold">
                    Released Year
                </div>
                <div class="w-full text-white text-base font-semibold">
                    <?php echo date('F d, Y', strtotime($post['release_date'])); ?>
                </div>
            </div>
            <div class="w-1/3 basis-1/3 flex flex-col gap-2.5 grow-0">
                <div class="w-full text-[#999999] text-base font-semibold">
                    Genre
                </div>
                <div class="w-full text-white text-base font-semibold">
                    <?php echo ucwords($post['genre']); ?>
                </div>
            </div>
            <div class="w-1/3 basis-1/3 flex flex-col gap-2.5 grow-0">
                <div class="w-full text-[#999999] text-base font-semibold">
                    Director
                </div>
                <div class="w-full text-white text-base font-semibold capitalize">
                    <?php echo ucwords($post['director']); ?>
                </div>
            </div>
        </div>
        <div class="flex bg-[#1A1A1A] px-10 py-8 rounded-lg">
            <div class="w-full basis-full flex flex-col gap-2.5 grow-0">
                <div class="w-full text-[#999999] text-base font-medium">
                    Synopsis
                </div>
                <div class="w-full text-white text-base font-medium">
                    <?php echo $post['content']; ?>
                </div>
            </div>
        </div>
        <div class="flex bg-[#1A1A1A] px-10 py-8 rounded-lg">
            <div class="w-full basis-full flex flex-col gap-2.5 grow-0">
                <div class="w-full text-[#999999] text-base font-medium">
                    Top Cast
                </div>
                <div class="w-full text-white text-base font-medium">
                    <?php echo $post['cast']; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>

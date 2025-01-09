<?php get_header();  ?>
<?php get_template_part('template-parts/movies/slideshow', null); ?>
<div class="w-full h-24">

</div>
<div class="w-full flex flex-col gap-4 px-20">
    <div class="w-full px-10 flex flex-col gap-5">
        <div class="w-full">
            <div class="font-semibold text-base bg-primary-green py-2 px-5 w-fit rounded-lg">
                Movies
            </div>
        </div>
        <div class="w-full flex flex-col gap-20">
            <?php get_template_part('template-parts/movies/content-slider', null, [
                    'title' => 'Top Grossing Movies',
                    'movies' => array_map(function ($data) {
                        return [
                            'title' => $data['title'],
                            'poster' => wp_get_attachment_image_url($data['movie_poster'] ?? '', 'full'),
                            'duration' => $data['duration'] ?? 'n/a',
                            'rating' => $data['rating'] ?? 'unrated',
                            'permalink' => $data['permalink'] ?? '#'
                        ];
                    }, CeanWP_Functions::get_all_time_top_grossing_movies())
            ]) ?>
            <?php $new_release = CeanWP_Functions::get_coming_soon_from_reach(); ?>
            <?php if(!isset($new_release['error']) && isset($new_release['data'])): ?>
                <?php get_template_part('template-parts/movies/content-slider', null, [
                        'title' => 'Top Grossing Movies',
                        'movies' => array_map(function ($data) {
                            return [
                                'title' => $data['name'],
                                'poster' => $data['posterUrl'] ?? get_theme_file_uri("assets/images/gang-of-lagos.jpg"),
                                'duration' => $data['duration'] ?? 'n/a',
                                'rating' => $data['filmRating'] ?? 'unrated',
                                'permalink' => $data['permalink'] ?? '#'
                            ];
                        }, $new_release['data'])
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer();  ?>
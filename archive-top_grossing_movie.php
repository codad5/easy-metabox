<?php get_header();  ?>
<?php get_template_part('template-parts/movies/slideshow', null); ?>
<div class="w-full h-24 hidden lg:inline-block">

</div>
<div class="w-full flex flex-col gap-4 px-4 lg:px-20">
    <div class="w-full lg:px-10 flex flex-col gap-5">
        <div class="w-full hidden lg:inline-block">
            <div class="font-semibold text-base bg-primary-green py-2 px-5 w-fit rounded-lg">
                Movies
            </div>
        </div>
        <div class="w-full flex flex-col gap-10 lg:gap-20">
            <?php get_template_part('template-parts/movies/content-slider', null, [
                    'title' => 'Top Grossing Movies All time',
                    'swiper_class_name_suffix' => 'top-grossing',
                    'movies' => array_map(function ($data) {
                        return [
                            'title' => $data['title'],
                            'poster' => wp_get_attachment_image_url($data['movie_poster'] ?? '', 'full'),
                            'duration' => $data['duration'] ?? 'n/a',
                            'rating' => $data['rating'] ?? 'unrated',
//                            'permalink' => $data['permalink'] ?? '#',
                            'permalink' =>  "#{$data['id']}",
                            'box_office' => $data['box_office'] ?? 0
                        ];
                    }, CeanWP_Functions::get_all_time_top_grossing_movies()),
                'sub' => fn($m) => "₦".CeanWP_Functions::formatBoxOffice($m['box_office'], 10E10)
            ]) ?>
            <?php $new_release = CeanWP_Functions::get_coming_soon_from_reach(); ?>
            <?php if(!isset($new_release['error']) && isset($new_release['data'])): ?>
                <?php get_template_part('template-parts/movies/content-slider', null, [
                        'title' => 'New Releases This Week',
                        'swiper_class_name_suffix' => 'new-releases',
                        'movies' => array_map(function ($data) {
                            return [
                                'title' => $data['name'],
                                'poster' => $data['posterUrl'] ?? get_theme_file_uri("assets/images/gang-of-lagos.jpg"),
                                'duration' => $data['duration'] ?? 'n/a',
                                'rating' => $data['filmRating'] ?? 'unrated',
                                'permalink' => "#{$data['id']}"
//                                'permalink' => "/movies/{$data['id']}"
                            ];
                        }, $new_release['data'])
                ]) ?>
            <?php endif; ?>
            <?php get_template_part('template-parts/movies/content-slider', null, [
                'title' => 'Top Grossing Movies This week',
                'swiper_class_name_suffix' => 'top-grossing',
                'movies' => array_map(function ($data) {
                    return [
                        'title' => $data['title'],
                        'poster' => wp_get_attachment_image_url($data['movie_poster'] ?? '', 'full'),
                        'duration' => $data['duration'] ?? 'n/a',
                        'rating' => $data['rating'] ?? 'unrated',
                        'permalink' => "#{$data['id']}",
//                        'permalink' => $data['permalink'] ?? '#',
                        'box_office' => $data['box_office'] ?? 0
                    ];
                }, CeanWP_Functions::get_all_time_top_grossing_movies('week')),
                'sub' => fn($m) => "₦".CeanWP_Functions::formatBoxOffice($m['box_office'], 10E8)
            ]) ?>
        </div>
    </div>
</div>
<?php get_footer();  ?>
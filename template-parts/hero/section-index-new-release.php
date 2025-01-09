<div class=" w-full px-20">
    <?php $movies = CeanWP_Functions::get_coming_soon_from_reach(); ?>
    <?php if(!isset($movies['error']) && isset($movies['data'])): ?>
    <?php $movies = array_map(function ($data) {
        return [
            'title' => $data['name'],
            'poster' => $data['posterUrl'] ?? get_theme_file_uri("assets/images/gang-of-lagos.jpg"),
            'permalink' => "/movies/{$data['id']}",
            'distributor' => $data['distributor'] ?? 'Film One',
        ];
    }, $movies['data']); ?>
    <h3 class="font-semibold text-4xl">New Releases</h3>
    <div class=" font-medium text-base text-[#999999]">Discover the Latest Blockbusters and Hidden Gems on the Big Screen.</div>
    <div class=" py-10">
        <div class=" w-full overflow-x-scroll flex gap-4 pb-14 scrollbar scrollbar-h-2 scrollbar-thumb-[#E4E4E7] scrollbar-track-transparent">
            <?php foreach ($movies as $movie): ?>
            <div class="w-60 inline-block relative shrink-0 rounded-t-lg">
                <div class="w-full h-[308px] relative rounded-t-lg">
                    <img class="h-full w-full object-cover rounded-t-lg" src="<?php echo $movie['poster']; ?>" alt="<?php echo $movie['title']; ?>">
                    <div class="w-full h-full absolute inset-0 bg-gradient-to-b from-black/0 to-black/90"></div>
                </div>
                <div class="w-full  h-11">
                    <h4 class="font-semibold text-sm"><a href="<?php echo $movie['permalink']; ?>" ><?php echo $movie['title']; ?></a></h4>
                    <div class="font-normal text-xs text-[#78828A]"><?php echo $movie['distributor']; ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
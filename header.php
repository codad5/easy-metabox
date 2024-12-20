<!-- basoc html scaffolding -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP CRUD</title>
    <?php wp_head(); ?>
</head>
<body class="bg-primary-black text-white">
<header class="h-20 w-full bg-header-color sticky top-0 z-50">
    <div class="w-full container h-full flex justify-between items-center">
        <div class="h-full px-20 grid place-items-center">
            <div class="w-16 aspect-square grid place-items-center">
                <a class="" href="/">LOGO</a>
            </div>
        </div>
        <div class="flex-grow h-full">
            <nav class="h-full w-full">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'top-menu',
                        'menu_class' => 'flex gap-7 h-full w-full list-none items-center justify-center gap-6',
                        'container' => '',
//                        'items_wrap' => '<ul class="%2$s">%3$s</ul>',
//                        'link_before' => '<div class="text-sm font-semibold">',
//                        'link_after' => '</div>'
                    )
                );
                ?>
            </nav>
        </div>
        <div class="h-full px-20 grid place-items-center">
            <div class="w-full h-full flex justify-center items-center gap-7">
                <div class="">
                    <a href="<?php echo get_home_url(); ?>">Signup</a>
                </div>
                <div class="bg-primary-green px-6 py-3 rounded-md text-white">
                    <a href="<?php echo get_home_url(); ?>" class="text-sm font-semibold">Login</a>
                </div>
            </div>
        </div>
    </div>
</header>
<main class="w-full">
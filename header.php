<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?><?php wp_title(' | ', true, 'left'); ?></title>
    <style>
        .menu-item a {
            color: #7E7E81;
            text-decoration: none;
            text-transform: capitalize;
        }
        .current-menu-item a,
        .current_page_item a {
            color: #FFFFFF;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body class="bg-primary-black text-white font-urbanist w-screen min-h-screen">
<header class="h-20 w-full bg-header-color fixed lg:sticky top-0 z-50 font-urbanist overflow-x-hidden">
    <div class="w-full h-full flex justify-between items-center px-4 lg:px-0">
        <!-- Logo Section -->
        <div class="h-full px-4 lg:px-20 grid place-items-center">
            <div class="w-16 aspect-square grid place-items-center">
                <a class="" href="/"><img src="<?php echo CeanWP_Functions::get_common_icon_url('cean-logo'); ?>" alt="Logo" class="h-full w-full object-contain" /></a>
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-button" class="px-3.5 py-5 lg:hidden">
            <img src="<?php echo CeanWP_Functions::get_common_icon_url('menu-icon'); ?>" alt="Menu" class="h-5 aspect-square" />
        </button>

        <!-- Navigation Menu -->
        <div id="mobile-nav" class="lg:inline-block fixed lg:relative flex-grow h-screen lg:h-full w-screen lg:w-max inset-0 z-50 translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Close Button -->
            <button id="close-menu-button" class="absolute top-7 right-4 p-2 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <nav class="h-full w-full bg-primary-black lg:bg-transparent">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'top-menu',
                        'menu_class' => 'flex flex-col lg:flex-row gap-7 text-[#7E7E81] h-full w-full list-none items-center justify-start py-24 lg:py-0 lg:justify-center gap-6 capitalize',
                        'container' => '',
                    )
                );
                ?>
            </nav>
        </div>

        <!-- Signup/Login Section -->
        <div class="hidden lg:grid h-full px-20 place-items-center">
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

<script>
    // Toggle menu function
    function toggleMenu() {
        const nav = document.getElementById('mobile-nav');
        nav.classList.toggle('translate-x-full');
    }

    // Add click events to both buttons
    document.getElementById('mobile-menu-button').addEventListener('click', toggleMenu);
    document.getElementById('close-menu-button').addEventListener('click', toggleMenu);

    // Optional: Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const nav = document.getElementById('mobile-nav');
        const mobileMenuButton = document.getElementById('mobile-menu-button');

        if (!nav.contains(event.target) &&
            !mobileMenuButton.contains(event.target) &&
            !nav.classList.contains('translate-x-full')) {
            toggleMenu();
        }
    });
</script>

<main class="w-full font-urbanist">
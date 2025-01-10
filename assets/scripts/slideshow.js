console.log(document.querySelector('.cean-slideshow-item'));
if (document.querySelector('.cean-slideshow-item')) {
    let ceanSlideShow = w3.slideshow(".cean-slideshow-item", 5000);

    const leftButton = document.querySelector('.cean-slideshow-left-btn');
    const rightButton = document.querySelector('.cean-slideshow-right-btn');

    if (leftButton) {
        leftButton.addEventListener('click', () => ceanSlideShow.previous());
    }

    if (rightButton) {
        rightButton.addEventListener('click', () => ceanSlideShow.next());
    }

    console.log("slideshow.js loaded");
}


console.log(document.querySelector('.cean-content-swiper'));
if (document.querySelector('.cean-content-swiper')) {
    let swiper = new Swiper(".cean-content-swiper", {
        slidesPerView: 2,
        spaceBetween: 16,
        breakpoints: {
            1024: {
                slidesPerView: 5,
                spaceBetween: 16
            }
        },
        pagination: {
            el: ".cean-content-swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".cean-content-swiper-next",
            prevEl: ".cean-content-swiper-prev",
        }
    });
}

// Swiper Initialization for Hero New Release Swiper
console.log(document.querySelector('.cean-content-hero-new-release-swiper'));
if (document.querySelector('.cean-content-hero-new-release-swiper')) {
    console.log("Hero New Release Swiper");
    let HeroNewReleaseSwiper = new Swiper(".cean-content-hero-new-release-swiper", {
        slidesPerView: 2,
        spaceBetween: 16,
        breakpoints: {
            1024: {
                slidesPerView: 5,
                spaceBetween: 16
            }
        },
        navigation: {
            nextEl: ".cean-content-hero-new-release-swiper-next",
            prevEl: ".cean-content-hero-new-release-swiper-prev",
        },
        scrollbar: {
            el: ".cean-content-hero-new-release-swiper-scrollbar",
            draggable: true,
        },
    });
}


if (document.querySelector('.cean-content-hero-top-movies-swiper')) {
    let HeroNewReleaseSwiper = new Swiper(".cean-content-hero-top-movies-swiper", {
        slidesPerView: 2,
        spaceBetween: 16,
        draggable: true,
        breakpoints: {
            1024: {
                slidesPerView: 5,
                spaceBetween: 16
            }
        },
        navigation: {
            nextEl: ".cean-content-hero-top-movies-swiper-next",
            prevEl: ".cean-content-hero-top-movies-swiper-prev",
        },
        scrollbar: {
            el: ".cean-content-hero-top-movies-swiper-scrollbar",
            draggable: true,
        },
    });
}

console.log(document.querySelector('.cean-content-hero-new-release-swiper'));


// Function to initialize swiper with dynamic suffix
function initializeSwiper(suffix) {
    const swiperSelector = `.cean-content-swiper-${suffix}`;
    const swiperElement = document.querySelector(swiperSelector);

    if (swiperElement) {
        console.log(`Initializing swiper: ${suffix}`);
        return new Swiper(swiperSelector, {
            slidesPerView: 2,
            spaceBetween: 16,
            breakpoints: {
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 16
                }
            },
            pagination: {
                el: `${swiperSelector}-pagination`,
                clickable: true,
            },
            navigation: {
                nextEl: `${swiperSelector}-next`,
                prevEl: `${swiperSelector}-prev`,
            }
        });
    }
    return null;
}

// Initialize different swipers
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Top Grossing Movies Swiper
    initializeSwiper('top-grossing');

    // Initialize New Releases Swiper
    initializeSwiper('new-releases');
});
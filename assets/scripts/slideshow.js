let ceanSlideShow = w3.slideshow(".cean-slideshow-item", 5000);
document.querySelector('.cean-slideshow-left-btn').addEventListener('click', () => ceanSlideShow.previous());
document.querySelector('.cean-slideshow-right-btn').addEventListener('click', () => ceanSlideShow.next());
console.log("slideshow.js loaded");


var swiper = new Swiper(".cean-content-swiper", {
    slidesPerView: 5,
    spaceBetween: 20,
    pagination: {
        el: ".cean-content-swiper-pagination",
        clickable: true,
    },
    navigation : {
        nextEl: ".cean-content-swiper-next",
        prevEl: ".cean-content-swiper-prev",
    }
});


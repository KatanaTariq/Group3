document.addEventListener("DOMContentLoaded", function () {
    const heroBox = document.getElementById("hero-slideshow");

    if (!heroBox) return;

    const heroImages = [
        "/src/view/images/productImages/home_football_jersey.png",
        "/src/view/images/productImages/home_women_joggers.png",
        "/src/view/images/productImages/home_men_boxing_short.png",
        "/src/view/images/productImages/home_men_hoodie.png"
    ];

    let slideIndex = 0;
    let slideInterval;

    // Preload images to prevent lag
    const preloaded = [];
    heroImages.forEach(src => {
        const img = new Image();
        img.src = src;
        img.decode?.().catch(() => {});
        preloaded.push(img);
    });

 
    heroBox.style.backgroundImage = `url(${heroImages[0]})`;

    function startSlideshow() {
        if (slideInterval) return;

        slideInterval = setInterval(() => {
            slideIndex = (slideIndex + 1) % heroImages.length;
            heroBox.style.backgroundImage = `url(${heroImages[slideIndex]})`;
        }, 2500);
    }

    function stopSlideshow() {
        clearInterval(slideInterval);
        slideInterval = null;
    }

    // Auto start slideshow
    startSlideshow();

    // Allow pause on hover
    heroBox.addEventListener("mouseenter", stopSlideshow);
    heroBox.addEventListener("mouseleave", startSlideshow);
});

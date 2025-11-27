document.addEventListener("DOMContentLoaded", function() {
    const heroBox = document.getElementById("hero-slideshow");

    const heroImages = [
        "/images/productImages/homepage/footballjersey.png",
        "/images/productImages/homepage/Bottomsjoggers.png",
        "/images/productImages/homepage/boxingshortmen.png",
        "/images/productImages/homepage/menhoodie.png"
    ];

    heroBox.style.backgroundImage = `url(${heroImages[0]})`;

    let slideIndex = 0;
    let slideInterval;

    function startSlideshow() {
        slideInterval = setInterval(() => {
            slideIndex = (slideIndex + 1) % heroImages.length;
            heroBox.style.backgroundImage = `url(${heroImages[slideIndex]})`;
        }, 1500);
    }

    function stopSlideshow() {
        clearInterval(slideInterval);
    }

    heroBox.addEventListener("mouseenter", startSlideshow);
    heroBox.addEventListener("mouseleave", stopSlideshow);
});

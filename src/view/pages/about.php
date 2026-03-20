<?php
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/nav.php';
?>

<div class="about-hero">
    <h1>About Athletiq</h1>
</div>

<section class="about-info">
    <h2>Performative Wear for Upcoming Sports Enthusiasts</h2>
    <p>
        Over at Athletiq, clothing is created with concept. We've designed and refined
        Sportswear with a Story.
    </p>
    <p>
        Our products are proudly designed by Athletes, putting a meaning behind
        each item built. With dedication, real performance and training, our Athletes know
        what it takes to compete, and that all starts with what they wear.
    </p>
    <p>
        We've collaborated with Sports Enthusiasts, ranging from competitive Sprinters to Elite
        Footballers who have helped us tailor sportswear to reach maximum comfort, enhanced
        flexibility and reduced friction to ensure our Athletiq Champions reach Peak Performance.
    </p>
</section>

<section class="athlete-section">
    <h2>Athletes have designed them so our Athletiqs can wear them.</h2>
    <p>Meet the Athletes and Players who have collaborated and helped build Athletiq Sportswear to what we are today.</p>

    <div class="team-grid">
        <div class="athlete-card">
            <img src="<?= BASE_URL ?>/public/images/productImages/about_us_rugby.png" alt="Rugby Athlete">
            <h3>Jae</h3>
            <p>Professional Rugby Player — Designer of Athletiq’s Protective Rugby Helmet, with ear padding and ventilation holes.</p>
        </div>

        <div class="athlete-card">
            <img src="<?= BASE_URL ?>/public/images/productImages/about_us_running_shoes.png" alt="Runner">
            <h3>Alayaa</h3>
            <p>Competitive Long-distance Runner — Creator of Athletiq’s running shoes with breathable soles.</p>
        </div>

        <div class="athlete-card">
            <img src="<?= BASE_URL ?>/public/images/productImages/about_us_basketball_jersey.png" alt="Basketball Athlete">
            <h3>Miyaz</h3>
            <p>Pro Basketballer — Worked on Athletiq’s Basketball Jersey, lightweight and moisture-wicking.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
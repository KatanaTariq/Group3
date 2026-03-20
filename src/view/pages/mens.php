<?php $title = 'Athletiq | Mens'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="men-title">Men</h1>

<div style="text-align:center; margin: 20px 0;">
    <button class="filter-btn" data-filter="all">All</button>
    <button class="filter-btn" data-filter="hoodies">Hoodies</button>
    <button class="filter-btn" data-filter="tops">Tops</button>
    <button class="filter-btn" data-filter="bottoms">Bottoms</button>
    <button class="filter-btn" data-filter="footwear">Footwear</button>
    <button class="filter-btn" data-filter="headwear">Headwear</button>
</div>

<section class="products-container" id="all-products">

<div class="product-card" data-category="hoodies">
    <img src="/public/images/productImages/male_hoodie_green.png" class="product-img">
    <p class="product-name">Green Athletiq Hoodie</p>
    <p class="product-desc">Lightweight cotton hoodie built for warm-ups and cool-downs.</p>
    <p class="price">£30</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/public/images/productImages/male_hoodie_black.png" class="product-img">
    <p class="product-name">Green & Black Athletiq Hoodie</p>
    <p class="product-desc">Two-tone cotton hoodie with a relaxed fit for training or casual wear.</p>
    <p class="price">£35</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/public/images/productImages/male_hoodie_turtleneck_zipup.png" class="product-img">
    <p class="product-name">Green & Black Zipup Athletiq Turtleneck</p>
    <p class="product-desc">Zip-up turtleneck with added neck coverage for cold weather training.</p>
    <p class="price">£30</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/public/images/productImages/male_hoodie_turtleneck.png" class="product-img">
    <p class="product-name">Green Athletiq Turtleneck</p>
    <p class="product-desc">Warm turtleneck hoodie designed to keep you covered on colder days.</p>
    <p class="price">£30</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/public/images/productImages/male_hoodie_zipup.png" class="product-img">
    <p class="product-name">Green Zip up Athletiq Hoodie</p>
    <p class="product-desc">Classic zip-up hoodie for easy layering before and after a session.</p>
    <p class="price">£30</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/public/images/productImages/male_shirt_polo.png" class="product-img">
    <p class="product-name">Athletiq Polo Tee</p>
    <p class="product-desc">Breathable polo tee suitable for training or casual sport wear.</p>
    <p class="price">£40</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/public/images/productImages/male_shirt_football.png" class="product-img">
    <p class="product-name">Athletiq Football Jersey</p>
    <p class="product-desc">Lightweight jersey designed for full mobility on the pitch.</p>
    <p class="price">£45</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/public/images/productImages/male_shirt_compression.png" class="product-img">
    <p class="product-name">Athletiq Compression Top</p>
    <p class="product-desc">Compression fit top to support muscles during high-intensity workouts.</p>
    <p class="price">£40</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/public/images/productImages/male_shirt_tank.png" class="product-img">
    <p class="product-name">Athletiq Gym Tanktop</p>
    <p class="product-desc">Lightweight tank top built for unrestricted movement in the gym.</p>
    <p class="price">£25</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/public/images/productImages/male_shirt_basketball.png" class="product-img">
    <p class="product-name">Athletiq Basketball Jersey</p>
    <p class="product-desc">Moisture-wicking jersey cut for speed and comfort on the court.</p>
    <p class="price">£45</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/public/images/productImages/male_pants_tennis.png" class="product-img">
    <p class="product-name">Athletiq Tennis Shorts</p>
    <p class="product-desc">Lightweight shorts with a flexible waistband for quick movement on court.</p>
    <p class="price">£32</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/public/images/productImages/male_pants_rugby.png" class="product-img">
    <p class="product-name">Athletiq Rugby Shorts</p>
    <p class="product-desc">Durable shorts built to handle the demands of contact sport.</p>
    <p class="price">£35</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/public/images/productImages/male_pants_swimming.png" class="product-img">
    <p class="product-name">Athletiq Swimming Shorts</p>
    <p class="product-desc">Quick-dry swimming shorts with a secure inner lining.</p>
    <p class="price">£25</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/public/images/productImages/male_joggers.png" class="product-img">
    <p class="product-name">Athletiq Joggers</p>
    <p class="product-desc">Tapered joggers with a comfortable fit for training or everyday wear.</p>
    <p class="price">£50</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/public/images/productImages/male_pants_boxing.png" class="product-img">
    <p class="product-name">Athletiq Boxing Shorts</p>
    <p class="product-desc">Wide-cut shorts for full leg freedom during sparring and bag work.</p>
    <p class="price">£30</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/public/images/productImages/male_shoes_mountaineering.png" class="product-img">
    <p class="product-name">Mens Mountaineering Boots</p>
    <p class="product-desc">Sturdy boots with ankle support and grip for rugged terrain.</p>
    <p class="price">£85</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/public/images/productImages/male_shoes_flipflops.png" class="product-img">
    <p class="product-name">Mens Flip Flops</p>
    <p class="product-desc">Lightweight slip-ons ideal for poolside or post-training recovery.</p>
    <p class="price">£20</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/public/images/productImages/male_shoes_running.png" class="product-img">
    <p class="product-name">Mens Running Shoes</p>
    <p class="product-desc">Cushioned running shoes built for long-distance comfort and support.</p>
    <p class="price">£80</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/public/images/productImages/male_shoes_trainers.png" class="product-img">
    <p class="product-name">Mens Trainers</p>
    <p class="product-desc">Versatile trainers suitable for gym sessions and everyday use.</p>
    <p class="price">£90</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/public/images/productImages/male_shoes_studs.png" class="product-img">
    <p class="product-name">Mens Football Boots</p>
    <p class="product-desc">Studded boots designed for traction and control on grass pitches.</p>
    <p class="price">£85</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/public/images/productImages/male_hat_visor.png" class="product-img">
    <p class="product-name">Athletiq Visor</p>
    <p class="product-desc">Open-top visor to keep the sun out without trapping heat.</p>
    <p class="price">£25</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/public/images/productImages/male_hat_sweatband.png" class="product-img">
    <p class="product-name">Athletiq Sweatband</p>
    <p class="product-desc">Moisture-absorbing sweatband to keep sweat away during intense sessions.</p>
    <p class="price">£15</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/public/images/productImages/male_hat_rugby.png" class="product-img">
    <p class="product-name">Athletiq Rugby Helmet</p>
    <p class="product-desc">Padded helmet offering head protection without restricting vision.</p>
    <p class="price">£75</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/public/images/productImages/male_hat_baseball.png" class="product-img">
    <p class="product-name">Athletiq Baseball Cap</p>
    <p class="product-desc">Adjustable cap with a structured brim for training or casual wear.</p>
    <p class="price">£35</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/public/images/productImages/male_hat_swimming.png" class="product-img">
    <p class="product-name">Athletiq Swimcap</p>
    <p class="product-desc">Silicone swimcap to reduce drag and protect hair in the pool.</p>
    <p class="price">£10</p>
    <select required>
        <option value="" disabled selected>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

</section>

<script src="/public/js/mens.js"></script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
<?php $title = 'Athletiq | Womens'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="women-title">Women</h1>

<div style="text-align:center; margin: 20px 0;">
    <button class="filter-btn" data-filter="all">All</button>
    <button class="filter-btn" data-filter="hoodies">Hoodies</button>
    <button class="filter-btn" data-filter="tops">Tops</button>
    <button class="filter-btn" data-filter="bottoms">Bottoms</button>
    <button class="filter-btn" data-filter="footwear">Footwear</button>
    <button class="filter-btn" data-filter="headwear">Headwear</button>
</div>

<section class="products-container" id="all-products">

<?php
// women subcategory ids:
$categoryMap = [
    3 => 'hoodies',
    4 => 'tops',
    5 => 'bottoms',
    6 => 'footwear',
    7 => 'headwear',
];

function normaliseImagePath(?string $path): string
{
    if (!$path) {
        return '/public/images/productImages/placeholder.png';
    }

    if (strpos($path, '/src/view/images/') === 0) {
        return str_replace('/src/view/images/', '/public/images/', $path);
    }

    return $path;
}
?>

<?php if (empty($products ?? [])): ?>
    <p style="text-align:center;">No products found.</p>
<?php else: ?>
    <?php foreach ($products as $product): ?>
        <?php
            $categoryId = $product->getCategoryID();
            $filterCategory = $categoryMap[$categoryId] ?? 'all';

            $img = normaliseImagePath($product->getPrimaryImageUrl());
        ?>

        <div class="product-card" data-category="<?php echo htmlspecialchars($filterCategory); ?>">
            <img
                src="<?php echo htmlspecialchars($img); ?>"
                class="product-img"
                alt="<?php echo htmlspecialchars($product->getName()); ?>"
            >

            <p class="product-name"><?php echo htmlspecialchars($product->getName()); ?></p>
            <p class="price">£<?php echo number_format($product->getPrice(), 2); ?></p>

            <select required>
                <option value="" disabled selected>Select Size</option>

                <?php if ($filterCategory === 'footwear'): ?>
                    <option>3</option><option>4</option><option>5</option>
                    <option>6</option><option>7</option><option>8</option><option>9</option>
                <?php else: ?>
                    <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
                <?php endif; ?>
            </select><br>

            <button class="add-btn" data-product-id="<?php echo (int)$product->getID(); ?>">
                Add to Basket
            </button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</section>

<script src="/public/js/womens.js"></script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
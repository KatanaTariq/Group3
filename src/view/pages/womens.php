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
// Women subcategory IDs:
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
            <a href="/product?id=<?php echo (int)$product->getID(); ?>" class="product-link">
                <img
                    src="<?php echo htmlspecialchars($img); ?>"
                    class="product-img"
                    alt="<?php echo htmlspecialchars($product->getName()); ?>"
                >

                <p class="product-name"><?php echo htmlspecialchars($product->getName()); ?></p>

                <p class="product-desc">
                    <?php echo htmlspecialchars($product->getDescription() ?: 'No description available.'); ?>
                </p>

                <p class="price">£<?php echo number_format($product->getPrice(), 2); ?></p>
            </a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</section>

<script src="/public/js/womens.js"></script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
<?php $title = 'Athletiq | Search'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<?php
function normaliseSearchImagePath(?string $path): string
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

<div class="search-page">

    <div class="search-header">
        <h1 class="search-title">Search Results</h1>

        <?php if (!empty($search ?? '')): ?>
            <p class="search-subtitle">
                Showing results for
                "<strong><?php echo htmlspecialchars($search); ?></strong>"
            </p>
        <?php else: ?>
            <p class="search-subtitle">Type a product name into the search bar to begin.</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($search ?? '') && empty($products ?? [])): ?>
        <div class="search-empty">
            <p>No products found for that search.</p>
        </div>

    <?php elseif (!empty($products ?? [])): ?>
        <div class="search-results-wrap">
            <div class="search-results-table">

                <div class="search-results-head">
                    <div>Product</div>
                    <div>Price</div>
                    <div>View</div>
                </div>

                <?php foreach ($products as $product): ?>
                    <?php $image = normaliseSearchImagePath($product->getPrimaryImageUrl()); ?>

                    <div class="search-result-row">
                        <div class="search-product-info">
                            <a
                                class="search-product-link"
                                href="/product?id=<?php echo (int) $product->getID(); ?>"
                            >
                                <img
                                    class="search-product-image"
                                    src="<?php echo htmlspecialchars($image); ?>"
                                    alt="<?php echo htmlspecialchars($product->getName()); ?>"
                                >

                                <div class="search-product-text">
                                    <h3><?php echo htmlspecialchars($product->getName()); ?></h3>
                                </div>
                            </a>
                        </div>

                        <div class="search-price">
                            £<?php echo number_format((float) $product->getPrice(), 2); ?>
                        </div>

                        <div class="search-action">
                            <a
                                class="view-product-btn"
                                href="/product?id=<?php echo (int) $product->getID(); ?>"
                            >
                                View Product
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
<?php $title = 'Athletiq | ' . htmlspecialchars($product->getName()); ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<?php
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

$img = normaliseImagePath($product->getPrimaryImageUrl());
$variants = is_array($variants ?? null) ? $variants : [];

$availableSizes = [];

foreach ($variants as $variant) {
    $size = $variant->getSize();

    if ($size !== null && trim($size) !== '') {
        $availableSizes[] = trim($size);
    }
}

$availableSizes = array_values(array_unique($availableSizes));

usort($availableSizes, function ($a, $b) {
    $clothingOrder = ['XS' => 1, 'S' => 2, 'M' => 3, 'L' => 4, 'XL' => 5, 'XXL' => 6];

    $aIsNumeric = is_numeric($a);
    $bIsNumeric = is_numeric($b);

    if ($aIsNumeric && $bIsNumeric) {
        return (int)$a <=> (int)$b;
    }

    if (!$aIsNumeric && !$bIsNumeric) {
        return ($clothingOrder[strtoupper($a)] ?? 999) <=> ($clothingOrder[strtoupper($b)] ?? 999);
    }

    return $aIsNumeric ? 1 : -1;
});
?>

<section class="single-product-page">
    <div class="single-product-container">
        <div class="single-product-gallery">
            <div class="single-product-image-card">
                <img
                    src="<?php echo htmlspecialchars($img); ?>"
                    alt="<?php echo htmlspecialchars($product->getName()); ?>"
                    class="single-product-main-image"
                >
            </div>
        </div>

        <div class="single-product-details">
            <p class="single-product-eyebrow">Athletiq</p>

            <h1><?php echo htmlspecialchars($product->getName()); ?></h1>

            <p class="price">£<?php echo number_format($product->getPrice(), 2); ?></p>

            <p class="product-description">
                <?php echo nl2br(htmlspecialchars($product->getDescription() ?: 'No description available.')); ?>
            </p>

            <?php if (count($availableSizes) > 0): ?>
                <form action="/basket/add" method="POST" class="single-product-form">
                    <input type="hidden" name="product_id" value="<?php echo (int)$product->getID(); ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(get_csrf_token()); ?>">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="size">Size</label>
                            <select name="size" id="size" required>
                                <option value="" disabled selected>Select size</option>
                                <?php foreach ($availableSizes as $availableSize): ?>
                                    <option value="<?php echo htmlspecialchars($availableSize); ?>">
                                        <?php echo htmlspecialchars($availableSize); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group quantity-group">
                            <label for="quantity">Quantity</label>
                            <input
                                type="number"
                                name="quantity"
                                id="quantity"
                                value="1"
                                min="1"
                                required
                            >
                        </div>
                    </div>

                    <button type="submit" class="add-btn">Add to Basket</button>
                </form>
            <?php else: ?>
                <div class="stock-badge stock-out">Out of stock</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
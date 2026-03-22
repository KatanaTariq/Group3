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
?>

<section class="single-product-container">
    <div class="single-product-image">
        <img
            src="<?php echo htmlspecialchars($img); ?>"
            alt="<?php echo htmlspecialchars($product->getName()); ?>"
        >
    </div>

    <div class="single-product-details">
        <h1><?php echo htmlspecialchars($product->getName()); ?></h1>

        <p class="product-description">
            <?php echo htmlspecialchars($product->getDescription() ?: 'No description available.'); ?>
        </p>

        <p class="price">
            £<?php echo number_format($product->getPrice(), 2); ?>
        </p>

        <?php
        $availableSizes = [];

        foreach ($variants as $variant) {
            $size = $variant->getSize();

            if ($size !== null && $size !== '') {
                $availableSizes[] = trim($size);
            }
        }

        $availableSizes = array_values(array_unique($availableSizes));

        usort($availableSizes, function ($a, $b) {
            $clothingOrder = ['XS' => 1, 'S' => 2, 'M' => 3, 'L' => 4, 'XL' => 5];

            $aIsNumeric = is_numeric($a);
            $bIsNumeric = is_numeric($b);

            if ($aIsNumeric && $bIsNumeric) {
                return (int)$a <=> (int)$b;
            }

            if (!$aIsNumeric && !$bIsNumeric) {
                return ($clothingOrder[$a] ?? 999) <=> ($clothingOrder[$b] ?? 999);
            }

            return $aIsNumeric ? 1 : -1;
        });
        ?>

        <?php if (count($availableSizes) > 0): ?>
            <form action="/basket/add" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                <label for="size">Select Size</label>
                <select name="size" id="size" required>
                    <option value="" disabled selected>Select Size</option>

                    <?php foreach ($availableSizes as $size): ?>
                        <option value="<?php echo htmlspecialchars($size); ?>">
                            <?php echo htmlspecialchars($size); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <br><br>

                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1">

                <br><br>

                <button type="submit" class="add-btn">Add to Basket</button>
            </form>
        <?php else: ?>
            <p>Out of stock.</p>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
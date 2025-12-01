function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    products.forEach(product => {
        if (category === 'all' || product.getAttribute('data-category') === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

const addButtons = document.querySelectorAll('.add-btn');

addButtons.forEach(button => {
    button.addEventListener('click', () => {
        const productCard = button.closest('.product-card');
        const name = productCard.querySelector('.product-name').innerText;
        const price = parseFloat(productCard.querySelector('.price').innerText.replace('£',''));
        const img = productCard.querySelector('.product-img').src;
        const sizeSelect = productCard.querySelector('select');
        const size = sizeSelect.value;

        if (!size) {
            alert('Please select a size before adding to basket.');
            return;
        }

        const basket = JSON.parse(localStorage.getItem('basket')) || [];

        basket.push({ name, price, img, size });

        localStorage.setItem('basket', JSON.stringify(basket));

        alert(`${name} (Size: ${size}) has been added to your basket!`);
    });
});

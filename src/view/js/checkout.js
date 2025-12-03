const checkoutContainer = document.getElementById('checkout-items');
const checkoutTotal = document.getElementById('checkout-total');

function loadCheckout() {
    const basket = JSON.parse(localStorage.getItem('basket')) || [];
    checkoutContainer.innerHTML = '';
    let total = 0;

    if (basket.length === 0) {
        checkoutContainer.innerHTML = '<p style="text-align:center; font-weight:bold; margin:20px 0;">Your basket is empty</p>';
    }

    basket.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('checkout-item');
        itemDiv.innerHTML = `
            <img src="${item.img}" alt="${item.name}">
            <div class="item-info">
                <p>${item.name}</p>
                <p>Size: ${item.size}</p>
            </div>
            <p class="item-price">£${item.price.toFixed(2)}</p>
        `;
        checkoutContainer.appendChild(itemDiv);
        total += item.price;
    });

    checkoutTotal.innerText = total.toFixed(2);
}

loadCheckout();


document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Order successfull! Thank you for shopping at Athletiq!');
    localStorage.removeItem('basket');
    window.location.href = '/index';
});

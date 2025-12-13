const checkoutContainer = document.getElementById('checkout-items');
const checkoutTotal = document.getElementById('checkout-total');
const paymentForm = document.getElementById('payment-form');

function loadCheckout() {
    const basket = JSON.parse(localStorage.getItem('basket')) || [];
    checkoutContainer.innerHTML = '';
    let total = 0;

    if (basket.length === 0) {
        checkoutContainer.innerHTML = '<p style="text-align:center; font-weight:bold; margin:20px 0;">Your basket is empty</p>';
        return;
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

if (paymentForm) {
    paymentForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const card = document.getElementById('card').value.replace(/\s+/g, '');
        const expiry = document.getElementById('expiry').value.trim();
        const cvv = document.getElementById('cvv').value.trim();

        if (!/^[a-zA-Z ]{2,}$/.test(name)) {
            alert("Please enter a valid full name.");
            return;
        }

        if (!/^\S+@\S+\.\S+$/.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        if (!/^\d{16}$/.test(card)) {
            alert("Card number must be 16 digits.");
            return;
        }

        if (!/^\d{2}\/\d{2}$/.test(expiry)) {
            alert("Expiry date must be in MM/YY format.");
            return;
        }

        const [month, year] = expiry.split('/').map(Number);
        if (month < 1 || month > 12) {
            alert("Invalid expiry month.");
            return;
        }

        if (!/^\d{3}$/.test(cvv)) {
            alert("CVV must be exactly 3 digits.");
            return;
        }

        alert("Order successful! Thank you for shopping at Athletiq!");
        localStorage.removeItem('basket');
        window.location.href = '/home';
    });
}

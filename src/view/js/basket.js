const basketContainer = document.getElementById('basket-items');
const basketTotal = document.getElementById('basket-total');
const checkoutBtn = document.querySelector('.checkout-btn');

function loadBasket() {
    const basket = JSON.parse(localStorage.getItem('basket')) || [];
    basketContainer.innerHTML = '';
    let total = 0;

    if (basket.length === 0) {
        basketContainer.innerHTML = '<p id="empty-message">Your basket is empty</p>';
        checkoutBtn.disabled = true;
        checkoutBtn.style.opacity = 0.5;
    } else {
        checkoutBtn.disabled = false;
        checkoutBtn.style.opacity = 1;
    }

    basket.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('basket-item');
        itemDiv.innerHTML = `
            <img src="${item.img}" alt="${item.name}">
            <div class="item-info">
                <p>${item.name}</p>
                <p>Size: ${item.size}</p>
            </div>
            <p class="item-price">£${item.price.toFixed(2)}</p>
            <button class="remove-btn" data-index="${index}">Remove</button>
        `;
        basketContainer.appendChild(itemDiv);
        total += item.price;
    });

    basketTotal.innerText = total.toFixed(2);

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const index = btn.getAttribute('data-index');
            basket.splice(index, 1);
            localStorage.setItem('basket', JSON.stringify(basket));
            loadBasket();
        });
    });
}

loadBasket();

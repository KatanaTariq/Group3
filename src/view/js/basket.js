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
        if (!item.quantity) item.quantity = 1;

        const itemDiv = document.createElement('div');
        itemDiv.classList.add('basket-item');
        itemDiv.innerHTML = `
            <img src="${item.img}" alt="${item.name}">
            
            <div class="item-info">
                <p>${item.name}</p>
                <p>Size: ${item.size}</p>
            </div>

            <p class="item-price">£${item.price.toFixed(2)}</p>

            <div class="quantity-control">
                <button class="quantity-btn decrease" data-index="${index}">-</button>
                <input type="number" class="quantity-input" min="1" value="${item.quantity}" data-index="${index}">
                <button class="quantity-btn increase" data-index="${index}">+</button>
            </div>

            <p class="item-subtotal">£${(item.price * item.quantity).toFixed(2)}</p>

            <button class="remove-btn" data-index="${index}">Remove</button>
        `;

        basketContainer.appendChild(itemDiv);

        total += item.price * item.quantity;
    });

    basketTotal.innerText = total.toFixed(2);

    updateButtons();
}

function updateButtons(){
    const basket = JSON.parse(localStorage.getItem('basket')) || [];

    document.querySelectorAll('.increase').forEach(btn => {
        btn.onclick = () => {
            const i = btn.dataset.index;
            basket[i].quantity++;
            localStorage.setItem('basket', JSON.stringify(basket));
            loadBasket();
        };
    });

    document.querySelectorAll('.decrease').forEach(btn => {
        btn.onclick = () => {
            const i = btn.dataset.index;
            if (basket[i].quantity > 1){
                basket[i].quantity--;
            }
            localStorage.setItem('basket', JSON.stringify(basket));
            loadBasket();
        };
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.onchange = () => {
            const i = input.dataset.index;
            basket[i].quantity = Math.max(1, parseInt(input.value)); // Minimum 1
            localStorage.setItem('basket', JSON.stringify(basket));
            loadBasket();
        };
    });

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.onclick = () => {
            const i = btn.dataset.index;
            basket.splice(i, 1);
            localStorage.setItem('basket', JSON.stringify(basket));
            loadBasket();
        };
    });
}

loadBasket();

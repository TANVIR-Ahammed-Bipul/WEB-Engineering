let cartItems = [];

const cartCountDisplay = document.querySelector('.cart-icon sub');
const cartIcon = document.querySelector('.cart-icon');
const cartButtons = document.querySelectorAll('.cart-btn');
const modal = document.getElementById('cart-modal');
const cartList = document.getElementById('cart-list');
const totalValue = document.getElementById('total-value');
const closeBtn = document.querySelector('.close-btn');
const clearCartBtn = document.getElementById('clear-cart');
const placeOrderBtn = document.getElementById('place-order');
const toast = document.getElementById('toast');

function updateCartCount() {
    const totalQty = cartItems.reduce((sum, item) => sum + item.qty, 0);
    cartCountDisplay.textContent = totalQty;
}

function updateTotalPrice() {
    const total = cartItems.reduce((sum, item) => {
        return sum + parseFloat(item.price.replace('$', '')) * item.qty;
    }, 0);
    totalValue.textContent = total.toFixed(2);
}

function showToast(message = "Item added to cart!") {
    toast.textContent = message;
    toast.classList.add("show");
    setTimeout(() => {
        toast.classList.remove("show");
    }, 2000);
}

function renderCartItems() {
    cartList.innerHTML = "";
    cartItems.forEach((item, index) => {
        const div = document.createElement('div');
        div.classList.add('cart-item');

        div.innerHTML = `
            <span class="cart-item-name">${item.name} - ${item.price}</span>
            <div class="cart-item-qty">
                <button class="qty-btn decrease" data-index="${index}">−</button>
                <span>${item.qty}</span>
                <button class="qty-btn increase" data-index="${index}">+</button>
            </div>
        `;
        cartList.appendChild(div);
    });

    updateTotalPrice();
    attachQtyButtonListeners();
}

function attachQtyButtonListeners() {
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', () => {
            const index = btn.dataset.index;
            cartItems[index].qty++;
            updateCartCount();
            renderCartItems();
        });
    });

    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', () => {
            const index = btn.dataset.index;
            cartItems[index].qty--;
            if (cartItems[index].qty <= 0) {
                cartItems.splice(index, 1);
            }
            updateCartCount();
            renderCartItems();
        });
    });
}


cartButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
        const product = btn.closest('.product');
        const name = product.querySelector('h3').innerText;
        const price = product.querySelector('.new-price').innerText;

        const existing = cartItems.find(item => item.name === name);
        if (existing) {
            existing.qty++;
        } else {
            cartItems.push({ name, price, qty: 1 });
        }

        updateCartCount();
        showToast();
    });
});


cartIcon.addEventListener('click', () => {
    if (cartItems.length === 0) {
        alert("Your cart is empty!");
        return;
    }
    renderCartItems();
    modal.style.display = "block";
});


closeBtn.addEventListener('click', () => {
    modal.style.display = "none";
});

// Clear cart
clearCartBtn.addEventListener('click', () => {
    cartItems = [];
    updateCartCount();
    renderCartItems();
    modal.style.display = "none";
    showToast("Cart cleared!");
});


placeOrderBtn.addEventListener('click', () => {
    if (cartItems.length === 0) {
        showToast("Cart is empty!");
        return;
    }

    modal.style.display = "none";
    alert("✅ Order placed successfully!\nThank you for shopping.");
    cartItems = [];
    updateCartCount();
    renderCartItems();
});

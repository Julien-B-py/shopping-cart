// Store selects and items in arrays to detect value changes and update total price
const quantities = document.querySelectorAll("select");
const items = document.querySelectorAll(".basket__item");
// Store span containing total price to update its value
const totalPrice = document.querySelector(".total__block__sub__price");

// Updates total price value
const updatePrice = () => {
    let total = 0;
    // Loop through each basket item
    items.forEach(item => {
        // Get item quantity
        const quantity = item.querySelector("select").value;
        // Get item price : remove whitespaces, € symbol and turn the value into a number
        const price = Number(item.querySelector(".basket__item__price").textContent.trim().replace('€', ''));
        // Add product to total
        total += quantity * price;
    });
    // Change subtotal price text with calculated value
    // Round the result to 2 decimals
    totalPrice.textContent = `${total.toFixed(2)}€`;
}

// When an item quantity is changed
quantities.forEach(quantity => {
    quantity.addEventListener("change", function () {
        // Update total price
        updatePrice();
    });
});

// Call updatePrice function at least one time
updatePrice();
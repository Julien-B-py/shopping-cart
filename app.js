const quantities = document.querySelectorAll("select");
const items = document.querySelectorAll(".basket__item");
const totalPrice = document.querySelector(".total__block__sub__price");

const updatePrice = () => {
    let total = 0;
    items.forEach(item => {
        const quantity = item.querySelector("select").value;
        const price = Number(item.querySelector(".basket__item__price").textContent.trim().replace('€', ''));
        total += quantity * price;
    });
    totalPrice.textContent = `${total.toFixed(2)}€`;
}


// When an item quantity is changed
quantities.forEach(quantity => {
    quantity.addEventListener("change", function () {
        // Update total price
        updatePrice();
    });
});

// // Preset select values
// quantities.forEach(quantity => {
//     const options = quantity.querySelectorAll("option");
//     options.forEach((option, index) => {
//         if (option.getAttribute("selected") === "") {
//             quantity.value = index;
//             option.removeAttribute("selected");
//         }
//     })
// });

updatePrice();
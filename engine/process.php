<?php
// If user submit the form by clicking the button
if ($_SERVER['REQUEST_METHOD'] === 'POST') :

    // Keep track of quantities set by the user for each item in the cart
    for ($i = 0; $i < count($items); $i++) {
        $items[$i]["quantity"] = intval(htmlspecialchars($_POST["item$i"]));
    }

    // Make sure the form was submitted using the submit button
    // Otherwise stop the script and return a message
    if (!isset($_POST['applyCode'])) {
        echo "<p>Please submit form using the button</p>";
        return;
    }

    // Retrieve promo code typed by the user
    // htmlspecialchars to prevent XSS attacks
    // trim to remove any whitespace
    $promoCode = trim(htmlspecialchars($_POST['promoCode']));

    // Check if the promo code submitted by the user is in promoCodes array
    if (!in_array($promoCode, $promoCodes)) {
        // If not set an error message
        $errorMessage = "Le code saisi est invalide.";
    } else {
        // If promo code is valid
        $total = 0;
        // Calc cart's total price
        foreach ($items as $item) {
            $total += $item["quantity"] * $item["price"];
        }

        // Depending on which code was used we want to offer different discounts
        switch ($promoCode) {
            case "NOUNOURS10":
                // Set success message
                $successMessage = "-10%";
                // Calc the discount based on total price and round it to 2 decimals
                $discount = number_format($total * 0.1, 2);
                break;
            case "TROP_BIEN":
                $successMessage = "-30%";
                $discount = number_format($total * 0.3, 2);
                break;
            case "MAIS_LE_PERE_NOEL_EXISTE":
                // Set success message
                $successMessage = "-75% sur l'article le moins cher";

                // Sort items from less to most expensive
                $prices = array_column($items, 'price');
                array_multisort($prices, SORT_ASC, $items);

                // Get the first item in the cart which quantity is not 0
                foreach ($items as $item) {
                    if ($item["quantity"] !== 0) {
                        // Calc the discount based this specific article price and round it to 2 decimals
                        $discount = number_format($item['price'] * 0.75, 2);
                        break;
                    }
                }

                break;
        }
    }

endif;

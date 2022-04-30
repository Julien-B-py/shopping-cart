<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') :

    for ($i = 0; $i < count($items); $i++) {
        $items[$i]["quantity"] = intval($_POST["item$i"]);
    }


    if (!isset($_POST['applyCode'])) {
        echo "<p>Please submit form using the button</p>";
        return;
    }

    $promoCode = trim(htmlspecialchars($_POST['promoCode']));

    if (!in_array($promoCode, $promoCodes)) {
        $errorMessage = "Le code saisi est invalide.";
    } else {

        $total = 0;
        foreach ($items as $item) {
            $total += $item["quantity"] * $item["price"];
        }

        switch ($promoCode) {
            case "NOUNOURS10":
                $successMessage = "-10%";
                $discount = number_format($total * 0.1, 2);
                break;
            case "TROP_BIEN":
                $successMessage = "-30%";
                $discount = number_format($total * 0.3, 2);
                break;
            case "MAIS_LE_PERE_NOEL_EXISTE":
                $successMessage = "-75% sur l'article le moins cher";

                // les objets sont filtrés du moins cher au plus cher
                $prices = array_column($items, 'price');
                array_multisort($prices, SORT_ASC, $items);

                foreach ($items as $item) {
                    if ($item["quantity"] !== 0) {
                        $discount = number_format($item['price'] * 0.75, 2);
                        break;
                    }
                }

                break;
        }
    }

endif;

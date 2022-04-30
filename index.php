<?php

$items = [
    [
        "description" => "Carte mère MSI B550-A Pro ATX - Socket AM4",
        "price" => 101.99,
        "image" => "01.jpg",
        "quantity" => 1
    ],
    [
        "description" => "Imprimante jet d'encre multifonctions HP DeskJet 2721e - WiFi + 6 mois de forfait d'impression Instant Ink",
        "price" => 49.99,
        "image" => "02.jpg",
        "quantity" => 1
    ],
    [
        "description" => "PC Portable 15.6' Lenovo IdeaPad 3 15ALC6 - Full HD, Ryzen 3 5300U, RAM 8 Go, SSD 128 Go, Windows 11",
        "price" => 424.99,
        "image" => "03.jpg",
        "quantity" => 1
    ],
];

$promoCodes = [
    "NOUNOURS10",
    "TROP_BIEN",
    "MAIS_LE_PERE_NOEL_EXISTE"
];

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
        $errorMessage = "Le code promo $promoCode est invalide.";
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <form method="POST">
        <h1>Mon panier</h1>
        <div class="basket">
            <div class="basket__items">

                <?php foreach ($items as $item) : ?>
                    <div class="basket__item">

                        <div class="basket__item__image">
                            <img src="<?= $item["image"] ?>" alt="">
                        </div>

                        <div class="basket__item__right">
                            <div class="basket__item__right__top">
                                <div class="basket__item__text">
                                    <?= $item["description"] ?>
                                </div>
                                <div class="basket__item__price">
                                    <?= $item["price"] ?>€
                                </div>
                            </div>


                            <div class="basket__item__quantity">
                                <p>Quantité</p>
                                <select name="<?= "item" . array_search($item, $items) ?>">

                                    <?php for ($i = 0; $i < 11; $i++) : ?>
                                        <option value=<?= $i ?> <?= ($i === $item["quantity"]) ? "selected" : "" ?>><?= $i ?></option>
                                    <?php endfor; ?>

                                </select>
                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

            <div class="total">
                <h2>Total</h2>
                <div class="total__block">
                    <div class="total__block__sub">
                        <span>Sous-total</span><span class="total__block__sub__price"></span>
                    </div>

                    <?php if (isset($discount)) : ?>
                        <div class="total__block__sub">
                            <span>Réductions</span><span>- <?= $discount ?>€</span>
                        </div>
                        <div class="total__block__sub">
                            <span>Total</span><span><?= $total - $discount ?>€</span>
                        </div>
                    <?php endif;  ?>

                    <?php if (!isset($successMessage)) : ?>
                        <input type="text" name="promoCode" placeholder="Entrez un code promo" required>
                    <?php endif;  ?>

                    <?php if (isset($errorMessage))  echo $errorMessage; ?>
                    <?php if (isset($successMessage)) : ?>
                        <p>Code promo : <?= $promoCode ?> (<?= $successMessage ?>)</p>
                    <?php endif;  ?>

                    <?php if (!isset($successMessage)) : ?>
                        <input type="submit" name="applyCode" value="Appliquer le code promo">
                    <?php endif;  ?>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>
    <script src="app.js"></script>

</body>

</html>
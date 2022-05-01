<?php

require_once("./_includes/data.php");
require_once("./engine/process.php");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>

    <form method="POST">
        <h1></i>Mon panier</h1>
        <div class="basket">
            <div class="basket__items">

                <?php foreach ($items as $item) : // For each item in items array => create a basket__item div 
                ?>
                    <div class="basket__item">

                        <div class="basket__item__image">
                            <img src="./assets/images/<?= $item["image"] ?>" alt="<?= $item["shortDesc"] ?>">
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
                                <select name="<?= "item" . array_search($item, $items) // Give to the select a name based on current item index 
                                                ?>">

                                    <?php for ($i = 0; $i < 11; $i++) : ?>
                                        <option value=<?= $i ?> <?= ($i === $item["quantity"]) ? "selected" : "" // Give to the select a default selected value based on current item quantity 
                                                                ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>

                                </select>
                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

            <div class="total">

                <div class="total__block">
                    <div class="total__block__sub">
                        <span>Sous-total</span><span class="total__block__sub__price"></span>
                    </div>

                    <?php if (isset($discount)) : // If discount variable is set it means a correct promo code has been used 
                    ?>
                        <div class="total__block__sub">
                            <span>Total remise(s)</span><span>- <?= $discount ?>€</span>
                        </div>
                        <div class="total__block__sub border__top">
                            <span>Total</span><span><?= $total - $discount ?>€</span>
                        </div>
                    <?php endif;  ?>

                    <?php if (!isset($successMessage)) : // If a promo code has been used successfully we hide the promo code input 
                    ?>
                        <input type="text" name="promoCode" placeholder="Entrez un code promo" required>
                    <?php endif;  ?>

                    <?php if (isset($errorMessage))  echo "<p class='error'>$errorMessage</p>"; // If an incorrect code has been used 
                    ?>
                    <?php if (isset($successMessage)) : // If a orrect code has been used 
                    ?>
                        <p class="success">Votre code <b><?= $promoCode ?></b> (<?= $successMessage ?>) a bien été appliqué</p>
                    <?php endif;  ?>

                    <?php if (!isset($successMessage)) : // If a promo code has been used successfully we hide the submit button 
                    ?>
                        <input type="submit" name="applyCode" value="Appliquer le code promo">
                    <?php endif;  ?>
                </div>
            </div>
        </div>
    </form>

    <script src="./assets/js/app.js"></script>

</body>

</html>
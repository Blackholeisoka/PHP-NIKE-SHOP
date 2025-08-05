<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier Nike</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./style/bag-shop.css">
</head>
<body>
    <div class="container">
        <div>
        <div class="membership-banner">
            <h1>Livraison gratuite pour les membres.</h1>
            <p>Deviens membre Nike pour profiter de livraisons rapides et gratuites. <a href="#">Rejoins-nous</a> ou <a href="#">S'identifier</a></p>
        </div>
        <a href="./index.php" style="cursor: pointer; text-decoration: none; color: black;"><i class="fa-solid fa-chevron-left"></i> Retour</a>
        <h2 style="margin-top: 0;">Votre panier d'achats</h2>
        <?php  
            $bag_input = file_get_contents('./product/bag.json');
            $shoes_input = file_get_contents('./product/shoes.json');
            $bag_data = json_decode($bag_input, true);
            $shoes_data = json_decode($shoes_input, true);
            $bag_count = count($bag_data);
            for($i = 0; $i < count($bag_data); $i++){
                $shoes_index = $bag_data[$i]['shoes_index'];
                $color_index = $bag_data[$i]['color_index'];
                $count = isset($bag_data[$i]['quantity']) ? $bag_data[$i]['quantity'] : 1;
                $size = $bag_data[$i]['size_value'];
                $shoes = $shoes_data['shoes'][$shoes_index];
            ?>
        <div class="cart-item" data-id="<?php echo $i ?>" data-price="<?php echo $shoes['price'][$color_index] ?>">
            <div class="product-image">
                <img src="<?php echo $shoes['images'][$color_index][0] ?>" alt="Nike Air Pegasus Wave">
            </div>
            <div class="product-details">
                <div class="product-name"><?php echo $shoes['name'] ?></div>
                <div class="product-category"><?php echo $shoes['section'] ?></div>
                <div class="product-color"><?php echo $shoes['color'][$color_index] ?></div>
                <div class="product-size">Taille / Pointure <?php echo $size ?></div>
                <div class="product-actions">
                    <div class="quantity-selector">
                        <button class="quantity-btn">-</button>
                        <input type="number" name="quantity-input" class="quantity-input" min="1" value="<?php echo $count ?>" max="10">
                        <button class="quantity-btn">+</button>
                    </div>
                    <button class="remove-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div>
        <div class="summary">
            <h2>Récapitulatif</h2>
            
            <div class="promo-code">
                <p>As-tu un code promo ?</p>
            </div>
            
            <div class="price-row">
                <span>Sous-total</span>
                <span>--</span>
            </div>
            <div class="price-details">
            <?php
            $total = 0;
            for($i = 0; $i < count($bag_data); $i++){
                $shoes_index = $bag_data[$i]['shoes_index'];
                $color_index = $bag_data[$i]['color_index'];
                $count = isset($bag_data[$i]['quantity']) ? $bag_data[$i]['quantity'] : 1;
                $shoes = $shoes_data['shoes'][$shoes_index];
                
                $price = $shoes['price'][$color_index];
                $total += $price * $count;
            ?>
                <div class="price-row">
                    <span><?php echo $shoes['name'] ?><?php echo ($count > 1) ? '(x' . $count .')' : ''; ?></span>
                    <span><?php echo $price * $count ?> €</span>
                </div>
            <?php } ?>
            </div>
            <div class="price-row">
                <span>Frais estimés de prise en charge et d'expédition</span>
                <span>gratuit</span>
            </div>
            <div class="price-row total-row">
                <span>Total</span>
                <span><?php echo $total ?> €</span>
            </div>
            <div>
                <button class="checkout-btn <?= $bag_count === 0 ? 'disabled-button' : '' ?>">Passer la commande</button>
            </div>
        </div>
    </div>
</body>
<script src="./script/bag-shop.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</html>
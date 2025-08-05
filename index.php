<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/style.css" />
    <title>Home</title>
</head>
<body>
<header>
    <a href="./bag-shop.php" class="shopping-bag">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if (isset($_SESSION['bag_count'])) { ?>
            <span class="counter-shop"><?php echo $_SESSION['bag_count'] ?></span>
        <?php } ?>
    </a>
</header>
<main>
    <?php
    $json = file_get_contents('http://localhost/ML%20Algo/product/shoes.json');
    $data = json_decode($json, true);

    for ($i = 0; $i < count($data['shoes']); $i++) {
        $shoe = $data['shoes'][$i];
        ?>
        <div class="container_card">
            <img class="main-image" src="<?php echo htmlspecialchars($shoe['images'][0][0]); ?>" alt="<?php echo htmlspecialchars($shoe['name']); ?>" />
            
            <div class="container_card-info">
                <div class="container-img_hover">
                    <?php
                        for ($j = 0; $j < 4; $j++) {
                            if (isset($shoe['images'][$j][0])) {
                                ?>
                                <img src="<?php echo htmlspecialchars($shoe['images'][$j][0]); ?>" alt="Color <?php echo $j; ?>" />
                                <?php
                            }
                        }
                    ?>

                    <span class="more-colors">
                        <?php
                        $countImages = count($shoe['images']);
                        if ($countImages > 4) {
                            echo '+' . ($countImages - 4);
                        }
                        ?>
                    </span>
                </div>

                <p class="new-release">
                    <?php
                    if (!$shoe['best_seller'][0] && $shoe['last_release'][0]) {
                        echo 'Dernière sortie';
                    } elseif ($shoe['best_seller'][0] && !$shoe['last_release'][0]) {
                        echo 'Meilleur vente';
                    }
                    ?>
                </p>

                <div class="container_details-hover">
                    <p class="product-name"><?php echo htmlspecialchars($shoe['name']); ?></p>
                    <p class="product-category"><?php echo htmlspecialchars($shoe['section']); ?></p>
                    <p class="product-colors"><?php echo count($shoe['color']); ?> couleurs</p>
                </div>

                <p class="product-price"><?php echo htmlspecialchars($shoe['price'][0]); ?> €</p>
            </div>
        </div>
    <?php
    }
    ?>
</main>
<script src="./script/script.js"></script>
</body>
</html>
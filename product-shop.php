<?php
session_start();
    $index = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $json = file_get_contents('http://localhost/ML%20Algo/product/shoes.json');
    $data = json_decode($json, true);
    $shoes = $data['shoes'][$index];

    $color = isset($_GET['color']) ? (int) $_GET['color'] : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/product-shop.css">
    <title><?php echo $shoes['name'] ?></title>
</head>
<body>
    <main>
        <div class="container">
            <div class="container_slider">
                <div class="container_preview">
                    <?php for($i = 0; $i < count($shoes['images']); $i++){ ?>
                    <img src="<?php echo $shoes['images'][$color][$i] ?>" alt="<?php echo $shoes['name'] ?> vue <?php $i ?>">
                    <?php } ?>
                </div>
                <div class="container_view">
                    <img src="<?php echo $shoes['images'][$color][0] ?>" alt="<?php echo $shoes['name'] ?> vue principale">
                    <div class="container_slider-btn">
                        <button>&lt;</button>
                        <button>&gt;</button>
                    </div>
                </div>
            </div>
            <div class="container_details">
                <div class="container_details-header">
                    <div class="container_header" style="display: flex; align-items: center; justify-content: space-between;">
                    <p><?php echo $shoes['name'] ?></p>
                    <div class="header_shop" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <a href="./index.php" style="font-size: 20px; margin: 0; display: flex; color: black; text-decoration: none; align-items: center; justify-content: center;"><i style="font-size: 17px;" class="fa-solid fa-chevron-left"></i> Retour</a>
                        <a href="./bag-shop.php" class="shopping-bag">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <?php if(isset($_SESSION['bag_count'])){ ?> 
                                <span class="counter-shop"><?php echo $_SESSION['bag_count'] ?></span>
                            <?php } ?>
                        </a>
                    </div>    
                    </div>
                    <p><?php echo $shoes['section'] ?></p>
                    <p><?php echo $shoes['price'][$color] ?> €</p>
                </div>
                <div class="container_details-shoes">
                    <?php for($i = 0; $i < count($shoes['images']); $i++){ ?>
                    <img src="<?php echo $shoes['images'][$i][0] ?>" alt="Coloris <?php echo $i ?>">
                    <?php } ?>
                </div>
                <div class="container_details-size">
                    <p>Sélectionner la taille</p>
                    <p>Taille petit : on te conseille de commander une demi-pointure au-dessus</p>
                    <div class="container_details-size-btn">
                    <?php for ($j = 0; $j < count($shoes['stock'][$color]); $j++) { ?>
                        <div class="size_btn <?php echo $shoes['stock'][$color][$j][1] === false ? 'disabled-size' : '' ?>">EU <?php echo $shoes['stock'][$color][$j][0] ?></div>
                    <?php } ?>    
                    </div>
                </div>
                <div class="container_details-buy">
                    <button class="disabled-button">Ajouter au panier</button>
                </div>
                <div class="container_details-description">
                    <p>Retrait gratuit</p>
                    <p>Trouver un magasin</p>
                    <p>Option « click and collect » disponible au moment du paiement</p>
                    <p><?php echo $shoes['description'] ?></p>
                    <ul>
                        <li>Couleur affichée : <?php echo $shoes['color'][$color] ?></li>
                        <li>Article : <?php echo $shoes['article'][$color] ?></li>
                    </ul>
                </div>
                <div class="container_details-info">
                    <details>
                        <summary>Taille et coupe</summary>
                        <ul>
                            <li>Taille petit : on te conseille de commander une demi-pointure au-dessus</li>
                            <li>Guide des tailles</li>
                        </ul>
                    </details>
                    <details>
                        <summary>Livraison et retours gratuits</summary>
                        <p>Livraison standard gratuite avec l'Accès Membre Nike.</p>
                        <ul>
                            <li>Tu peux retourner ta commande gratuitement, dans un délai de 30 jours. Certaines exclusions s'appliquent.</li>
                        </ul>
                    </details>
                </div>
            </div>
        </div>
    </main>
    <h2 style="text-align: center;">Vous pourriez aimez...</h2>
    <section style="padding-top: 0">
<?php
    $json = file_get_contents('http://localhost/ML%20Algo/product/shoes.json');
    $data = json_decode($json, true);

    for ($i = 0; $i < count($data['shoes']); $i++) {
        $shoe = $data['shoes'][$i];
        if($i === $index) continue;
        
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
    </section>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="./script/product-shop.js"></script>
<script src="./script/script.js"></script>
</html>
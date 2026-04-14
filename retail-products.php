<?php
// Connect to database
require 'dbConnect.php';

// SQL: Pull all rows, sorted by product_name DESC
$sql = "SELECT * FROM wdv341_products ORDER BY product_name DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>DMACC Electronics Store</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

    <style>
        *,:after,:before{box-sizing:border-box}
        body{font:normal 15px/25px 'Open Sans',Arial,sans-serif;color:#444}
        h1{font:normal 40px/120px 'Open Sans',Arial;text-align:center;margin:0}
        h1 span{color:#484c9b}
        header{text-align:center;padding-bottom:40px;border-bottom:1px solid #ddd;margin:40px auto 0;width:98%}
        section{width:95%;max-width:1200px;margin:40px auto;display:flex;flex-wrap:wrap;gap:1rem}
        .productBlock{width:calc(100%/4 - 1rem);background:#efefef;padding:1rem;border-radius:10px}
        .productImage img{width:100%;height:auto;display:block;margin:auto}
        .productName{font-size:large;margin:.5rem 0}
        .productDesc{margin:0 0 .5rem}
        .productPrice{font-size:larger;color:#00f;margin:.5rem 0}
        .productStatus{font-weight:bold;color:#2f4f4f;margin:.5rem 0}
        .productInventory{margin:.5rem 0}
        .productLowInventory{color:red;font-weight:bold}
    </style>
</head>

<body>

<header>
    <h1>DMACC Electronics Store!</h1>
    <p>Products for your Home and School Office</p>
</header>

<section>

<?php foreach ($products as $product): ?>

    <div class="productBlock">

        <div class="productImage">
            <img src="productImages/<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
        </div>

        <p class="productName"><?php echo $product['product_name']; ?></p>

        <p class="productDesc"><?php echo $product['product_description']; ?></p>

        <p class="productPrice">$<?php echo number_format($product['product_price'], 2); ?></p>

        <?php if (!empty($product['product_status'])): ?>
            <p class="productStatus"><?php echo $product['product_status']; ?></p>
        <?php endif; ?>

        <?php
            $inventoryClass = ($product['product_inStock'] < 10) ? "productLowInventory" : "";
        ?>
        <p class="productInventory <?php echo $inventoryClass; ?>">
            <?php echo $product['product_inStock']; ?> In Stock
        </p>

    </div>

<?php endforeach; ?>

</section>

</body>
</html>


<?php
$product_description = $list_price = $discount_percent = "";
$product_descriptionErr = $list_priceErr = $discount_percentErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Product Description
    if (empty($_POST["product_description"])) {
        $product_descriptionErr = "Product Description is required";
    } else {
        $product_description = test_input($_POST["product_description"]);
    }

    // Validate List Price
    if (empty($_POST["list_price"])) {
        $list_priceErr = "List Price is required";
    } else {
        $list_price = test_input($_POST["list_price"]);
        if (!is_numeric($list_price) || $list_price <= 0) {
            $list_priceErr = "List Price must be a valid number greater than 0";
        }
    }

    // Validate Discount Percent
    if (empty($_POST["discount_percent"])) {
        $discount_percentErr = "Discount Percent is required";
    } else {
        $discount_percent = test_input($_POST["discount_percent"]);
        if (!is_numeric($discount_percent) || $discount_percent < 0 || $discount_percent > 100) {
            $discount_percentErr = "Discount Percent must be a valid number between 0 and 100";
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// proceed if there are no errors
if (empty($product_descriptionErr) && empty($list_priceErr) && empty($discount_percentErr)) {
    // Calculate discount
    $discount = $list_price * $discount_percent * 0.01;
    $discount_price = $list_price - $discount;

    // Calculate sales tax
    $sales_tax_rate = 0.08; // 8%
    $sales_tax_amount = $discount_price * $sales_tax_rate;
    $sales_total = $discount_price + $sales_tax_amount;

    $list_price_f = "$" . number_format($list_price, 2);
    $discount_percent_f = $discount_percent . "%";
    $discount_f = "$" . number_format($discount, 2);
    $discount_price_f = "$" . number_format($discount_price, 2);
    $sales_tax_rate_f = $sales_tax_rate * 100 . "%";
    $sales_tax_amount_f = "$" . number_format($sales_tax_amount, 2);
    $sales_total_f = "$" . number_format($sales_total, 2);
} else {
    $list_price_f = $discount_percent_f = $discount_f = $discount_price_f = $sales_tax_rate_f = $sales_tax_amount_f = $sales_total_f = "";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Product Discount Calculator</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div id="data">
                <label>Product Description:</label>
                <input type="text" name="product_description" value="<?php echo htmlspecialchars($product_description); ?>"><br>
                <span class="error"><?php echo $product_descriptionErr;?></span>

                <label>List Price:</label>
                <input type="text" name="list_price" value="<?php echo $list_price; ?>"><br>
                <span class="error"><?php echo $list_priceErr;?></span>

                <label>Discount Percent:</label>
                <input type="text" name="discount_percent" value="<?php echo $discount_percent; ?>"><span>%</span><br>
                <span class="error"><?php echo $discount_percentErr;?></span>
            </div>

            <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Calculate Discount"><br>
            </div>
        </form>

        <?php if (empty($product_descriptionErr) && empty($list_priceErr) && empty($discount_percentErr)) : ?>
            <label>Discount Amount:</label>
            <span><?php echo $discount_f; ?></span><br>

            <label>Discount Price:</label>
            <span><?php echo $discount_price_f; ?></span><br>

            <label>Sales Tax Rate:</label>
            <span><?php echo $sales_tax_rate_f; ?></span><br>

            <label>Sales Tax Amount:</label>
            <span><?php echo $sales_tax_amount_f; ?></span><br>

            <label>Sales Total After Discount and Tax:</label>
            <span><?php echo $sales_total_f; ?></span><br>
        <?php endif; ?>
    </main>
</body>
</html>

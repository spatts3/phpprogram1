<!DOCTYPE html>
<html>
<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <main>
        <h1>Product Discount Calculator</h1>
        <form action="display_discount.php" method="post">
            <div id="data">
                <label>Product Description:</label>
                <input type="text" name="product_description" value="<?php echo isset($_POST['product_description']) ? htmlspecialchars($_POST['product_description']) : ''; ?>"><br>

                <label>List Price:</label>
                <input type="text" name="list_price" value="<?php echo isset($_POST['list_price']) ? htmlspecialchars($_POST['list_price']) : ''; ?>"><br>

                <label>Discount Percent:</label>
                <input type="text" name="discount_percent" value="<?php echo isset($_POST['discount_percent']) ? htmlspecialchars($_POST['discount_percent']) : ''; ?>"><span>%</span><br>
            </div>

            <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Calculate Discount"><br>
            </div>
        </form>
    </main>
</body>
</html>

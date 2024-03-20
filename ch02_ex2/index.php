<?php 
    $investment = isset($_POST['investment']) ? $_POST['investment'] : '';
    $interest_rate = isset($_POST['interest_rate']) ? $_POST['interest_rate'] : '';
    $years = isset($_POST['years']) ? $_POST['years'] : '';
    $future_value_f = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // get the data from the form
        $investment = filter_input(INPUT_POST, 'investment', FILTER_VALIDATE_FLOAT);
        $interest_rate = filter_input(INPUT_POST, 'interest_rate', FILTER_VALIDATE_FLOAT);
        $years = filter_input(INPUT_POST, 'years', FILTER_VALIDATE_INT);

        // set default error message to empty string
        $error_message = '';

        // validate investment
        if ($investment === FALSE) {
            $error_message .= 'Investment must be a valid number.<br>'; 
        } else if ($investment <= 0) {
            $error_message .= 'Investment must be greater than zero.<br>'; 
        } 

        // validate interest rate
        if ($interest_rate === FALSE) {
            $error_message .= 'Interest rate must be a valid number.<br>'; 
        } else if ($interest_rate <= 0) {
            $error_message .= 'Interest rate must be greater than zero.<br>'; 
        } else if ($interest_rate > 15) {
            $error_message .= 'Interest rate must be less than or equal to 15.<br>';
        }

        // validate years
        if ($years === FALSE) {
            $error_message .= 'Years must be a valid whole number.<br>';
        } else if ($years <= 0) {
            $error_message .= 'Years must be greater than zero.<br>';
        } else if ($years > 30) {
            $error_message .= 'Years must be less than 31.<br>';
        }

        // if no error, calculate the future value
        if ($error_message == '') {
            $future_value = $investment;
            for ($i = 1; $i <= $years; $i++) {
                $future_value += $future_value * $interest_rate * .01;
            }
            $future_value_f = '$'.number_format($future_value, 2);

            // clear input values
            $investment = '';
            $interest_rate = '';
            $years = '';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <main>
    <h1>Future Value Calculator</h1>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div id="data">
            <label>Investment Amount:</label>
            <input type="text" name="investment" value="<?php echo htmlspecialchars($investment); ?>"><br>

            <label>Yearly Interest Rate:</label>
            <input type="text" name="interest_rate" value="<?php echo htmlspecialchars($interest_rate); ?>"><br>

            <label>Number of Years:</label>
            <input type="text" name="years" value="<?php echo htmlspecialchars($years); ?>"><br>
        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Calculate"><br>
        </div>
        
        <?php if ($future_value_f != '') { ?>
        <div id="results">
            <label>Future Value:</label>
            <span><?php echo $future_value_f; ?></span><br>
        </div>
        <?php } ?>

    </form>
    </main>
</body>
</html>

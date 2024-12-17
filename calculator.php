<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affordability Calculator</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css"> <!-- New CSS file for the calculator -->

</head>

<body>

<!-- header section starts -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section>
    <div class="calculator-container">
        <h1 class="calculator-title">Affordability Calculator</h1>

        <form id="calculatorForm" class="calculator-form">
            <div class="input-group">
                <label for="income">Monthly Income ($):</label>
                <!-- <input type="number" id="income" placeholder="Enter your income" required> -->
                <input type="number" id="income" required maxlength="10" placeholder="Enter your income">
            </div>

            <div class="input-group">
                <label for="expenses">Monthly Expenses ($):</label>
                <!-- <input type="number" id="expenses" placeholder="Enter your expenses" required> -->
                <input type="number"  id="expenses" required maxlength="10" placeholder="Enter your expenses">
            </div>

            <div class="input-group">
                <label for="loanAmount">Loan Amount ($):</label>
                <!-- <input type="number" id="loanAmount" placeholder="Enter desired loan amount" required> -->
                <input type="number"  id="loanAmount" required maxlength="10" placeholder="Enter desired loan amount">
            </div>

            <button type="button" id="calculateBtn">Calculate</button>
            <div class="result hidden" id="resultContainer">
                <p id="resultText-1"></p>
            </div>
        </form>
    </div>

    <div class="calculator-container">
        <h1 class="calculator-title">Currency Converter</h1>

        <form id="currencyForm" class="calculator-form">
            <div class="input-group">
                <label for="amount">Amount:</label>
                <!-- <input type="number" id="amount" placeholder="Enter amount" required> -->
                <input type="number"  id="amount" required maxlength="10" placeholder="Enter amount">
            </div>

            <div class="input-group">
                <label for="fromCurrency">From:</label>
                <select id="fromCurrency" required></select>
                <!-- <select id="fromCurrency">
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="INR">INR</option>
                    <option value="GBP">GBP</option>
                </select> -->
            </div>

            <div class="input-group">
                <label for="toCurrency">To:</label>
                <select id="toCurrency" required></select>
                <!-- <select id="toCurrency">
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="INR">INR</option>
                    <option value="GBP">GBP</option>
                </select> -->
            </div>

            <button type="button" id="convertBtn">Convert</button>
            <div class="result hidden" id="conversionResult">
                <p id="resultText-2"></p>
            </div>
        </form>
    </div>
</section>

<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- sweet alert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js link -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>

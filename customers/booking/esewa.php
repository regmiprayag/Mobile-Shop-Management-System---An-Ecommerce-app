<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<?php
    $price = $_GET['amount'];
?>

    <form method="post" id="shippingForm">
        <input type="hidden" id="amount" name="amount" value="<?php echo (int)$price; ?>" required>
        <input type="hidden" id="tax_amount" name="tax_amount" value="0" required>
        <input type="hidden" id="total_amount" name="total_amount" value="<?php echo (int)$price; ?>" required>
        <input type="hidden" id="transaction_uuid" name="transaction_uuid" required>
        <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
        <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
        <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
        <input type="hidden" id="success_url" name="success_url" value="http://localhost/MobileStoreSP/customers/success.php" required>
        <input type="hidden" id="failure_url" name="failure_url" value="http://localhost/MobileStoreSP/customers/failure.php?param1=value1" required>
        <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
        <input type="hidden" id="signature" name="signature" required>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/hmac-sha256.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/enc-base64.min.js"></script>
    <script>
        var uuid = performance.now();
        var id = `${uuid}`.replace('.', '-');
        // console.log(id);

        var tuid = document.getElementById('transaction_uuid');
        var secret = '8gBm/:&EnhH.1/q';
        var signature = `total_amount=<?php echo (int)$price; ?>,transaction_uuid=${id},product_code=EPAYTEST`;

        var hash = CryptoJS.HmacSHA256(signature, secret);
        var hashInBase64 = CryptoJS.enc.Base64.stringify(hash);


        var sig = document.getElementById('signature');
        // console.log("The sig bharkharai is: ",sig);
        tuid.value = id;
        sig.value = hashInBase64;

        if (hashInBase64) {
            myFunction();
        }

        // console.log("hello prayag");
        let userDetails;

        // let name = document.getElementById("full_name").value;
        // console.log("Name= ",name);

        function storeFormData() {
            // Get form elements
            var fullNameInput = document.getElementById('full_name');
            var addressInput = document.getElementById('address');
            var cityInput = document.getElementById('city');
            var phoneInput = document.getElementById('phone');

            // Store form data in sessionStorage
            sessionStorage.setItem('full_name', fullNameInput.value);
            sessionStorage.setItem('address', addressInput.value);
            sessionStorage.setItem('city', cityInput.value);
            sessionStorage.setItem('phone', phoneInput.value);

        }

        // Add event listener to form submission
        document.getElementById('shippingForm').addEventListener('submit', function(event) {
            // Store form data in sessionStorage before submitting the form
            storeFormData();
        });

        function myFunction() {
            var formElem = document.getElementById('shippingForm');
            formElem.setAttribute('action', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form');
                // console.log("The form elements are: ",formElem);
            formElem.submit();
        }
    </script>

    <script>
        // window.onload = function() {myFunction()};
    </script>

</html>
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="post" id="shippingForm">
    <input type="hidden" id="amount" name="amount" value="<?php echo (int)$row['price']; ?>" required>
    <input type="hidden" id="tax_amount" name="tax_amount" value="0" required>
    <input type="hidden" id="total_amount" name="total_amount" value="<?php echo (int)$row['price']; ?>" required>
    <input type="hidden" id="transaction_uuid" name="transaction_uuid" required>
    <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
    <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
    <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
    <input type="hidden" id="success_url" name="success_url" value="https://esewa.com.np" required>
    <input type="hidden" id="failure_url" name="failure_url" value="https://google.com" required>
    <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
    <input type="hidden" id="signature" name="signature" required>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-sha256.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
<script>
    // Function to generate a unique transaction ID
    function generateTransactionId() {
        var uuid = performance.now();
        return `${uuid}`.replace('.', '-');
    }

    // Function to generate signature
    function generateSignature(totalAmount, transactionId) {
        var secret = '8gBm/:&EnhH.1/q';
        var signature = `total_amount=${totalAmount},transaction_uuid=${transactionId},product_code=EPAYTEST`;
        var hash = CryptoJS.HmacSHA256(signature, secret);
        return CryptoJS.enc.Base64.stringify(hash);
    }

    // Function to submit the form
    function submitForm() {
        var totalAmount = <?php echo (int)$row['price']; ?>;
        var transactionId = generateTransactionId();
        var signature = generateSignature(totalAmount, transactionId);

        // Update form values
        document.getElementById('transaction_uuid').value = transactionId;
        document.getElementById('signature').value = signature;

        // Submit the form
        document.getElementById('shippingForm').submit();
    }

    // Automatically submit the form when the page is loaded
    window.onload = function() {
        submitForm();
    };
</script>

</body>
</html> -->
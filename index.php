<?php
session_start();
function generate_nonce( $action ) {
	$nonce                          = base64_encode( openssl_random_pseudo_bytes( 16 ) );
	$_SESSION[ $action . '_nonce' ] = $nonce;

	return $nonce;
}

$nonce = generate_nonce( 'credit_card_form' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Credit Card Form</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="card-container">
	<form id="creditCardForm" method="POST" action="process.php">
		<input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
		<div class="form-group">
			<input class="form-control" type="text" id="cardNumber" name="cardNumber" maxlength="19" required
			       placeholder="#### #### #### ####">
		</div>
		<div class="form-group date">
			<select id="expiryMonth" name="expiryMonth" required></select>
			<select id="expiryYear" name="expiryYear" required></select>
		</div>
		<div class="form-group">
			<input class="form-control cvv" type="password" id="cvv" name="cvv" maxlength="3" required placeholder="CVV">
		</div>
		<div class="form-group">
			<input class="form-control" type="text" id="cardName" name="cardName" maxlength="50" required
			       placeholder="FULL NAME">
		</div>
		<div id="errorMessages" style="color: red; display: none;"></div>
		<button type="submit">Submit</button>
	</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>
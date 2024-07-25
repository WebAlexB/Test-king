<?php
session_start();
function generate_nonce( $action ) {
	$nonce                          = base64_encode( openssl_random_pseudo_bytes( 16 ) );
	$_SESSION[ $action . '_nonce' ] = $nonce;

	return $nonce;
}

function verify_nonce( $nonce, $action ) {
	if ( isset( $_SESSION[ $action . '_nonce' ] ) && $_SESSION[ $action . '_nonce' ] === $nonce ) {
		unset( $_SESSION[ $action . '_nonce' ] );

		return true;
	}

	return false;
}

$nonce = generate_nonce( 'credit_card_form' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Credit Card Form</title>
	<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="card-container">
	<form id="creditCardForm" method="POST" action="process.php">
		<input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
		<input type="text" id="cardNumber" name="cardNumber" maxlength="19" required placeholder="#### #### #### ####">
		<div style="display: flex; gap: 10px;">
			<select id="expiryMonth" name="expiryMonth" required></select>
			<select id="expiryYear" name="expiryYear" required></select>
		</div>
		<input type="text" id="cvv" name="cvv" maxlength="4" required placeholder="CVV">
		<input type="text" id="cardName" name="cardName" required placeholder="FULL NAME">
		<div id="errorMessages" style="color: red; display: none;"></div>
		<button type="submit">Submit</button>
	</form>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>

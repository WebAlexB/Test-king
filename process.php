<?php
/**
 * На хостинги желательно реализовать проверку nonce для формы временно убрал чтоб не мешала для тестирования
 */

//session_start();
//function verify_nonce( $nonce, $action ) {
//	if ( isset( $_SESSION[ $action . '_nonce' ] ) && $_SESSION[ $action . '_nonce' ] === $nonce ) {
//		unset( $_SESSION[ $action . '_nonce' ] );
//
//		return true;
//	}
//
//	return false;
//}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
//	$nonce = $_POST['nonce'];
//	if ( ! verify_nonce( $nonce, 'credit_card_form' ) ) {
//		die( 'Invalid nonce.' );
//	}

	$cardNumber  = trim( $_POST['cardNumber'] );
	$expiryMonth = trim( $_POST['expiryMonth'] );
	$expiryYear  = trim( $_POST['expiryYear'] );
	$cvv         = trim( $_POST['cvv'] );
	$cardName    = trim( $_POST['cardName'] );
	$errors      = [];

	function validateCardNumber( $number ) {
		$number = str_replace( ' ', '', $number );

		return preg_match( '/^\d{16}$/', $number );
	}

	function validateCVV( $cvv ) {
		return preg_match( '/^\d{3}$/', $cvv );
	}

	function validateExpiryDate( $month, $year ) {
		$currentYear  = date( 'Y' );
		$currentMonth = date( 'm' );
		if ( $year > $currentYear || ( $year == $currentYear && $month >= $currentMonth ) ) {
			return true;
		}

		return false;
	}

	if ( empty( $cardName ) ) {
		$errors[] = 'Cardholder name is required.';
	}

	if ( ! validateCardNumber( $cardNumber ) ) {
		$errors[] = 'Invalid card number. It should be 16 digits.';
	}

	if ( ! validateCVV( $cvv ) ) {
		$errors[] = 'Invalid CVV. It should be 3 digits.';
	}

	if ( ! validateExpiryDate( $expiryMonth, $expiryYear ) ) {
		$errors[] = 'Invalid expiry date. The date must be in the future.';
	}

	if ( empty( $errors ) ) {
		echo 'Form submitted successfully!';
	} else {
		echo '<div id="phpErrors">' . implode( '<br>', $errors ) . '</div>';
	}
}
?>

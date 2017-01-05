<?php

	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div id=\"tipster_errors\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
		    $output .= htmlentities($error);
		    $output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	//Validation Functions
	$errors = array();

	function fieldname_as_text($fieldname){
	$fieldname = str_replace("_", " ", $fieldname);
	$fieldname = ucfirst($fieldname);
	return $fieldname;
	}

	// * presence
	// use trim() so empty spaces don't count
	// use === to avoid false positives
	// empty() would consider "0" to be empty
	function has_presence($value) {
		return isset($value) && $value !== "";
	}

	function validate_presences($required_fields){
		global $errors;
		foreach ($required_fields as $field) {
			$value = trim($_POST[$field]);
			if (!has_presence($value)) {
				$errors[$field] = fieldname_as_text($field) . " can't be blank";
			}
		}
	}

	function validate_subtotal($subtotal_field){
		//Validate subotal is greater than 0 if subtotal is set.
		global $errors;

		if (has_presence($_POST[$subtotal_field])){
			$subtotal= trim($_POST[$subtotal_field]);

			if ( !($subtotal > 0) || !is_numeric($subtotal) ) {
				$errors[$subtotal_field] = fieldname_as_text($subtotal_field) . " must be a number greater than 0.";
			}
		}
	}

	function validate_custom_tip($custom_tip_field){
		//If percentage is custom, validate custom tip is a number
		global $errors;

		if ($_POST["percentage"] == "custom" ){
			$custom_tip = trim($_POST[$custom_tip_field]);

			if ( !($custom_tip >= 0) || !is_numeric($custom_tip) ) {
				$errors[$custom_tip_field] = fieldname_as_text($custom_tip_field) . " must be a positive number.";
			}
		}
	}

	function validate_split($split_field){
		//Validate split value
		global $errors;

		if (has_presence($_POST[$split_field])){

			//Cast as integer
			$split = trim($_POST[$split_field]);
			$split_int = (int) trim($_POST[$split_field]);

			//Check that split is greater than 0 and an integer
			if ( !($split > 0) || ($split != $split_int  ) ) {
				$errors[$split_field] = fieldname_as_text($split_field) . " must be an integer greater than 0.";
			}
		}
	}

?>
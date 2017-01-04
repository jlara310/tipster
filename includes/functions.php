<?php

	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
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
			$subtotal_value = $_POST[$subtotal_field];

			if ( !($subtotal_value > 0) || !is_numeric($subtotal_value) ) {
				$errors[$subtotal_field] = fieldname_as_text($subtotal_field) . " must be a number greater than 0.";
			}
		}
	}

?>
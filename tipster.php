<?php require_once("/includes/functions.php"); ?>

<?php
	if (isset($_POST["submit"])){
		//start form validation. Errors stored in $error global variable.
		$required_fields = array("subtotal", "percentage");
		validate_presences($required_fields);
		validate_subtotal("subtotal");

		//If no errors, process form
		if (empty($errors)) {
			$tipster_result = array();

			$subtotal = (float) $_POST["subtotal"];
			$percentage = (float) $_POST["percentage"];

			$tip = $subtotal * $percentage / 100;
			$tip = number_format(round($tip, 2), 2);

			$tipster_result["Tip"] = "$".htmlentities($tip);

			$total = $subtotal + $tip;
			$total = number_format(round($total, 2), 2);
			$tipster_result["Total"] = "$".htmlentities($total);

		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose/dtd">

<html lang="en">
	<head>
		<title>Tipster</title>
		<link href="./includes/tipster.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="tipster">
		<h1>Tipster</h1>
		<p>Tip Calculator</p>
			<div id="tipster_form">
				<?php
					if(!empty($errors)){
						echo "<div id=\"tipster_errors\">";
						echo "<ul>";
						foreach ($errors as $error_message) {
							echo "<li>{$error_message}</li>";
						}
						echo "</ul>";
						echo "</div>";
					}
				?>
				<form  action="tipster.php" method="post">
				<p><span <?php if(isset($errors["subtotal"])){ echo "class=\"tipster_field_error\""; } ?>>Bill Subtotal:</span> $
					<?php
					//If POST, set submitted subtotatl as default
					if(isset($_POST["subtotal"])){
						echo "<input type=\"text\" name=\"subtotal\" value=\"".htmlentities($_POST["subtotal"])."\" />";
					} else {
					 	echo "<input type=\"text\" name=\"subtotal\" value=\"\" />";
						}
					?>
				</p>
				<p>Tip Percentage:<br />
					<?php
					//Loop through an array to output percentage input
					$percentages = array("10", "15", "20");

					for ($i = 0; $i < count($percentages); $i++) {
						$percentate_value = $percentages[$i];

						echo "<input type=\"radio\" name=\"percentage\" ";
						//If POST, set submitted value as default, else set first option as default
						if (isset($_POST["percentage"])) {
							if(($_POST["percentage"] == $percentate_value)) { echo "checked " ; }
						} elseif ($i == 0){ echo "checked "; };

						echo "value=\"{$percentate_value}\">{$percentate_value}%</input>";
					}
					?>
				</p>
				<p><input type="submit" name="submit" value="Calculate" /></p>
				</form>
			</div>
			<?php if (isset($tipster_result)) {
				echo "<div id=\"tipster_result\">";
				
					foreach ($tipster_result as $message => $text) {
						echo "<p>{$message}: {$text}</p>";
					}
				echo "</div>";
				}
				?>		
		</div>
	</body>
</html>
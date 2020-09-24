<!DOCTYPE html>
<html>
	<head>
		<title>Test</title>
		<meta charset="utf-8">
	</head>

	<body>
		<!-- A simple form with a post method where you can enter the amount you want -->
		<form method="post" action="">
			<label for="amount" >Amount: </label>
			<input id ="amount" type="number" step="any" name="amount">
			<input type="submit" value="Start" name="submit">
		</form>

		<!-- Check if user clicked on submit and amount variable is defined -->
		<?php
			if (isset($_POST["amount"]) && isset($_POST["submit"])) {
				$amount = $_POST["amount"];
				$amount = (float) $amount;
				$repartition = calculate_repartition($amount);
				echo show_repartition($repartition);
			}
		?>	
	</body>

</html>

<?php

/* A function which create an array key=>value (key is coin/banknote and value is the number of coin/banknote) */ 
function calculate_repartition(float $amount):array {
	$coins = [0.1, 0.2, 0.5, 1, 2, 5, 10, 20, 50];
	$coins_reversed = array_reverse($coins);
	$repartition = [];

	foreach ($coins_reversed as $coin) {
		$quotient = floor($amount/$coin);
		$remaining = bcsub($amount, $coin * $quotient, 2);

		if (bccomp($quotient, 0, 2) != 0) {
			$repartition += [sprintf($coin) => $quotient];
		}

		if (bccomp($remaining, 0, 2) != 0) {
			$amount = $remaining;
		} else {
			break;
		}
	}

	return $repartition;
}

/* A function which returns the repartition in a string format */
function show_repartition(array $repartition):string {
	$result = "ERROR";
	if (!is_null($repartition)){
		$result = "";
		foreach ($repartition as $coin => $quotient) {
			$result = $result . "<br>" . $quotient . " x {" . $coin . " £}<br>";
		}
	}

	return $result;
}

?>
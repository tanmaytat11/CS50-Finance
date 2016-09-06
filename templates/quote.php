<?php
	$price = $stock["price"];
	$s_p = number_format($price, 2, '.', '');
	print("A share of " . $stock["name"] . " (" . $stock["symbol"] . ") costs " . "<strong>" . "$" . $s_p . "</strong>" . ".<br>");
?>
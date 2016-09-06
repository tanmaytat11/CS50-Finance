<?php

    // configuration
    require("../includes/config.php");

    $rows =	query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
    $positions = [];
	foreach ($rows as $row)
	{
        $positions[] = [
            "transaction" => $row["transaction"],
            "date_time" => $row["date_time"],
            "symbol" => $row["symbol"],
            "shares" => $row["shares"],
            "price" => $row["price"]
        ];
	}

    // render portfolio
    render("history_form.php", ["title" => "History", "positions" => $positions]);

?>

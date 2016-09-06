<?php
    // configuration
    require("../includes/config.php");

    $rows =   query("SELECT * FROM portfolios WHERE id = ?", $_SESSION["id"]);
    $positions = [];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"]
            ];
        }
    }

    $users = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);


    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("sell_form.php", ["title" => "Sell", "positions" => $positions]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
        if (empty($_POST["symbol"]) == true)
        {
            apologize("You must select a stock to sell.");
        }
        else
        {
            $sell = 'SELL';
            $stock = lookup($_POST["symbol"]);
            $shares = query("SELECT shares FROM portfolios WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
            query("DELETE FROM portfolios WHERE id = ? AND symbol = ?", $_SESSION["id"], $stock["symbol"]);
            query("UPDATE users SET cash = cash + ? WHERE id = ?", $stock["price"] * $shares[0]["shares"], $_SESSION["id"]);
            query("INSERT INTO `history`(`id`, `transaction`, `date_time`, `symbol`, `shares`, `price`) VALUES (?,?,NOW(),?,?,?)", $_SESSION["id"], $sell, $stock["symbol"], $shares[0]["shares"], $stock["price"]);
            redirect("/index.php");
        }
    }

?>

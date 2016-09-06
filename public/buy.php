<?php
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("buy_form.php", ["title" => "Buy"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO

        if (empty($_POST["symbol"]) || empty($_POST["shares"]))
        {
            apologize("You must enter a stock symbol and quantity of shares to buy.");
        }
        
        if (lookup($_POST["symbol"]) === false)
        {
            apologize("Invalid stock symbol.");
        }

        if(preg_match("/^\d+$/", $_POST["shares"]))
        {
            $buy = 'BUY';
            $stock = lookup(strtoupper($_POST["symbol"]));
            $cash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
            if($stock["price"] * $_POST["shares"] <= $cash[0]["cash"])
            {
                query("INSERT INTO portfolios (id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $stock["symbol"], $_POST["shares"]);
                query("UPDATE users SET cash = cash - ? WHERE id = ?", $stock["price"] * $_POST["shares"], $_SESSION["id"]);
                query("INSERT INTO `history`(`id`, `transaction`, `date_time`, `symbol`, `shares`, `price`) VALUES (?,?,NOW(),?,?,?)", $_SESSION["id"], $buy, $stock["symbol"], $_POST["shares"], $stock["price"]);
                redirect("/index.php");
            }
            else
            {
                apologize("You can't afford that.");
            }
        }
        else
        {
            apologize("Invalid number of shares.");
        }
    }

?>

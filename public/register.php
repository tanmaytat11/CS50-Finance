<?php
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO

        if (empty($_POST["username"]) == true)
        {
        	apologize("Enter a username");
        }
        else if (empty($_POST["password"]) == true)
        {
        	apologize("Enter a password");
        }
        else if ($_POST["password"] != $_POST["confirmation"])
        {
        	apologize("Passwords do no match");
        }

        if (query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.0000)", $_POST["username"], crypt($_POST["password"])) === false)
        {
        	apologize("username already exists!");
        }
        else
        {
        	$rows = query("SELECT LAST_INSERT_ID() AS id");
			$id = $rows[0]["id"];
			$_SESSION["id"] = $id;
			redirect("/index.php");
        }
    }

?>

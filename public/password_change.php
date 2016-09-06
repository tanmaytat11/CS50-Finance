<?php
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("password_change_form.php", ["title" => "Password Change"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO

        if (empty($_POST["current_password"]) == true)
        {
        	apologize("Enter your current password");
        }
        else if (empty($_POST["new_password"]) == true)
        {
        	apologize("Enter a new password");
        }
        else if ($_POST["new_password"] != $_POST["new_confirmation"])
        {
        	apologize("Passwords do not match");
        }

        $rows = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
     	if (crypt($_POST["current_password"], $rows[0]["hash"]) == $rows[0]["hash"])
        {
        	query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["new_password"]), $_SESSION["id"]);
        	redirect("/index.php");
        }
        else
        {
        	apologize("Wrong Password");
        }
    }

?>

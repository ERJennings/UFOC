<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFOC</title>
    <link rel="stylesheet" href="style.css">

</head>
<body class=body>
<h1 class = h1>
    Welcome to the UFOC System!
</h1>
<!-- Temporary code to be replaced with later code when Quenten completes the login -->

<h2 class = h2>Username</h2>
<input class = input type = text name = username>
<br>
<h2 class = h2>Password</h2>
<input class = input type = text name = password><br>
<button class = button type = submit name = login>Log In</button>

<div class = buttonrow>
    <form class = tempbutton action="menu.php">
        <button>Standard Faculty</button>
    </form>
    <form class = tempbutton action="adminmenu.php">
        <button>Administrator</button>
    </form>
    <form class = tempbutton action="ufocmenu.php">
        <button>UFOC Member</button>
    </form>
</div>

<?php

//Code below for when Quenten finishes login page

//echo "<html><body class = \"body\"><form index=\"index.php\" method = post>
//
//    <h2 class = h2>Username</h2>
//    <input class = \"input\" type = \"text\" name = \"username\">
//    <br>
//    <h2 class = h2>Password</h2>
//    <input class = \"input\" type = \"text\" name = \"password\"><br>
//
//    <button class = \"button\" type=\"submit\" name=\"login\">Log In</button>
//</form>";
//
//if (isset($_POST['username']) and isset($_POST['password'])) {
//
//    //Code to handle logging in goes here
//
//    //Go to main menu when button is clicked, this should be changed to only move on with valid login
//    header("Location: menu.php");
//
//}


?>
</body>
</html>

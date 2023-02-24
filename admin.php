<?php

if (!isset($_COOKIE["type"])) {
    header("location:403.php");
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <div>
        <div>
            <a href="logout.php">Выйти</a>
        </div>
    </div>
</body>
</html>
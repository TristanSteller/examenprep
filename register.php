<?php
    require_once "classes/user.class.php";
    $user = new User();

    function setErrorMsg($message){
        echo $message;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST["username"] && $_POST["email"] && $_POST["password"] && $_POST["repeat-password"]){
            $user->register($_POST["username"], $_POST["email"], $_POST["password"], $_POST["repeat-password"]);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<?php
        include_once "components/navbar.php"
    ?>
    </div>
    </nav>
    <div class="d-flex align-items-center justify-content-center mt-5">
        <div class="card">
            <div class="card-header text-center">
                Inloggen
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" placeholder="naam" name="username">
                    </div>  
                    <div class="input-group mb-1">
                        <input type="email" class="form-control" placeholder="email" name="email">
                    </div>
                    <div class="input-group mb-1">
                        <input type="password" class="form-control" placeholder="wachtwoord" name="password">
                    </div>  
                    <div class="input-group mb-1">
                        <input type="password" class="form-control" placeholder="wachtwoord herhalen" name="repeat-password">
                    </div>
                    <button type="submit" class="btn btn-outline-secondary">Registreer</button>
                    <a href="index.php" class="btn btn-outline-secondary">Login</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
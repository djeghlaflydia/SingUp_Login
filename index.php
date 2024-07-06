<?php
    include("conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
    <div class="wrapper">
        <span class="bg-animate"></span>
        <span class="bg-animate2"></span>
        <!--1er form-->
        <div class="form-box login">
            <h2 class="animation" style="--i:0; --j:21;">Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-box animation" style="--i:1; --j:22;">
                    <input type="text" name="username" required>
                    <label>Username</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:2; --j:23;">
                    <input type="password" name="password" required>
                    <label>Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn animation" style="--i:3; --j:24;" name="Login">Login</button>
                <div class="logreg-link animation" style="--i:4; --j:25;">
                    <p>Don't have an account? <a href="#" class="register-link">Sign Up</a></p>
                </div>
            </form>
        </div>
        <div class="info-text login">
            <h2 class="animation" style="--i:0; --j:20;">Welcome Back!</h2>
            <p class="animation" style="--i:1; --j:21;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos laborum officia quo et voluptate modi.</p>
        </div>

        <!--2eme form-->
        <div class="form-box register">
            <h2 class="animation" style="--i:17; --j:0;">Sign Up</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-box animation" style="--i:18; --j:1;">
                    <input type="text" name="username" required>
                    <label>Username</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:19; --j:2;">
                    <input type="email" name="email" required>
                    <label>Email</label>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box animation" style="--i:20; --j:3;">
                    <input type="password" name="password" required>
                    <label>Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn animation" style="--i:21; --j:4;" name="SignUp">Sign Up</button>
                <div class="logreg-link animation" style="--i:22; --j:5;">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
        <div class="info-text register">
            <h2 class="animation" style="--i:17; --j:0;">Welcome Back!</h2>
            <p class="animation" style="--i:18; --j:1;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos laborum officia quo et voluptate modi.</p>
        </div>

    </div>

    <script src="Script.js"></script>
    <script>
        // PHP variables to JavaScript for use in alerts
        <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                echo "alert('$error');";
            }
        ?>
    </script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["SignUp"])) {
        // Filtrer les caractères non voulus
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        // Hachage du mot de passe
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO connexion (Username, Email, Password) VALUES ('$username', '$email', '$hash')";

        try{
            //insert
            mysqli_query($conn, $sql);
            header("Location: https://github.com/djeghlaflydia");
            exit();
        }catch(mysqli_sql_exception){
            $error = "Invalid.";
            header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]) . "?error=" . urlencode($error));
            exit();
        }
        
    } elseif (isset($_POST["Login"])) {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    
        // Requête pour obtenir l'utilisateur par nom d'utilisateur
        $sql = "SELECT * FROM connexion WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Vérification du mot de passe
            if (password_verify($password, $user['Password'])) {
                header("Location: https://github.com/djeghlaflydia");
                exit();
            } else {
                $error = "Invalid username or password.";
                header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]) . "?error=" . urlencode($error));
                exit();
            }
        } else {
            $error = "Invalid username or password.";
            header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]) . "?error=" . urlencode($error));
            exit();
        }
    }
}

mysqli_close($conn);
?>

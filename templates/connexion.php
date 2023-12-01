<section>
    <form method="post">
        <h1>Se connecter</h1>
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
        
        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
        
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <?php
    $erreur = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
            preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $_POST['password'])) {

            require("./inc/db.php");
            $request = $pdo->prepare("SELECT * FROM `user` WHERE `email` = ?;");
            $request->execute([$_POST['email']]);
            $user = $request->fetch(PDO::FETCH_ASSOC);

            if ($user === false || !password_verify($_POST['password'], $user["password"])) {
                array_push($erreur, "L'utilisateur ou le mot de passe est invalide");
            } else {
                echo "Vous êtes connecté";
                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["id"] = $user["id"];
                header("Location: index.php");
                exit();
            }
        } else {
            array_push($erreur, 'Le mot de passe ou l\'email n\'est pas valide');
        }
    }
    ?>

    <ul>
        <?php
        foreach ($erreur as $value) {
            echo "<li>" . $value . "</li>";
        }
        ?>
    </ul>
</section>

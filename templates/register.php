<main>
    <form class="m-5" action="#" method="post">
        <!-- ... (Votre formulaire HTML) ... -->
    </form>

    <?php
    $erreurs_messages = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // ... (Vos tests de validation)

        if (empty($erreurs_messages)) {
            require("./inc/db.php");

            // Vérification de l'existence de l'email
            $request = $pdo->prepare("SELECT COUNT(*) FROM user WHERE email = ?;");
            $request->execute([$_POST['email']]);
            $email_exists = $request->fetchColumn();

            if ($email_exists > 0) {
                array_push($erreurs_messages, "Cet email est déjà utilisé. Veuillez choisir un autre.");
            } else {
                // Insertion sécurisée avec requête préparée
                $encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $request = $pdo->prepare("INSERT INTO user (prenom, nom, email, password) VALUES (?, ?, ?, ?);");
                $request->execute([$_POST['firstname'], $_POST['lastname'], $_POST['email'], $encrypted_password]);

                array_push($erreurs_messages, "Inscription réussie !");
            }
        }
    }
    ?>

    <ul>
        <?php
        foreach ($erreurs_messages as $item) {
            echo "<li>" . $item . "</li>";
        }
        ?>
    </ul>
</main>

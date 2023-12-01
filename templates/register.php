<section>
<form method="post">
    <h1>Inscription</h1>
  <div class="mb-3">
  <label for="login" class="form-label">Nom</label>
        <input type="text" class="form-control" id="login" name="login">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Chek me</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
// var_dump($_GET);
$erreur=[];
$message=[];
if (isset($_POST['login']) && strlen($_POST['login']) <= 255) {
    array_push($message, 'ok pour le Nom');
} else {
    array_push($erreur, 'Le Nom n\'est pas valide');
}

if(isset($_POST['email']) && preg_match('/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $_POST['email'])){
    array_push($message, 'ok pour l\'email');
}else{
    array_push($erreur, 'L\'email n\'est pas valide');
}

if(isset($_POST['password']) && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@!#\?])(?=.*[a-zA-Z]).{8,}$/', $_POST['password'])){
    array_push($message, 'ok pour le mdp');
}else{
    array_push($erreur, 'Le mdp n\'est pas valide');
}
// var_dump($message);
// var_dump($erreur);
  
if ($erreur == []) {
    require("./inc/db.php");
    $encrypted_password = hash('sha512', $_POST['password']);
    $request = $pdo->prepare("INSERT INTO utilisateur (login, email, password) VALUES (?,?,?);");
    $request->execute([$_POST['login'], $_POST['email'], $encrypted_password]);
    header("Location: ./index.php");
    exit();
}
?>
<ul>
    <?php
    foreach($message as $value){
        echo "<li>".$value."</li>";
    }
    ?>
</ul>
<ul>
    <?php
    foreach($erreur as $item){
        echo "<li>".$item."</li>";
    }
    ?>
</ul>
</section>
<?php
require("./inc/db.php");

$sql = "SELECT * FROM `article`;";
$request = $pdo->query($sql);
$postsList = $request->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM `utilisateur`;";
$request = $pdo->query($sql);
$usersList = $request->fetchAll(PDO::FETCH_ASSOC);

function fetch_user(int $id, array $usersList) {
    $count = 0;
    foreach ($usersList as $users) {
        if ($users['id'] == $id) {
            return $count;
        }
        $count += 1;
    }
    return -1;
}
?>

<section>
    <h1>Latest news</h1>
    <?php foreach ($postsList as $post): ?>
        <article>
            <?php if ($post["category"] == "news"): ?>
                <h3 class="news">News</h3>
            <?php elseif ($post["category"] == "work"): ?>
                <h3 class="work">Work</h3>
            <?php elseif ($post["category"] == "team"): ?>
                <h3 class="team">Team</h3>
            <?php endif; ?>
            <h2><?= $post["title"] ?></h2>
            <div>
                <img src="images/icon-john.png" alt="">
                <h4><strong>
                        <?php
                        if (($userIndex = fetch_user($post["author"], $usersList)) !== -1) {
                            echo $usersList[$userIndex]['firstname'];
                        } else {
                            echo "Unknown";
                        }
                        ?></strong> le <?= $post["publish_date"] ?></h4>
            </div>
            <p><?= $post["content"] ?></p>
            <a href="./single_article.php?id=<?= $post["id"] ?>">Continue reading</a>
        </article>
    <?php endforeach; ?>
</section>

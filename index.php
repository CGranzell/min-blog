<?php
//Kräver att databas filen körs korrekt, annars stoppas appen
require("databaseconnect.php");
// Inkludera Header
include('header.php');
// Hämtar alla inlägg
$sql = "SELECT * FROM posts";
$statement = $pdo->query($sql);
$posts = $statement->fetchAll();
?>

<!-- Länk till Admin -->
<a class="btn btn-primary" href="../min-blog/admin.php">Admin</a>
<hr class="mx-auto" style="width:70%" , size="6" , color="blue">
<div class="mx-auto" style="width: 50%">
  <h1 class="text-center">My Blog</h1>
  <ul class="list-group">
    <!-- Loppar igenom inläggen -->
    <?php foreach ($posts as $post) : ?>
      <!-- Titel -->
      <li class="list-group-item">
        <h5>
          <?= htmlentities($post['title']) ?>
        </h5>
      </li>
      <!-- Author -->
      <li class="list-group-item">
        <p>
          <b>
            <?= htmlentities($post['author']) ?>
          </b>
        </p>
      </li>
      <!-- Datum -->
      <li class="list-group-item">
        <p>
          <i>
            <?= htmlentities($post['published_date']) ?>
          </i>
        </p>
      </li>
      <!-- Blog Text -->
      <li class="list-group-item">
        <p>
          <?= substr(htmlentities($post['content']), 0, 100) ?>
        </p>
        <!-- Formulär som skickar id till singlepost.php -->
        <form action="../min-blog/singlepost.php" method="GET">
          <input type="hidden" name="postID" value="<?= htmlentities($post['id']) ?>">
          <input class="btn btn-primary btn-read" type="submit" value="Read More">
        </form>
      </li>
      <hr style="width:100%" , size="6" , color="blue">
    <?php endforeach ?>
  </ul>
</div>
<!-- Inkluderar footer -->
<?php include('footer.php'); ?>
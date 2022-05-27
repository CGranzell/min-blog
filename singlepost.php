<?php
//Kräver att databas filen körs korrekt, annars stoppas appen
require("databaseconnect.php");
// Inkludera Header
include('header.php');
// Hämta  ett inlägg
$sql = "
    SELECT * FROM posts
    WHERE id = :id
    ";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['postID']);
$stmt->execute();
$post = $stmt->fetch();

?>

<!-- Länkt till start sida  -->
<a class="btn btn-primary" href="../min-blog/index.php" role="button">Start</a>

<hr class="mx-auto" style="width:70%" , size="6" , color="blue">
<!-- Titel -->
<h1 class="text-center"><?= $post['title']; ?></h1>
<!-- Author -->
<h2 class="text-center"><?= $post['author']; ?></h2>
<!-- Datum -->
<h3 class="text-center"><?= $post['published_date']; ?></h3>
<!-- Blogg inlägg -->
<h4 class="text-center message mx-auto"><i><?= $post['content']; ?></i></h4>

<!-- Inkluderar footer -->
<?php include('footer.php'); ?>
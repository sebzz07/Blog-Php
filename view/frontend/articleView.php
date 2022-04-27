<?php $title = htmlspecialchars($article['title']); ?>

<?php ob_start(); ?>


<!-- Page Header-->
<header class="masthead" style="background-image: url('public/assets/img/post-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="post-heading">
                    <h1><?= htmlspecialchars($article['title']) ?></h1>
                    <span class="meta">
                        Publié par
                        <a href="#!"><?= htmlspecialchars($data['pseudo']) ?></a>
                        le <?= $data['creation_date_fr'] ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Post Content-->
<article class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>

            </div>
        </div>
    </div>
</article>

<h2>Commentaires</h2>

<?php
while ($comment = $comments->fetch()) {
?>
    <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['comment_date_fr'] ?></p>
    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
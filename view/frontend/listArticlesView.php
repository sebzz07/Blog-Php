<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('public/assets/img/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Mon super blog !</h1>
                    <span class="subheading">Derniers billets du blog</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            <?php
            while ($data = $articles->fetch()) {
            ?>
                <!-- Post preview-->
                <div class="post-preview">
                    <a href="index.php?action=post&amp;id=<?= $data['id'] ?>">
                        <h2 class="post-title"><?= htmlspecialchars($data['title']) ?></h2>
                    </a>
                    <p class="post-meta">
                        Posted by
                        <a href="#!"><?= htmlspecialchars($data['pseudo']) ?></a>
                        le <?= $data['creation_date_fr'] ?>
                    </p>
                </div>
                <!-- Divider-->
                <hr class="my-4" />
            <?php
            }
            $articles->closeCursor();
            ?>
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">Older Posts →</a></div>
        </div>
    </div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
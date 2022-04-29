<?php
namespace SebDru\Blog\Controller;
require_once('vendor/autoload.php');
require_once('controller/Controller.php');
require('model/ArticleManager.php');
require('model/CommentManager.php');

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class Frontend extends Controller
{
    public function listArticles()
    {
        $articleManager = new \SebDru\Blog\Model\ArticleManager();
        $articles = $articleManager->getArticles();

        require('view/frontend/listArticlesView.php');
    }

    public function article()
    {
        $articleManager = new \SebDru\Blog\Model\ArticleManager();
        $commentManager = new \SebDru\Blog\Model\CommentManager();

        $article = $articleManager->getItem($_GET['id']);
        $comments = $commentManager->getCommentsOfArticle($_GET['id']);

        require('view/frontend/articleView.php');
    }

    public function addComment($articleId, $userId, $content)
    {
        $commentManager = new \SebDru\Blog\Model\CommentManager();
        $affectedLines = $commentManager->postComment($articleId, $userId, $content);

        if ($affectedLines === false) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $articleId);
        }
    }

    public function about()
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT.'/Blog-Php/view');
        $twig = new \Twig\Environment($loader, ['debug' => true]);
        $twig->display('frontend/about.html.twig');
        
    }

    public function contact()
    {
        require('view/frontend/contact.php');
    }
}
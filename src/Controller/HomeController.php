<?php

namespace AFPA\Controller;

class HomeController
{
    public function home() {
        global $twig;
        echo $twig->render("home.html.twig", [
            "title" => "Page d'accueil"
        ]);
    }
    public function contact() {
        global $twig;
        echo $twig->render("contact.html.twig", [
            "title" => "Contact page"
        ]);
    }
    public function forum() {
        global $twig;
        echo $twig->render("forum/forum.html.twig", [
            "title" => "Forum page"
        ]);
    }

    public function article(string $slug, int $id){
        global $twig;
        echo $twig->render("forum/article.html.twig", [
            "title" => "Article $slug",
            "slug" => $slug,
            "id" => $id
        ]);
    }
}

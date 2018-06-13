<?php

namespace FS\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FootController extends Controller {

    public function indexAction() {
        return $this->render('FSMainBundle:Foot:index.html.twig');
    }

    public function matchesAction() {
        return $this->render('FSMainBundle:Foot:matches.html.twig');
    }

    public function standingAction() {
        return $this->render('FSMainBundle:Foot:standing.html.twig');
    }

    public function topplayersAction() {
        return $this->render('FSMainBundle:Foot:topplayers.html.twig');
    }
    
    public function favoritesAction() {
        return $this->render('FSMainBundle:Foot:favorites.html.twig');
    }
}

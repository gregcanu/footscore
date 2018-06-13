<?php

namespace FS\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FSMainBundle:Default:index.html.twig');
    }
}

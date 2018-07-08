<?php

namespace FS\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FS\MainBundle\Form\SeasonType;
use Symfony\Component\HttpFoundation\Request;

class FootController extends Controller {

    public function indexAction() {
        return $this->render('FSMainBundle:Foot:index.html.twig');
    }

    public function matchesAction() {
        return $this->render('FSMainBundle:Foot:matches.html.twig');
    }

    public function standingAction($season, Request $request) {
        $form = $this->createForm(SeasonType::class, array('season' => $season));
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('fs_main_standing', array('season' => $data['season']));
        }
        
        $tsdb = $this->get('app.tsdb');
        $standing = $tsdb->getStanding($season);

        return $this->render('FSMainBundle:Foot:standing.html.twig', array(
                    'form' => $form->createView(),
                    'standing' => $standing,
                    'season' => $season
        ));
    }

    public function topplayersAction() {
        return $this->render('FSMainBundle:Foot:topplayers.html.twig');
    }

    public function favoritesAction() {
        return $this->render('FSMainBundle:Foot:favorites.html.twig');
    }

}

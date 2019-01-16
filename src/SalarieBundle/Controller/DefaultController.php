<?php

namespace SalarieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@Salarie/default/index_accueil_manager.html.twig', array(
            'base_dir' => "coucou",
        ));
    }
} 

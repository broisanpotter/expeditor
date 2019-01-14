<?php

namespace SalarieBundle\Controller;

use SalarieBundle\Entity\Articles_Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Articles_commande controller.
 *
 * @Route("articles_commande")
 */
class Articles_CommandeController extends Controller
{
    /**
     * Lists all articles_Commande entities.
     *
     * @Route("/", name="articles_commande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles_Commandes = $em->getRepository('SalarieBundle:Articles_Commande')->findAll();

        return $this->render('@Salarie/articles_commande/index.html.twig', array(
            'articles_Commandes' => $articles_Commandes,
        ));
    }



    /**
     * Finds and displays a articles_Commande entity.
     *
     * @Route("/{id}", name="articles_commande_show")
     * @Method("GET")
     */
    public function showAction(Articles_Commande $articles_Commande)
    {
        $deleteForm = $this->createDeleteForm($articles_Commande);

        return $this->render('@Salarie/articles_commande/show.html.twig', array(
            'articles_Commande' => $articles_Commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }


}

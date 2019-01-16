<?php

namespace SalarieBundle\Controller;

use SalarieBundle\Entity\Articles_Commande;
use SalarieBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 * @Route("commande")
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     * @Route("/", name="commande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('SalarieBundle:Commande')->findAll();

        return $this->render('@Salarie/commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }


    /**
     * Finds and displays a commande entity.
     *
     * @Route("/{id}", name="commande_show")
     * @Method("GET")
     */
    public function showAction(Commande $commande)
    {
        $poidsTotalCommande =0;
        $em = $this->getDoctrine()->getManager();
        $articlesCommandes = $em->getRepository('SalarieBundle:Articles_Commande')->findBy(array('commande' => $commande->getId()));

        foreach ($articlesCommandes as $articlesCommande) {
                $poidsTotalCommande=$poidsTotalCommande+$articlesCommande->getPoidsTotal();
        }

        $poidsTotalCommandeAvecCarton = 300 + $poidsTotalCommande;
        $commande->setPoidsTotal($poidsTotalCommande);
        $commande->setPoidsTotalAvecCarton($poidsTotalCommandeAvecCarton);

        return $this->render('@Salarie/commande/show.html.twig', array(
            'commande' => $commande,
            'articlesCommande' => $articlesCommandes,
            ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     * @Route("/{id}/edit", name="commande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commande $commande)
    {
        $editForm = $this->createForm('SalarieBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('@Salarie/commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
        ));
    }

}

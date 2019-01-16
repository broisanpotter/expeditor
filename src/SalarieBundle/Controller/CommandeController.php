<?php

namespace SalarieBundle\Controller;

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

        $newCommandes =array();
        $key = 0;

        foreach ($commandes as $commande) {
            if ($commande->getEtat() != 2) {
                $client = $em->getRepository('SalarieBundle:Client')->find($commande->getClient());
                $commande->setClient($client);

                if ($commande->getEmploye() != null) {
                    $employe = $em->getRepository('SalarieBundle:Employe')->find($commande->getEmploye());
                    $commande->setEmploye($employe);
                }
                $newCommandes[$key] = $commande;
                $key++;
            }
        }

        return $this->render('@Salarie/commande/index_accueil_manager.html.twig', array(
            'commandes' => $newCommandes,
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
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('@Salarie/commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
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
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('SalarieBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('@Salarie/commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

}

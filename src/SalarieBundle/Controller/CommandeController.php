<?php

namespace SalarieBundle\Controller;

use SalarieBundle\Entity\Articles_Commande;
use SalarieBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function showAction(Request $request, Commande $commande)
    {
        $poidsTotalCommande =0;
        $em = $this->getDoctrine()->getManager();
        $articlesCommandes = $em->getRepository('SalarieBundle:Articles_Commande')->findBy(array('commande' => $commande->getId()));
        $client = $em->getRepository('SalarieBundle:Client')->find($commande->getClient());

        foreach ($articlesCommandes as $articlesCommande) {
            $article = $em->getRepository('SalarieBundle:Article')->find($articlesCommande->getArticle());
            $articlesCommande->setArticle($article);
            $poidsTotalCommande=$poidsTotalCommande+$articlesCommande->getPoidsTotal();
        }

        $poidsTotalCommandeAvecCarton = 300 + $poidsTotalCommande;
        $commande->setPoidsTotal($poidsTotalCommande);
        $commande->setPoidsTotalAvecCarton($poidsTotalCommandeAvecCarton);

        return $this->render('@Salarie/commande/show.html.twig', array(
            'commande' => $commande,
            'client' => $client,
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


    /**
     * Displays a form to edit an existing commande entity.
     *
     * @Route("/validate/{commande}/{employe}", name="validate_commande")
     * @Method({"GET", "POST"})
     */
    public function validateAndRedirectAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        if(!$request->get('employe') || !$request->get('commande')) {
            return false;
        }

        // MAJ Etat + Employe + Date
        $commandeValidate = $em->getRepository('SalarieBundle:Commande')->findOneBy(array('id' => $request->get('commande')));
        $commandeValidate->setEtat(Commande::TRAITEE);
        $commandeValidate->setDateValidation((new \DateTime()));
        $commandeValidate->setEmploye($request->get('employe'));
        $em->flush();

        // MAJ Etat + Employe
        $nextCommande = $em->getRepository('SalarieBundle:Commande')->findOneBy(array('etat' => 0));
        $nextCommande->setEtat(Commande::EN_COURS_DE_TRAITEMENT);
        $nextCommande->setEmploye($request->get('employe'));


        $em->flush();

        $session = $request->getSession();

        return $this->redirectToRoute('commande_show', array(
            'session' => $session,
            'id' => $nextCommande->getId(),
        ));
    }



}

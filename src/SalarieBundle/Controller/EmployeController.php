<?php

namespace SalarieBundle\Controller;

use SalarieBundle\Entity\Commande;
use SalarieBundle\Entity\Employe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;


/**
 * Employe controller.
 *
 * @Route("employe")
 */
class EmployeController extends Controller
{
    const STATUT_VALIDE = 2;
    /**
     * Lists all employe entities.
     *
     * @Route("/", name="employe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        $employes = $em->getRepository('SalarieBundle:Employe')->findAll();

        foreach ($employes as $employe) {
            $commande = $em->getRepository(Commande::class);
            $listCommandes = $commande->findAll(array('employe' => $employe->getId(), 'etat' => self::STATUT_VALIDE));

            if($listCommandes != null) {

                $dateDay = new \DateTime();
                $currentDay = $dateDay->format('Y-m-d');
                $count = 0;
                foreach ($listCommandes as $commande) {

                    if($commande->getDateValidation() && $commande->getDateValidation()->format('Y-m-d') == $currentDay) {
                        $count +=1;
                    }
                }
                $employe->setNombreCommandeQuotidien($count);
            }
        }

        return $this->render('@Salarie/employe/index_gestion_employe.html.twig', array(
            'employes' => $employes,
        ));
    }

    /**
     * Creates a new employe entity.
     *
     * @Route("/new", name="employe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $employe = new Employe();
        $form = $this->createForm('SalarieBundle\Form\EmployeType', $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employe);
            $em->flush();

            return $this->redirectToRoute('employe_index');
        }

        return $this->render('@Salarie/employe/new.html.twig', array(
            'employe' => $employe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing employe entity.
     *
     * @Route("/{id}/edit", name="employe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Employe $employe)
    {
        $deleteForm = $this->createDeleteForm($employe);
        $editForm = $this->createForm('SalarieBundle\Form\EmployeType', $employe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employe_index');
        }

        return $this->render('@Salarie/employe/edit.html.twig', array(
            'employe' => $employe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a employe entity.
     *
     * @Route("/delete/{id}", name="employe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Employe $employe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($employe);
        $em->flush();

        return $this->redirectToRoute('employe_index');
    }

    /**
     * Creates a form to delete a employe entity.
     *
     * @param Employe $employe The employe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Employe $employe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employe_delete', array('id' => $employe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

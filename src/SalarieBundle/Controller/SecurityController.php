<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 15/01/2019
 * Time: 10:41
 */

namespace SalarieBundle\Controller;
use SalarieBundle\Entity\Commande;
use SalarieBundle\Entity\Employe;
use SalarieBundle\Entity\Security;
use SalarieBundle\Form\SecurityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;


class SecurityController extends Controller
{

    const MANAGER = 1;
    const EMPLOYE = 0;

    /**
     *
     * @Route("/login", name="login")
     * @Method("GET")
     */
    public function accueilAction(Request $request) {

        $session = $request->getSession();

        if(!$session) {
            $session = new Session();
        }

        $em = $this->getDoctrine()->getManager();
        $employes = $em->getRepository('SalarieBundle:Employe')->findAll();

        if(!empty($session->get('id'))) {
            return $this->render('@Salarie/employe/index.html.twig', array(
                'employes' => $employes,
                'session' => $session,
            ));
        }

        $form = $this->generateForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $userSecurity = new Security();
            $userSecurity->setAdresseMail($task->email);
            $userSecurity->setPassword($task->password);


            $employe = $em->getRepository(Employe::class);
            $securedUser = $employe->findOneBy(array('mail' => $userSecurity->getAdresseMail(), 'password' => $userSecurity->getPassword()));

            if($securedUser != null) {
                $session->start();
                $session->set('id', $securedUser->getId());
                $session->set('statut', $securedUser->isManager());

                // Statut MANAGER
                if($session->get('statut') === self::MANAGER) {
                    return $this->redirectToRoute('employe_index');
                }

                // Statut EMPLOYE
                else {
                    $nextCommande = $this->getNextCommandeAction($securedUser->getId());

                    // Get commande
                    if($nextCommande) {
                        return $this->redirectToRoute('commande_show', array(
                            'id' => $nextCommande,
                            'statut' => 'success'
                        ));
                    }

                    // No commande
                    else {
                        return $this->redirectToRoute('commande_show', array(
                            'id' => 0,
                            'statut' => 'error',
                        ));
                    }
                }
            }

            return $this->render('@Salarie/security/login.html.twig', array(
                'form' => $form->createView(),
                'statut' => 'error'
            ));
        }

        return $this->render('@Salarie/security/login.html.twig', array(
            'form' => $form->createView(),
        ));

    }


    /**
     *
     * @Route("/logout", name="deconnexion")
     * @Method("GET")
     */
    public function logoutAction(Request $request) {

        $session = $request->getSession();
        $session->invalidate();

        return $this->redirectToRoute('login');
    }


    public function  generateForm() {
        $task = new SecurityType();
        $task->setEmail((''));
        $task->setPassword('');

        $form = $this->createFormBuilder($task)
            ->add('email', TextType::class, array('label' => 'Mail'))
            ->add('password', PasswordType::class, array('label' => 'Mot de passe'))
            ->add('save', SubmitType::class, array('label' => 'Connexion'))
            ->getForm();

        return $form;
    }

    private function getNextCommandeAction($employeId) {

        $em = $this->getDoctrine()->getManager();
        $nextCommandeEnCours = $em->getRepository('SalarieBundle:Commande')->findOneBy(array('etat' => 1, 'employe' => $employeId));
        $nextCommandeEnAttente = $em->getRepository('SalarieBundle:Commande')->findOneBy(array('etat' => 0));

        if($nextCommandeEnCours) {
            return $nextCommandeEnCours->getId();
        }

        if($nextCommandeEnAttente) {
            $nextCommandeEnAttente->setEtat(Commande::EN_COURS_DE_TRAITEMENT);
            $nextCommandeEnAttente->setEmploye($employeId);
            $em->flush();

            return $nextCommandeEnAttente->getId();
        }

        else {
            return false;
        }

    }





}
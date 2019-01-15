<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 15/01/2019
 * Time: 10:41
 */

namespace SalarieBundle\Controller;
use SalarieBundle\Entity\Employe;
use SalarieBundle\Entity\Security;
use SalarieBundle\Form\SecurityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SecurityController extends Controller
{

    /**
     *
     * @Route("/login", name="accueil")
     * @Method("GET")
     */
    public function accueilAction(Request $request) {

        $task = new SecurityType();
        $task->setEmail(('Adresse email'));
        $task->setPassword('mdp');

        $form = $this->createFormBuilder($task)
            ->add('email', TextType::class)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Login'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $userSecurity = new Security();
            $userSecurity->setAdresseMail($task->email);
            $userSecurity->setPassword($task->password);


            $employe = $em->getRepository(Employe::class);
            $securedUser = $employe->findOneBy(array('mail' => $userSecurity->getAdresseMail(), 'password' => $userSecurity->getPassword()));

            if($securedUser != null) {
                $employes = $em->getRepository('SalarieBundle:Employe')->findAll();

                return $this->render('@Salarie/employe/index.html.twig', array(
                    'employes' => $employes,
                ));
            }

            return $this->render('@Salarie/security/login.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        return $this->render('@Salarie/security/login.html.twig', array(
            'form' => $form->createView(),
        ));



    }



}
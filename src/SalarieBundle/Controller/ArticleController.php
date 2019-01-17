<?php

namespace SalarieBundle\Controller;

use SalarieBundle\Entity\Article;
use SalarieBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Article controller.
 *
 * @Route("article")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="article_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('SalarieBundle:Article')->findAll();

        return $this->render('@Salarie/article/index_gestion_employe.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Creates a new article entity.
     *
     * @Route("/new", name="article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->generateForm();
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setPoids($form->getData()->poids);
            $article->setLibelle($form->getData()->libelle);
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('@Salarie/article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->generateFormEdit($article);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $article->setPoids($editForm->getData()->poids);
            $article->setLibelle($editForm->getData()->libelle);
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('@Salarie/article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/delete/{id}", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function  generateForm() {

        $task = new ArticleType();
        $task->setLibelle((''));
        $task->setPoids('');

        $form = $this->createFormBuilder($task)
            ->add('libelle', TextType::class, array('label' => 'Libelle'))
            ->add('poids', TextType::class, array('label' => 'Poids (en grammes)'))
            ->getForm();

        return $form;
    }

    public function  generateFormEdit(Article $article) {

        $task = new ArticleType();
        $task->setLibelle(($article->getLibelle()));
        $task->setPoids($article->getPoids());

        $form = $this->createFormBuilder($task)
            ->add('libelle', TextType::class, array('label' => 'Libelle'))
            ->add('poids', TextType::class, array('label' => 'Poids (en grammes)'))
            ->getForm();

        return $form;
    }
}

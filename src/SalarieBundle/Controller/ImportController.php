<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 15/01/2019
 * Time: 10:35
 */

namespace SalarieBundle\Controller;

use SalarieBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SalarieBundle\Entity\Article;
use SalarieBundle\Controller\ArticleController;
use Symfony\Component\HttpFoundation\Response;
use SalarieBundle\Entity\Employe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Import controller.
 *
 * @Route("import")
 */
class ImportController extends Controller
{
    /**
     * Import Commande.
     *
     * @Route("/", name="import_index")
     * @Method("GET")
     */
     public function importAction()
     {
         $clients = array();
         $artilesCommande = array();
         $commande = array();
         $tableau = array();
         $row = 0;

         $myArticle = $this->getArticle("Alimentation");
         var_dump($myArticle);

         // Import du fichier CSV
         if (($handle = fopen(__DIR__ . "/../../../app/Resources/uploads/donneesCommandes2.csv", "r")) !== FALSE) { // Lecture du fichier, à adapter
             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Eléments séparés par un point-virgule, à modifier si necessaire
                 $num = count($data); // Nombre d'éléments sur la ligne traitée
                 $row++;
                 var_dump($row);
                 for ($c = 0; $c < $num; $c++) {
                     $tableau[$row] = array(
                         "date" => $data[0],
                         "num" => $data[1],
                         "client" => $data[2],
                         "adresse" => $data[3],
                         "articles" => $data[4]
                    );
                 }
             }
             fclose($handle);

             var_dump($tableau[2]);
             var_dump($tableau[3]);
             var_dump($tableau[4]);
             die();
         }
     }

    /**
     * Get Article Object with libell
     *
     * @param $libelle
     * @return Article|null
     * @Route("/libelle/{libelle}", name="import_article")
     * @Method("GET")
     */
    public function getArticle($libelle)
    {
        $myArticle = null;
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('SalarieBundle:Article')->findAll();
        foreach ($articles as $article) {
            if ($article instanceof Article) {
                if ($article->getLibelle() == $libelle) {
                    $myArticle = $article;
                }
            }
        }
        //var_dump($myArticle);
        return $myArticle;
    }

    /**
     * Get Article Object with libell
     *
     * @param $libelle
     * @return Article|null
     * @Route("/client/{nom}", name="import_client")
     * @Method("GET")
     */
    public function getClient($nom)
    {
        $myClient = null;
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('SalarieBundle:Client')->findAll();
        foreach ($clients as $client) {
            if ($client instanceof Client) {
                if ($client->getNom() == $nom) {
                    $myClient = $client;
                }
            }
        }
        var_dump($myClient);
        return $myClient;
    }

}
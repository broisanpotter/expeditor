<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 15/01/2019
 * Time: 10:35
 */

namespace SalarieBundle\Controller;

use SalarieBundle\Entity\Articles_Commande;
use SalarieBundle\Entity\Client;
use SalarieBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SalarieBundle\Entity\Article;
use Symfony\Component\Validator\Constraints\DateTime;
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
         $artilesCommande = array();
         $commandes = array();
         $tableau = array();
         $row = 0;
         $carton = 300;

         $em = $this->getDoctrine()->getManager();

         // Import du fichier CSV
         if (($handle = fopen(__DIR__ . "/../../../app/Resources/uploads/donneesCommandes1.csv", "r")) !== FALSE) { // Lecture du fichier, à adapter
             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Eléments séparés par un point-virgule, à modifier si necessaire
                 $num = count($data); // Nombre d'éléments sur la ligne traitée

                 for ($c = 0; $c < $num; $c++) {
                     $tableau[$row] = array(
                         "date" => $data[0],
                         "num" => $data[1],
                         "client" => $data[2],
                         "adresse" => $data[3],
                         "articles" => $data[4]
                    );
                 }

                 if ($tableau[$row]["date"] != "Date de Commande") {
                     $commande = new Commande();
                     $nomClient = $tableau[$row]["client"];
                     $adresseClient = explode(" - ", $tableau[$row]["adresse"]);
                     $client = $this->getClient($nomClient, $adresseClient[0]);
                     $dateCommande = explode(" ", $tableau[$row]["date"]);
                     $idCommande = substr($tableau[$row]["num"], 8,2);
                     $commande->setId(intval($idCommande));
                     $commande->setDate(new \DateTime($dateCommande[0]));
                     $commande->setClient($client->getId());
                     $commande->setEmploye(null);
                     $commande->setEtat(Commande::EN_ATTENTE);
                     $listArticles = $tableau[$row]["articles"];
                     $newListArticles = explode(";", $listArticles);

                     $em->persist($commande);
                     $em->flush();

                     $newCommande = $em->getRepository('SalarieBundle:Commande')->findOneBy(array("client" => $commande->getClient()), array('id' => 'DESC'));

                     $poidsTotal = 0;

                     foreach ($newListArticles as $key => $newListArticle) {
                         $articletxt = explode("(", $newListArticle);
                         $nomArticle= trim(substr($articletxt[0], 0, -1));
                         $quantite = trim($articletxt[1], ")");
                         $myArticle = $this->getArticle($nomArticle);
                         $articlesCommande = new Articles_Commande($newCommande->getId(), $myArticle->getId(), intval($quantite), $quantite*$myArticle->getPoids());
                         $poidsTotal = $poidsTotal+$articlesCommande->getPoidsTotal();
                         $artilesCommande[$key] = $articlesCommande;

                         $em->persist($articlesCommande);
                     }
                     $newCommande->setListArticlesCommande($artilesCommande);
                     $newCommande->setPoidsTotal($poidsTotal);
                     $newCommande->setPoidsTotalAvecCarton($poidsTotal+$carton );

                     var_dump($newCommande);
                     $em->flush();
                 }
                 $row++;
             }
             fclose($handle);
             var_dump("ferme ta guele.. et va cherhcer des bieres");
             $em->flush();
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
        $myArticle = $em->getRepository('SalarieBundle:Article')->findOneBy(array("libelle" => $libelle));
        return $myArticle;
    }

    /**
     * Get Client with nom
     *
     * @param $libelle
     * @return Article|null
     * @Route("/client/{nom}", name="import_client")
     * @Method("GET")
     */
    public function getClient($nomClient, $adresseClient)
    {
        $myClient = null;
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('SalarieBundle:Client')->findOneBy(array("nom" => $nomClient, "adresse" => $adresseClient));
        if ($client instanceof Client) {
            $myClient = $client;
        }
        return $myClient;
    }

}
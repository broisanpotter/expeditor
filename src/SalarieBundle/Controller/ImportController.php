<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 15/01/2019
 * Time: 10:35
 */

namespace SalarieBundle\Controller;

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
         $clients = array();
         $artilesCommande = array();
         $commandes = array();
         $tableau = array();
         $row = 0;

         $em = $this->getDoctrine()->getManager();

         // Import du fichier CSV
         if (($handle = fopen(__DIR__ . "/../../../app/Resources/uploads/donneesCommandes2.csv", "r")) !== FALSE) { // Lecture du fichier, à adapter
             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Eléments séparés par un point-virgule, à modifier si necessaire
                 $num = count($data); // Nombre d'éléments sur la ligne traitée

             var_dump("ligne");
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

                 var_dump($tableau[$row]);

                 if ($tableau[$row]["date"] != "Date de Commande") {
                     $commande = new Commande();
                     $nomClient = $tableau[$row]["client"];
                     $adresseClient = explode(" - ", $tableau[$row]["adresse"]);
                     $client = $this->getClient($nomClient, $adresseClient[0]);
                     $dateCommande = explode(" ", $tableau[$row]["date"]);
                     $idCommande = substr($tableau[$row]["num"], 8,2);
                     $commande->setId(intval($idCommande));
                     $commande->setDate(new DateTime());
                     $commande->setClient($client->getId());
                     $commande->setEmploye(null);
                     //TODO
                     ////Const => 0
                     $commande->setEtat(0);

                     var_dump($client);
                     var_dump($commande);

                     $em->persist($commande);
                     $em->flush();


                 }
                 $row++;
                 die();
             }
             fclose($handle);
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
        $client = $em->getRepository('SalarieBundle:Client')->findOneBy(array("nom" => $nomClient));
        if ($client instanceof Client) {
            if ($client->getAdresse() != $adresseClient) {
                //new client
            }
            else {
                $myClient = $client;
            }
        }
        else {
            //new client
        }

        return $myClient;
    }

}
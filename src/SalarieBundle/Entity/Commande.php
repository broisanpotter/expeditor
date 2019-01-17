<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 14/01/2019
 * Time: 14:10
 */

namespace SalarieBundle\Entity;

use SalarieBundle\Entity\Employe;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Commande
 * @package SalarieBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="commande")
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="date") */
    public $date;

    /** @ORM\Column(type="string") */
    public $client;

    /** @ORM\Column(type="string") */
    public $employe;

    /** @ORM\Column(type="integer") */
    public $etat;

    public $listArticles_Commande;


    /**
     * @return mixed
     */
    public function getEmploye()
    {
        return $this->employe;
    }

    /**
     * @param mixed $employe
     */
    public function setEmploye($employe)
    {
        $this->employe = $employe;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getListArticlesCommande()
    {
        return $this->listArticles_Commande;
    }

    /**
     * @param mixed $listArticles_Commande
     */
    public function setListArticlesCommande(Articles_Commande $listArticles_Commande)
    {
        $this->listArticles_Commande = $listArticles_Commande;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }



}
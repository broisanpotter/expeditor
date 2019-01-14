<?php
///**
// * Created by PhpStorm.
// * User: Administrateur
// * Date: 14/01/2019
// * Time: 14:10
// */
//
//namespace SalarieBundle\Entity;
//
//use SalarieBundle\Entity\Employe;
//
//
//class Commande
//{
//    public $id;
//    public $date;
//    public $client;
//    public $employe;
//    public $etat;
//    public $listArticles_Commande;
//
//
//    /**
//     * @return mixed
//     */
//    public function getEmploye()
//    {
//        return $this->employe;
//    }
//
//    /**
//     * @param mixed $employe
//     */
//    public function setEmploye(Employe $employe)
//    {
//        $this->employe = $employe;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getEtat()
//    {
//        return $this->etat;
//    }
//
//    /**
//     * @param mixed $etat
//     */
//    public function setEtat(string $etat)
//    {
//        $this->etat = $etat;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getListArticlesCommande()
//    {
//        return $this->listArticles_Commande;
//    }
//
//    /**
//     * @param mixed $listArticles_Commande
//     */
//    public function setListArticlesCommande(Articles_Commande $listArticles_Commande)
//    {
//        $this->listArticles_Commande = $listArticles_Commande;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * @param mixed $id
//     */
//    public function setId(int $id)
//    {
//        $this->id = $id;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getDate()
//    {
//        return $this->date;
//    }
//
//    /**
//     * @param mixed $date
//     */
//    public function setDate(Date $date)
//    {
//        $this->date = $date;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getClient()
//    {
//        return $this->client;
//    }
//
//    /**
//     * @param mixed $client
//     */
//    public function setClient(Client $client)
//    {
//        $this->client = $client;
//    }
//
//
//
//}
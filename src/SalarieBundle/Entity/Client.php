<?php
///**
// * Created by PhpStorm.
// * User: Administrateur
// * Date: 14/01/2019
// * Time: 14:11
// */
//
//namespace SalarieBundle\Entity;
//
///**
// * Class Client
// * @package SalarieBundle\Entity
// * @Entity
// * @Table(name="client")
// */
//class Client
//{
//    /**
//     * @Id
//     * @Colum(type="integer")
//     * @GeneratedValue
//     */
//    public $id;
//    public $nom;
//    public $adresse;
//    public $codePostal;
//    public $ville;
//
//    /**
//     * Client constructor.
//     * @param $id
//     * @param $nom
//     * @param $adresse
//     * @param $codePostal
//     * @param $ville
//     */
//    public function __construct($id, $nom, $adresse, $codePostal, $ville)
//    {
//        $this->setId($id);
//        $this->setNom($nom);
//        $this->setadresse($adresse);
//        $this->setCodePostal($codePostal);
//        $this->setVille($ville);
//    }
//
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
//    public function setId($id)
//    {
//        $this->id = $id;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getNom()
//    {
//        return $this->nom;
//    }
//
//    /**
//     * @param mixed $nom
//     */
//    public function setNom($nom)
//    {
//        $this->nom = $nom;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getadresse()
//    {
//        return $this->adresse;
//    }
//
//    /**
//     * @param mixed $adresse
//     */
//    public function setadresse($adresse)
//    {
//        $this->adresse = $adresse;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getCodePostal()
//    {
//        return $this->codePostal;
//    }
//
//    /**
//     * @param mixed $codePostal
//     */
//    public function setCodePostal($codePostal)
//    {
//        $this->codePostal = $codePostal;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getVille()
//    {
//        return $this->ville;
//    }
//
//    /**
//     * @param mixed $ville
//     */
//    public function setVille($ville)
//    {
//        $this->ville = $ville;
//    }
//
//
//}
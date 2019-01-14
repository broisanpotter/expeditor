<?php
///**
// * Created by PhpStorm.
// * User: Administrateur
// * Date: 14/01/2019
// * Time: 14:03
// */
//
//namespace SalarieBundle\Entity;
//
///**
// * Class Employe
// * @package SalarieBundle\Entity
// * @Entity
// * @Table(name="employe")
// */
//class Employe
//{
//    /**
//     * @Id
//     * @Colum(type="integer")
//     * @GeneratedValue
//     */
//    public $id;
//    /** @Colum(type="varchar") */
//    public $nom;
//    /** @Colum(type="varchar") */
//    public $prenom;
//    /** @Colum(type="int") */
//    public $manager;
//
//    /**
//     * Employe constructor.
//     * @param $id
//     * @param $nom
//     * @param $prenom
//     * @param $manager
//     */
//    public function __construct($nom, $prenom, $manager)
//    {
//        $this->setNom($nom);
//        $this->setPrenom($prenom);
//        $this->setManager($manager);
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
//    public function getPrenom()
//    {
//        return $this->prenom;
//    }
//
//    /**
//     * @param mixed $prenom
//     */
//    public function setPrenom($prenom)
//    {
//        $this->prenom = $prenom;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function isManager()
//    {
//        return $this->manager;
//    }
//
//    /**
//     * @param mixed $isManager
//     */
//    public function setManager($manager)
//    {
//        $this->manager = $manager;
//    }
//}
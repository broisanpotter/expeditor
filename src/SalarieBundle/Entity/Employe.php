<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 14/01/2019
 * Time: 14:03
 */

namespace SalarieBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Employe
 * @package SalarieBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="employe")
 */
class Employe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="string") */
    public $nom;

    /** @ORM\Column(type="string") */
    public $prenom;

    /** @ORM\Column(type="integer") */
    public $manager;

    public function __construct()
    {
        $this->setNom("");
        $this->setPrenom("");
        $this->setManager(0);
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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function isManager()
    {
        return $this->manager;
    }

    /**
     * @param mixed $isManager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }
}
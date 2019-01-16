<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 14/01/2019
 * Time: 14:15
 */

namespace SalarieBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 * @package SalarieBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="string") */
    public $libelle;

    /** @ORM\Column(type="integer") */
    public $poids;

    /**
     * Article constructor.
     * @param $id
     * @param $libelle
     * @param $poids
     */
    public function __construct()
    {
        $this->setLibelle("");
        $this->setPoids(0);
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
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return mixed
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * @param mixed $poids
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
    }


}
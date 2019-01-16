<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 14/01/2019
 * Time: 14:11
 */

namespace SalarieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Client
 * @package SalarieBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="client")
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $nom;

    /**
     * @ORM\Column(type="string")
     */
    public $adresse;

    /**
     * @ORM\Column(type="string")
     */
    public $codePostal;

    /**
     * @ORM\Column(type="string")
     */
    public $ville;

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
    public function getadresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setadresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }


}
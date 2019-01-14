<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 14/01/2019
 * Time: 14:15
 */

namespace SalarieBundle\Entity;


class Article
{
    public $id;
    public $libelle;
    public $poids;

    /**
     * Article constructor.
     * @param $id
     * @param $libelle
     * @param $poids
     */
    public function __construct($id, $libelle, $poids)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
        $this->setPoids($poids);
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
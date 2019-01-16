<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 15/01/2019
 * Time: 10:59
 */

namespace SalarieBundle\Entity;


class Security
{

    public $adresseMail;
    public $password;


    /**
     * @return mixed
     */
    public function getAdresseMail()
    {
        return $this->adresseMail;
    }

    /**
     * @param mixed $adresseMail
     */
    public function setAdresseMail($adresseMail)
    {
        $this->adresseMail = $adresseMail;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }




}
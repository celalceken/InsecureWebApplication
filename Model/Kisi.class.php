<?php

/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 23.10.2015
 * Time: 00:35
 */

namespace cc;
abstract class Kisi
{

    protected $adi;
    protected $soyadi;
    private $bolum;


    /**
     * @return mixed
     */
    public function getAdi()
    {
        return $this->adi;
    }

    /**
     * @param mixed $adi
     */
    public function setAdi($adi)
    {
        $this->adi = $adi;
    }

    /**
     * @return mixed
     */
    public function getSoyadi()
    {
        return $this->soyadi;
    }

    /**
     * @param mixed $soyadi
     */
    public function setSoyadi($soyadi)
    {
        //filter_var($input, FILTER_SANITIZE_STRING); //FILTER_SANITIZE_ENCODED;
        $this->soyadi = filter_var($soyadi,FILTER_SANITIZE_ENCODED);
        //$this->soyadi=$soyadi;
    }

    /**
     * @return mixed
     */
    public function getBolum()
    {
        return $this->bolum;
    }

    /**
     * @param mixed $bolum
     */
    public function setBolum($bolum)
    {
        $this->bolum = $bolum;
    }





  /*  function __construct($adi, $soyadi)
    {
        $this->setAdi($adi);
        $this->setSoyadi($soyadi);
    }*/

    /**
     * @param mixed $adres
     */

    public function __set($prop, $val) {
        $this->$prop = $val;
    }
    public function __get($prop) {
        return $this->$prop;
    }



/*
    public function kisiListele()
    {
        //echo "$this->ad.$this->soyad";

        return "{$this->getAd()}"."{$this->getSoyad()}";
    }*/


}
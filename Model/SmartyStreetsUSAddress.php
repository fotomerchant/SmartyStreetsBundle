<?php

namespace blackknight467\SmartyStreetsBundle\Model;

class SmartyStreetsUSAddress implements SmartyStreetsUSAddressInterface
{
    private $street;

    private $city;

    private $state;

    private $zipCode;

    private $addressee;

    /**
     * @inheritdoc
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * Set the street
     *
     * @param $street
     * @return SmartyStreetsUSAddress
     */
    public function setStreet($street) {
        $this->street = $street;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set the city
     *
     * @param $city
     * @return SmartyStreetsUSAddress
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Set the state
     *
     * @param $state
     * @return SmartyStreetsUSAddress
     */
    public function setState($state) {
        $this->state = $state;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getZipCode() {
        return $this->zipCode;
    }

    /**
     * Set the zipCode
     *
     * @param $zipCode
     * @return SmartyStreetsUSAddress
     */
    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAddressee() {
        return $this->addressee;
    }

    /**
     * Set the addressee
     *
     * @param string $addressee
     * @return SmartyStreetsUSAddress
     */
    public function setAddressee($addressee) {
        $this->addressee = $addressee;

        return $this;
    }
}
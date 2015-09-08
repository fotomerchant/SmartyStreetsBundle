<?php

namespace blackknight467\SmartyStreetsBundle\Model;

interface SimpleSmartyStreetsUSAddressInterface
{
    /**
     * Get the street value to pass to smarty streets
     *
     * @return string
     */
    public function getStreet();
}
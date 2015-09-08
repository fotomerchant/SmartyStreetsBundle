<?php

namespace blackknight467\SmartyStreetsBundle\Model;

interface SimpleSmartyStreetsUSZipCodeInterface
{
    /**
     * Get the zipcode value to pass to smarty streets
     *
     * @return string
     */
    public function getZipCode();
}
<?php

namespace blackknight467\SmartyStreetsBundle\Model;

interface SmartyStreetsUSAddressInterface extends SimpleSmartyStreetsUSAddressInterface, SmartyStreetsUSZipcodeInterface
{
    /**
     * Get the addressee to pass to smarty streets
     *
     * @return string
     */
    public function getAddressee();
}
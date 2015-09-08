<?php

namespace blackknight467\SmartyStreetsBundle\Model;

interface SmartyStreetsUSZipcodeInterface extends SimpleSmartyStreetsUSZipCodeInterface
{
    /**
     * Get the city value to pass to smarty streets
     *
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getState();
}
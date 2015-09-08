<?php

namespace blackknight467\SmartyStreetsBundle\Model;

interface AdvancedSmartyStreetsUSAddressInterface extends SmartyStreetsUSAddressInterface
{
    /**
     * Get the street2 value to pass to smarty streets
     *
     * @return string
     */
    public function getStreet2();

    /**
     * Get the secondary value to pass to smarty streets
     *
     * @return string
     */
    public function getSecondary();

    /**
     * Get the lastline value to pass to smarty streets
     *
     * @return string
     */
    public function getLastLine();

    /**
     * Get the urbanization value to pass to smarty streets
     *
     * @return string
     */
    public function getUrbanization();
}
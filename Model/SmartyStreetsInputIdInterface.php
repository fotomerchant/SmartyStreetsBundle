<?php

namespace blackknight467\SmartyStreetsBundle\Model;

interface SmartyStreetsInputIdInterface
{
    /**
     * Get the input_id value to pass to smarty streets
     *
     * @return string
     */
    public function getInputId();
}
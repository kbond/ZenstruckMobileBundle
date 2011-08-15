<?php

namespace Zenstruck\Bundle\MobileBundle\Manager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class MobileManager
{
    protected $mobile;

    public function __construct()
    {
        $this->mobile = false;
    }

    /**
     * @return boolean
     */
    public function isMobile()
    {
        return (bool) $this->mobile;
    }

    /**
     *
     * @return string/boolean
     */
    public function getMobile()
    {
        if ($this->mobile === true) {
            return 'mobile';
        }

        return $this->mobile;
    }

    /**
     * @param string/boolean $value The name of the mobile device or true/false for generic mobile
     */
    public function setMobile($value = true)
    {
        $this->mobile = $value;
    }
}

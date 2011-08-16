<?php

namespace Zenstruck\Bundle\MobileBundle\Manager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class MobileManager
{
    protected $mobile;
    protected $mobileHost;
    protected $fullHost;

    public function __construct($mobileHost = null, $fullHost = null, $mobile = false)
    {
        $this->fullHost = $fullHost;
        $this->mobileHost = $mobileHost;
        $this->mobile = $mobile;
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
     * @param string/boolean $mobile The name of the mobile device or true/false for generic mobile
     */
    public function setMobile($mobile = true)
    {
        if (!is_bool($mobile)) {
            // make sure is valid
            if (!preg_match("/^[a-zA-Z0-9_]*$/", $mobile)) {
                throw new \InvalidArgumentException('Invalid mobile name - must be alpha-numeric with no spaces');
            }
        }

        $this->mobile = $mobile;
    }

    public function getMobileHost()
    {
        return $this->mobileHost;
    }

    public function setMobileHost($mobileHost)
    {
        $this->mobileHost = $mobileHost;
    }

    public function getFullHost()
    {
        return $this->fullHost;
    }

    public function setFullHost($defaultHost)
    {
        $this->fullHost = $defaultHost;
    }
}

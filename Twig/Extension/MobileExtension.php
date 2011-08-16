<?php

namespace Zenstruck\Bundle\MobileBundle\Twig\Extension;

use Zenstruck\Bundle\MobileBundle\Manager\MobileManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class MobileExtension extends \Twig_Extension
{

    protected $mobileManager;

    public function __construct(MobileManager $mobileManager)
    {
        $this->mobileManager = $mobileManager;
    }

    public function getFunctions()
    {
        return array(
            'zenstruck_mobile_url' => new \Twig_Function_Method($this, 'getMobileUrl', array('is_safe' => array('html'))),
            'zenstruck_mobile_full_url' => new \Twig_Function_Method($this, 'getFullUrl', array('is_safe' => array('html')))
        );
    }

    public function getMobileUrl($prefix = 'http://')
    {
        /**
         * Have to use $_SERVER instead of Request because of scope issue
         * @todo find better solution
         */
        return $prefix .
               $this->mobileManager->getMobileHost() .
               $_SERVER['REQUEST_URI'];
    }

    public function getFullUrl($prefix = 'http://')
    {
        return $prefix .
               $this->mobileManager->getFullHost() .
               $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zenstruck_mobile';
    }

}

<?php

namespace Zenstruck\Bundle\MobileBundle\Twig\Extension;

use Zenstruck\Bundle\MobileBundle\Manager\MobileManager;
use Symfony\Component\DependencyInjection\Container;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class MobileExtension extends \Twig_Extension
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'zenstruck_mobile_url' => new \Twig_Function_Method($this, 'getMobileUrl', array('is_safe' => array('html'))),
            'zenstruck_mobile_full_url' => new \Twig_Function_Method($this, 'getFullUrl', array('is_safe' => array('html')))
        );
    }

    public function getMobileUrl($parameters = array(), $prefix = 'http://')
    {
        return $this->buildUrl(
                $this->container->get('zenstruck_mobile.manager')->getMobileHost(),
                $parameters,
                $prefix);
    }

    public function getFullUrl($parameters = array(), $prefix = 'http://')
    {
        return $this->buildUrl(
                $this->container->get('zenstruck_mobile.manager')->getFullHost(),
                $parameters,
                $prefix);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zenstruck_mobile';
    }

    protected function buildUrl($host, array $parameters, $prefix)
    {
        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $this->container->get('request')->duplicate();
        $url = $prefix . $host . $request->getBaseUrl() . $request->getPathInfo();

        $request->query->add($parameters);

        if (count($request->query->keys())) {
            $url .= '?';
            $tmp = array();

            foreach ($request->query->all() as $key => $value) {
                $tmp[] = $key . '=' . $value;
            }
            
            $url .= implode('&', $tmp);
        }

        return $url;
    }

}

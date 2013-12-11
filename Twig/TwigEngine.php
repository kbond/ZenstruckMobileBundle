<?php

namespace Zenstruck\Bundle\MobileBundle\Twig;

use Symfony\Bundle\TwigBundle\TwigEngine as BaseTwigEngine;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Zenstruck\Bundle\MobileBundle\Manager\MobileManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class TwigEngine extends BaseTwigEngine
{
    protected $mobileManager;

    public function __construct(\Twig_Environment $environment, TemplateNameParserInterface $parser, FileLocatorInterface $locator, MobileManager $mobileManager)
    {
        $this->mobileManager = $mobileManager;

        parent::__construct($environment, $parser, $locator);
    }

    public function render($name, array $parameters = array())
    {
        if ($this->mobileManager->isMobile()) {
            $mobileTemplate = preg_replace("/^\w+:\w+:/", '$0mobile/', $name);

            if ($this->exists($mobileTemplate)) {
                $name = $mobileTemplate;
            }
        }

        return parent::render($name, $parameters);
    }
}

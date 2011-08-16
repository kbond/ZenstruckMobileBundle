<?php

namespace Zenstruck\Bundle\MobileBundle\Twig;

use Symfony\Bundle\TwigBundle\TwigEngine as BaseTwigEngine;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Zenstruck\Bundle\MobileBundle\Manager\MobileManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class TwigEngine extends BaseTwigEngine
{
    protected $mobileManager;

    public function __construct(\Twig_Environment $environment, TemplateNameParserInterface $parser,
            MobileManager $mobileManager, GlobalVariables $globals = null)
    {
        parent::__construct($environment, $parser, $globals);

        $this->mobileManager = $mobileManager;
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

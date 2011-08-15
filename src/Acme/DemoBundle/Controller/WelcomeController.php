<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        //die(var_dump($_SERVER));

        die(var_dump($this->container->getParameter('zenstruck_mobile')));

        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }
}

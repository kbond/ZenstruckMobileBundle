<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends Controller
{
    public function indexAction()
    {
        $mobile = $this->container->get('zenstruck_mobile.manager')->getMobile();

        $response = new Response();

        if ($this->get('templating')->exists('AcmeDemoBundle:Welcome:mobile\index.html.twig') && $mobile) {
            $response->setContent($this->renderView('AcmeDemoBundle:Welcome:mobile\index.html.twig', array('mobile' => $mobile)));
        } else {
            $response->setContent($this->renderView('AcmeDemoBundle:Welcome:index.html.twig', array('mobile' => $mobile)));
        }

        $response->setSharedMaxAge(30);

        return $response;
    }
}

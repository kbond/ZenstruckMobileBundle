<?php

namespace Zenstruck\Bundle\MobileBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Zenstruck\Bundle\MobileBundle\Manager\MobileManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class RequestListener
{
    protected $mobileManager;

    public function __construct(MobileManager $mobileManager)
    {
        $this->mobileManager = $mobileManager;
    }

    public function onCoreRequest(GetResponseEvent $event)
    {
        if ($event->getRequest()->getHost() === $this->mobileManager->getMobileHost()) {
            $this->mobileManager->setMobile();
        }
    }

}

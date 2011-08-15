<?php

namespace Zenstruck\Bundle\MobileBundle\Tests\Manager;

use Zenstruck\Bundle\MobileBundle\Manager\MobileManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class MobileManagerTest extends \PHPUnit_Framework_TestCase
{

    public function testSetMobile()
    {
        $manager = new MobileManager();

        $this->assertTrue($manager->isMobile() === false);
        $this->assertTrue($manager->getMobile() === false);

        $manager->setMobile();
        $this->assertTrue($manager->isMobile() === true);
        $this->assertTrue($manager->getMobile() === 'mobile');

        $manager->setMobile('iphone');
        $this->assertTrue($manager->isMobile() === true);
        $this->assertTrue($manager->getMobile() === 'iphone');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidMobileName()
    {
        $manager = new MobileManager();

        $manager->setMobile('iphone 4');
    }

}

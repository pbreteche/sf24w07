<?php

namespace App\Tests\Service;

use App\Service\LocaleRegionMapper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class LocaleRegionMapperTest extends KernelTestCase
{
    private LocaleRegionMapper $localeRegionMapper;

    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $request = new Request();
        $request->setLocale('fr');
        /** @var RequestStack $requestStack */
        $requestStack = $container->get(RequestStack::class);
        $requestStack->push($request);

        $this->localeRegionMapper = $container->get(LocaleRegionMapper::class);
    }

    public function testGetRegion()
    {
        $region = $this->localeRegionMapper->getRegion('fr');
        $this->assertMatchesRegularExpression('#^[A-Z]{2}$#', $region, 'Region code should be 2 uppercase letters');
        $this->assertEquals('FR', $region);

        $region = $this->localeRegionMapper->getRegion();
        $this->assertEquals('FR', $region);
    }
}

<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TShirtControllerTest extends WebTestCase
{

    public function testEdit()
    {

    }

    public function testNew()
    {
        $client = static::createClient();
        $client->request('GET', '/t-shirt/new');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Créer', [
            't_shirt[name]' => 'un nom',
            't_shirt[color]' => '#FF55AA',
            't_shirt[description]' => 'Lorem ...',
            't_shirt[price]' => 40,
            't_shirt[referenceNumber]' => 'AZERTY-55',
            't_shirt[createdAt]' => '2024-02-18 13:24:57',
            't_shirt[duration]' => '37:30',
        ]);

        $this->assertResponseRedirects('/t-shirt/new');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();


        $crawler = $client->submitForm('Créer', [
            't_shirt[name]' => 'un nom',
            't_shirt[color]' => '#FF55AA',
            't_shirt[description]' => 'Lorem ...',
            't_shirt[price]' => 40,
            't_shirt[referenceNumber]' => 'AZERTY-55',
            't_shirt[createdAt]' => '2024-02-18 13:24:57',
            't_shirt[duration]' => '-37:30',
        ]);

        $this->assertResponseIsUnprocessable();
        $this->assertSelectorTextContains('.invalid-feedback', 'Value -37:30 is not a valid duration.');
    }
}

<?php

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;

class DefaultControllerTest extends PantherTestCase
{
    public function testNew()
    {
        $client = static::createPantherClient(options: [
            'browser' => static::FIREFOX,
        ]);
        $client->request('GET', 'http://localhost:8000/demo-type-guesser');

        $mouse = $client->getMouse();
        $mouse->mouseDownTo('#signature-pad-canvas');
        $mouse->mouseMoveTo('#signature-pad-canvas', 120, 60);
        $mouse->mouseMoveTo('#signature-pad-canvas', 160, 20);
        $mouse->mouseUpTo('#signature-pad-canvas');

        $client->takeScreenshot();
    }
}

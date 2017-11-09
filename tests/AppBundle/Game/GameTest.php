<?php

namespace Tests\AppBundle\Game;

use AppBundle\Game\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @dataProvider provideWords
     */
    public function testGetContext(string $word)
    {
        $game = new Game($word);

        $context = [
            'word' => strtolower($word),
            'attempts'  => 0,
            'found_letters' => [],
            'tried_letters' => [],
        ];

        $this->assertSame($context, $game->getContext());
    }

    public function provideWords()
    {
        yield ['Toto'];
        yield ['toto'];
    }
}

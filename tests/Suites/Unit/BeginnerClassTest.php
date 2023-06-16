<?php

declare(strict_types=1);

namespace Tests\Suites\Unit;

use WebTheory\Playground\PlaygroundMaker;
use Tests\Support\UnitTestCase;

class BeginnerClassTest extends UnitTestCase
{
    /**
     * System Under Test
     *
     * @var PlaygroundMaker
     */
    protected PlaygroundMaker $sut;

    public function setUp(): void
    {
        parent::setUp();

        $this->sut = new PlaygroundMaker();
    }

    /**
     * @test
     */
    public function it_returns_provided_phrase()
    {
        # Arrange
        $phrase = $this->fake->sentence;

        # Act
        $result = $this->sut->returnPhrase($phrase);

        # Assert
        $this->assertSame($phrase, $result);
    }
}

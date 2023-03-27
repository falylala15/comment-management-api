<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('fr_FR');
    }
}

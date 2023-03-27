<?php

namespace Domain\ValueObject;

use Blog\Domain\ValueObject\Email;
use Tests\BaseTest;

class EmailTest extends BaseTest
{
    /**
     * @test
     */
    public function it_create_an_email(): void
    {
        $email = $this->faker->email();
        $emailValueObject = Email::fromString($email);

        $this->assertSame($email, $emailValueObject->toString());
    }

    /**
     * @test
     */
    public function it_throw_an_exception_when_invalid_email(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Email::fromString('invalid_email');
    }
}

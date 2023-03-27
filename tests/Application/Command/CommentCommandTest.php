<?php

namespace Tests\Application\Command;

use Blog\Application\Command\Comment\CommentCommand;
use Blog\Application\Command\Comment\Validator\CommentValidator;
use Tests\BaseTest;

class CommentCommandTest extends BaseTest
{
    /**
     * @test
     */
    public function it_check_data_is_valid(): void
    {
        $articleId = $this->faker->uuid();
        $content = $this->faker->text();

        $command = new CommentCommand($articleId, $content);
        $validator = new CommentValidator();

        $this->assertEmpty($validator->validate($command), 'is valid comment request.');
    }

    /**
     * @param array<string, string|null> $data
     *
     * @dataProvider invalidContentProvider
     * @test
     */
    public function it_check_content_data_is_invalid(array $data): void
    {
        $command = new CommentCommand($data['article_id'], $data['content']);
        $validator = new CommentValidator();

        $formErrors = $validator->validate($command);

        $this->assertNotEmpty($formErrors, 'Invalid comment request data.');
        $this->assertSame('Provide an message content.', $formErrors['content'][0]);
    }

    /**
     * @param array<string, string|null> $data
     *
     * @dataProvider invalidArticleProvider
     * @test
     */
    public function it_check_article_identifer_is_invalid(array $data): void
    {
        $command = new CommentCommand($data['article_id'], $data['content']);
        $validator = new CommentValidator();

        $this->expectException(\InvalidArgumentException::class);
        $errors = $validator->validate($command);

        $this->assertSame('Provide an article identifier.', $errors['article'][0]);
    }
    /** @phpstan-ignore-next-line  */
    private function invalidContentProvider(): \Generator
    {
        yield 'Invalid content: null ' => [
            ['article_id' => 'a1d16317-8399-3ad0-8b6e-d69035292961', 'content' => null],
        ];
        yield 'Invalid content: empty' => [
            ['article_id' => 'a1d16317-8399-3ad0-8b6e-d69035292961', 'content' => ''],
        ];
    }

    /** @phpstan-ignore-next-line  */
    private function invalidArticleProvider(): \Generator
    {
        yield 'Invalid article identifier: empty' => [
            ['article_id' => 'invalid_article', 'content' => 'Amet ad saepe praesentium. Expedita deleniti voluptas dolorum est. Laudantium et quidem quod rerum.'],
        ];
    }
}

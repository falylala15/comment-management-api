<?php

namespace Blog\Infrastructure\DataFixtures;

use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\Factory\CommentFactory;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Domain\ValueObject\CommentId;
use Blog\Domain\ValueObject\Email;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 5; $i++) {
            $articleId = ArticleId::generate();
            $article = ArticleFactory::create($articleId, $faker->name(), $faker->text(50));

            for ($j = 1; $j <= 5; $j++) {
                $comment = CommentFactory::create(
                    CommentId::generate(),
                    $articleId,
                    $faker->text(50),
                    Email::fromString($faker->email())
                );

                $article->addComment($comment);

                $manager->persist($comment);
            }

            $manager->persist($article);
        }

        $manager->flush();
    }
}

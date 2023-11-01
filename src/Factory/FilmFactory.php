<?php

namespace App\Factory;

use App\Entity\Film;
use App\Repository\FilmRepository;
use DateTimeImmutable;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Film>
 *
 * @method        Film|Proxy create(array|callable $attributes = [])
 * @method static Film|Proxy createOne(array $attributes = [])
 * @method static Film|Proxy find(object|array|mixed $criteria)
 * @method static Film|Proxy findOrCreate(array $attributes)
 * @method static Film|Proxy first(string $sortedField = 'id')
 * @method static Film|Proxy last(string $sortedField = 'id')
 * @method static Film|Proxy random(array $attributes = [])
 * @method static Film|Proxy randomOrCreate(array $attributes = [])
 * @method static FilmRepository|RepositoryProxy repository()
 * @method static Film[]|Proxy[] all()
 * @method static Film[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Film[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Film[]|Proxy[] findBy(array $attributes)
 * @method static Film[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Film[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class FilmFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->text(150),
            "category" => CategoryFactory::random(),
            "author" => self::faker()->words(1, true),
            "summary" => self::faker()->text(),
            "created_at" => DateTimeImmutable::createFromMutable(self::faker()->datetime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Film $film): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Film::class;
    }
}

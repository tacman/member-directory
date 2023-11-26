<?php

namespace App\Factory;

use App\Entity\Donation;
use App\Repository\DonationRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Donation>
 *
 * @method        Donation|Proxy                     create(array|callable $attributes = [])
 * @method static Donation|Proxy                     createOne(array $attributes = [])
 * @method static Donation|Proxy                     find(object|array|mixed $criteria)
 * @method static Donation|Proxy                     findOrCreate(array $attributes)
 * @method static Donation|Proxy                     first(string $sortedField = 'id')
 * @method static Donation|Proxy                     last(string $sortedField = 'id')
 * @method static Donation|Proxy                     random(array $attributes = [])
 * @method static Donation|Proxy                     randomOrCreate(array $attributes = [])
 * @method static DonationRepository|RepositoryProxy repository()
 * @method static Donation[]|Proxy[]                 all()
 * @method static Donation[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Donation[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Donation[]|Proxy[]                 findBy(array $attributes)
 * @method static Donation[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Donation[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Donation> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Donation> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Donation> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Donation> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Donation> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Donation> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Donation> random(array $attributes = [])
 * @phpstan-method static Proxy<Donation> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Donation> repository()
 * @phpstan-method static list<Proxy<Donation>> all()
 * @phpstan-method static list<Proxy<Donation>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Donation>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Donation>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Donation>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Donation>> randomSet(int $number, array $attributes = [])
 */
final class DonationFactory extends ModelFactory
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
            'member' => null,
            'amount' => self::faker()->randomFloat(),
            'createdAt' => self::faker()->dateTime(),
            'currency' => self::faker()->text(255),
            'isAnonymous' => self::faker()->boolean(),
            'isRecurring' => self::faker()->boolean(),
            'netAmount' => self::faker()->randomFloat(),
            'processingFee' => self::faker()->randomFloat(),
            'receivedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'transactionPayload' => [],
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Donation $donation): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Donation::class;
    }
}

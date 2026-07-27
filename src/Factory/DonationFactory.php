<?php

namespace App\Factory;

use App\Entity\Donation;
use App\Repository\DonationRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Donation>
 *
 * @method        Donation                           create(array|callable $attributes = [])
 * @method static Donation                           createOne(array $attributes = [])
 * @method static Donation                           find(object|array|mixed $criteria)
 * @method static Donation                           findOrCreate(array $attributes)
 * @method static Donation                           first(string $sortedField = 'id')
 * @method static Donation                           last(string $sortedField = 'id')
 * @method static Donation                           random(array $attributes = [])
 * @method static Donation                           randomOrCreate(array $attributes = [])
 * @method static DonationRepository                 repository()
 * @method static Donation[]                         all()
 * @method static Donation[]                         createMany(int $number, array|callable $attributes = [])
 * @method static Donation[]                         createSequence(iterable|callable $sequence)
 * @method static Donation[]                         findBy(array $attributes)
 * @method static Donation[]                         randomRange(int $min, int $max, array $attributes = [])
 * @method static Donation[]                         randomSet(int $number, array $attributes = [])
 */
final class DonationFactory extends PersistentObjectFactory
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
    protected function defaults(): array|callable
    {
        $fee =  self::faker()->randomFloat(0, 0, 5);
        $amount = self::faker()->randomFloat(0, 0, 1000);
        $net = $amount - $fee; // this should be a method somewhere in the entity!

        return [
            'member' => null,
            'amount' => $amount,
            'createdAt' => self::faker()->dateTime(),
            'currency' => 'USD', // self::faker()->text(255),
            'isAnonymous' => self::faker()->boolean(),
            'isRecurring' => self::faker()->boolean(),
            'netAmount' => $net,
            'processingFee' => $fee,
            'receivedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'transactionPayload' => [],
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Donation $donation): void {})
        ;
    }

    public static function class(): string
    {
        return Donation::class;
    }
}

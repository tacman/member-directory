<?php

declare(strict_types=1);

use App\Entity\Member;
use App\Entity\Event;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('knp_dictionary', [
        'dictionaries' => [
            'class_icons' => [
                'type' => 'key_value',
                'content' => [
                    \App\Entity\Member::class => 'mdi:user',
                    \App\Entity\DirectoryCollection::class => 'mdi:users',
                    \App\Entity\Tag::class => 'mdi:tag',
                    \App\Entity\Donation::class => 'mdi:dollar',
                    \App\Entity\CommunicationLog::class => 'mdi:envelope',
                    \App\Entity\Event::class => 'tabler:calendar'
                ]
            ],

            'action_icons' => [
                'type' => 'key_value',
                'content' => [
                    \App\Menu\Icons::ADD => 'mdi:plus',

                ],
            ]
        ]
    ]
    );
};

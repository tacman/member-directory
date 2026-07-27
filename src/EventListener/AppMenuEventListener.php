<?php

namespace App\EventListener;

use App\Entity\CommunicationLog;
use App\Entity\DirectoryCollection;
use App\Entity\Donation;
use App\Entity\Event;
use App\Entity\Tag;
use App\Repository\DirectoryCollectionRepository;
use App\Repository\TagRepository;
use Survos\TablerBundle\Event\MenuEvent;
use Survos\TablerBundle\Menu\MenuBuilderTrait;
use Survos\TablerBundle\Service\IconService;
use Survos\TablerBundle\Service\RouteAliasService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

// AUTH slot is populated automatically by tabler-bundle's AuthSlotMenuSubscriber
// (app_login/app_logout/app_register already match its route-name fallbacks).
#[AsEventListener(event: MenuEvent::NAVBAR_MENU, method: 'navbarMenu')]
#[AsEventListener(event: MenuEvent::NAVBAR_MENU_END, method: 'navbar2Menu')]
#[AsEventListener(event: MenuEvent::SIDEBAR, method: 'sidebarMenu')]
#[AsEventListener(event: MenuEvent::PAGE_NAV, method: 'pageMenu')]
#[AsEventListener(event: MenuEvent::FOOTER, method: 'footerMenu')]
final class AppMenuEventListener
{
    use MenuBuilderTrait;

    public function __construct(
        private DirectoryCollectionRepository                $directoryCollectionRepository,
        private TagRepository                                $tagRepository,
        #[Autowire('%kernel.environment%')] protected string $env,
        private AuthorizationCheckerInterface                $authorizationChecker,
        protected readonly ?RouterInterface                  $router = null,
        protected readonly ?RouteAliasService                $routeAliasService = null,
        protected readonly ?IconService                      $iconService = null,
    ) {
    }

    private function isGranted(string $attribute): bool
    {
        return $this->authorizationChecker->isGranted($attribute);
    }

    public function navbar2Menu(MenuEvent $event): void
    {
        $menu = $event->getMenu();
        if ($this->isGranted('ROLE_ADMIN')) {
            $nestedMenu = $this->addSubmenu($menu, 'Admin');
            foreach (['member_status_index', 'tag_index', 'directory_collection_index', 'admin', 'user_index'] as $route) {
                $this->add($nestedMenu, $route);
            }
        }

    }

    public function navbarMenu(MenuEvent $event): void
    {
        $menu = $event->getMenu();
        $directoryCollections = $this->directoryCollectionRepository->findBy([], ['position' => 'ASC', 'label' => 'ASC']);
        $nestedMenu = $this->addSubmenu($menu, 'Collections',
            icon: DirectoryCollection::class
        );
        foreach ($directoryCollections as $directoryCollection) {
            $this->add($nestedMenu, 'directory_collection',

                $directoryCollection, $directoryCollection->getLabel(),
            );
        }

        $this->add($nestedMenu, 'directory_collection_new', label: 'New',
            icon: 'add', dividerBefore: true);
        if ($this->isGranted('ROLE_DIRECTORY_MANAGER')) {
            // bootstrap bundle should handle not printing links that aren't valid
        }
        $this->add($nestedMenu, 'directory_browse', label: 'Api Grid Browse');

        $nestedMenu = $this->addSubmenu($menu, 'Tags',
            icon: Tag::class
        );
        $tags = $this->tagRepository->findBy([], ['tagName' => 'ASC']);
        foreach ($tags as $tag) {
            $this->add($nestedMenu, 'tag', $tag, $tag->getTagName());
        }
        $this->add($nestedMenu, 'tag_index', label: 'Admin', dividerBefore: true);

        $nestedMenu = $this->addSubmenu($menu, 'Donations',
            icon: Donation::class
        );
        foreach (['donation_index', 'donation_donors', 'donation_campaigns'] as $route) {
            $this->add($nestedMenu, $route);
        }

        $nestedMenu = $this->addSubmenu($menu, 'Communications', icon: CommunicationLog::class);
        foreach (['messenger_email', 'messenger_sms', 'communication_index'] as $route) {
            $this->add($nestedMenu, $route);
        }

        $this->add($menu, 'map', icon: 'mdi:map');

        $this->add($menu, 'event_index', icon: Event::class);
        $this->add($menu, 'birthdays', icon: 'tabler:cake');

        $nestedMenu = $this->addSubmenu($menu, 'Data', icon: 'database');
        // @todo: look for ROLE_DIRECTORY_MANAGER in the route IsGranted
        foreach (['member_changes', 'import', 'export'] as $route) {
            $this->add($nestedMenu, $route);
        }


    }

    public function sidebarMenu(MenuEvent $event): void
    {
        $menu = $event->getMenu();
    }

    public function footerMenu(MenuEvent $event): void
    {
        $menu = $event->getMenu();
        $this->add($menu, uri: 'https://github.com');
    }

    // this could also be called the content menu, as it's below the navbar, e.g. a menu for an entity, like show, edit
    public function pageMenu(MenuEvent $event): void
    {
        $menu = $event->getMenu();
    }
}

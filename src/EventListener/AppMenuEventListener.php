<?php

namespace App\EventListener;

use App\Repository\DirectoryCollectionRepository;
use App\Repository\TagRepository;
use Survos\AuthBundle\Services\AuthService;
use Survos\BootstrapBundle\Event\KnpMenuEvent;
use Survos\BootstrapBundle\Service\MenuService;
use Survos\BootstrapBundle\Traits\KnpMenuHelperInterface;
use Survos\BootstrapBundle\Traits\KnpMenuHelperTrait;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[AsEventListener(event: KnpMenuEvent::NAVBAR_MENU, method: 'navbarMenu')]
#[AsEventListener(event: KnpMenuEvent::NAVBAR_MENU2, method: 'navbar2Menu')]
#[AsEventListener(event: KnpMenuEvent::SIDEBAR_MENU, method: 'sidebarMenu')]
#[AsEventListener(event: KnpMenuEvent::PAGE_MENU, method: 'pageMenu')]
#[AsEventListener(event: KnpMenuEvent::FOOTER_MENU, method: 'footerMenu')]
#[AsEventListener(event: KnpMenuEvent::AUTH_MENU, method: 'appAuthMenu')]
final class AppMenuEventListener implements KnpMenuHelperInterface
{
    use KnpMenuHelperTrait;

    public function __construct(
        private DirectoryCollectionRepository                                             $directoryCollectionRepository,
        private TagRepository                                                             $tagRepository,
        private MenuService $menuService, // helper for auth menus, etc.
        #[Autowire('%kernel.environment%')] private string                                $env,
        private Security                                                                  $security,
        private ?AuthorizationCheckerInterface                                            $authorizationChecker = null
    )
    {
    }

    public function navbar2Menu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();
        if ($this->isGranted('ROLE_ADMIN')) {
            $nestedMenu = $this->addSubmenu($menu, 'Admin');
            foreach (['member_status_index', 'tag_index', 'directory_collection_index', 'admin', 'user_index'] as $route) {
                $this->add($nestedMenu, $route);
            }
        }

    }

    public function appAuthMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();
//        $this->authMenu($this->authorizationChecker, $this->security, $menu);
        $this->menuService->addAuthMenu($menu);
//        $this->add($menu, 'app_login');
    }


    public function navbarMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();
        $options = $event->getOptions();
        $directoryCollections = $this->directoryCollectionRepository->findBy([], ['position' => 'ASC', 'label' => 'ASC']);
        $nestedMenu = $this->addSubmenu($menu, 'Collections');
        foreach ($directoryCollections as $directoryCollection) {
            $this->add($nestedMenu, 'directory_collection', $directoryCollection, $directoryCollection->getLabel());
        }
        if ($this->isGranted('ROLE_DIRECTORY_MANAGER')) {
            $this->add($nestedMenu, 'directory_collection_new', label: 'New', icon: 'fas fa-plus', dividerPrepend: true);
        }

        $nestedMenu = $this->addSubmenu($menu, 'Tags');
        $tags = $this->tagRepository->findBy([], ['tagName' => 'ASC']);
        foreach ($tags as $tag) {
            $this->add($nestedMenu, 'tag', $tag, $tag->getTagName());
        }
        $this->add($nestedMenu, 'tag_index', label: 'Admin', dividerPrepend: true);

        $nestedMenu = $this->addSubmenu($menu, 'Donations',);
        foreach (['donation_index', 'donation_donors', 'donation_campaigns'] as $route) {
            $this->add($nestedMenu, $route);
        }

        $nestedMenu = $this->addSubmenu($menu, 'Communications');
        foreach (['messenger_email', 'messenger_sms', 'communication_index'] as $route) {
            $this->add($nestedMenu, $route);
        }

        $this->add($menu, 'map');

        $this->add($menu, 'event_index', icon: 'fas fa-calendar');
        $this->add($menu, 'birthdays');

        $nestedMenu = $this->addSubmenu($menu, 'Data');
        foreach (['member_changes', 'import', 'export'] as $route) {
            $this->add($nestedMenu, $route);
        }


    }

    public function sidebarMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();
        $options = $event->getOptions();
    }

    public function footerMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();
        $options = $event->getOptions();
        $this->add($menu, uri: 'https://github.com');
    }

    // this could also be called the content menu, as it's below the navbar, e.g. a menu for an entity, like show, edit
    public function pageMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();
        $options = $event->getOptions();
    }
}

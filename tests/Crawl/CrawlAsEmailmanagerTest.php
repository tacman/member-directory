<?php

namespace App\Tests\Crawl;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Survos\CrawlerBundle\Tests\BaseVisitLinksTest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CrawlAsEmailmanagerTest extends BaseVisitLinksTest
{
	#[TestDox('/$method $url ($route)')]
	#[TestWith(['email.manager@example.com', '/', 200])]
	#[TestWith(['email.manager@example.com', '/auth/profile', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/collection/member', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/collection/alumnus', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/collection/do-not-contact', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/collection/expelled', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/browse', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/tags/12', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/map', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/birthdays', 200])]
	#[TestWith(['email.manager@example.com', '/en/directory/recent-changes', 200])]
	#[TestWith(['email.manager@example.com', '/directory/export/', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/1-0011', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-85', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-23', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/1-0008', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-17', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-69', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-96', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/1-0007', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-52', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/1-0012', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-5', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-83', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-54', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-22', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-72', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-30', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-3', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-1', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-12', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-35', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-46', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-64', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58/message', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19/message', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58/message?_switch_user=communications.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58/message?_switch_user=email.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58/message?_switch_user=event.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58/message?_switch_user=donation.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58/message?_switch_user=admin%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-58/message?_switch_user=user%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19/message?_switch_user=communications.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19/message?_switch_user=email.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19/message?_switch_user=event.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19/message?_switch_user=donation.manager%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19/message?_switch_user=admin%40example.com', 200])]
	#[TestWith(['email.manager@example.com', '/directory/member/d-19/message?_switch_user=user%40example.com', 200])]
	public function testRoute(string $username, string $url, string|int|null $expected): void
	{
		parent::testWithLogin($username, $url, (int)$expected);
	}
}

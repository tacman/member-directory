<?php

namespace App\Tests\Crawl;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Survos\CrawlerBundle\Tests\BaseVisitLinksTest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CrawlAsVisitorTest extends BaseVisitLinksTest
{
	#[TestDox('/$method $url ($route)')]
	#[TestWith(['', '/', 200])]
	#[TestWith(['', '/login', 200])]
	#[TestWith(['', '/login?_email=communications.manager@example.com', 200])]
	#[TestWith(['', '/login?_email=email.manager@example.com', 200])]
	#[TestWith(['', '/login?_email=event.manager@example.com', 200])]
	#[TestWith(['', '/login?_email=donation.manager@example.com', 200])]
	#[TestWith(['', '/login?_email=admin@example.com', 200])]
	#[TestWith(['', '/login?_email=user@example.com', 200])]
	#[TestWith(['', '/reset-password', 200])]
	public function testRoute(string $username, string $url, string|int|null $expected): void
	{
		parent::testWithLogin($username, $url, (int)$expected);
	}
}

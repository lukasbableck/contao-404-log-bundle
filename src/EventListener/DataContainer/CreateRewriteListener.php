<?php
namespace Lukasbableck\Contao404LogBundle\EventListener\DataContainer;

use Composer\InstalledVersions;
use Contao\Backend;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\System;
use Doctrine\DBAL\Connection;
use Lukasbableck\Contao404LogBundle\Model\Model404Log;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsCallback('tl_404_log', 'config.onload')]
class CreateRewriteListener extends Backend {
	public function __construct(private RequestStack $requestStack, private Connection $connection) {
	}

	public function __invoke(?DataContainer $dc = null): void {
		if (null === $dc || !$dc->id || 'createRewrite' !== $this->requestStack->getCurrentRequest()->query->get('act')) {
			return;
		}

		if (!InstalledVersions::isInstalled('terminal42/contao-url-rewrite')) {
			return;
		}

		$entry = Model404Log::findByPk($dc->id);
		$requestURL = parse_url($entry->url);

		$stmt = 'INSERT INTO tl_url_rewrite (tstamp, requestHosts, requestPath, inactive, responseCode, type) VALUES (?, ?, ?, ?, ?, ?)';
		$this->connection->executeStatement($stmt, [time(), serialize([$requestURL['host']]), $requestURL['path'], 1, 301, 'basic']);
		$id = $this->connection->lastInsertId();

		$token = htmlspecialchars(System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue(), \ENT_QUOTES | \ENT_SUBSTITUTE | \ENT_HTML5);
		$url = System::getContainer()->get('router')->generate('contao_backend').'?do=url_rewrites&act=edit&id='.$id.'&rt='.$token;
		$this->redirect($url);
	}
}

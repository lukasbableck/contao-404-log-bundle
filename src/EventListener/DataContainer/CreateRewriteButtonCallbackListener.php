<?php
namespace Lukasbableck\Contao404LogBundle\EventListener\DataContainer;

use Composer\InstalledVersions;
use Contao\Backend;
use Contao\CoreBundle\DataContainer\DataContainerOperation;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;

#[AsCallback('tl_404_log', 'list.operations.createRewrite.button')]
class CreateRewriteButtonCallbackListener extends Backend {
	public function __invoke(DataContainerOperation $operation): void {
		if (!InstalledVersions::isInstalled('terminal42/contao-url-rewrite')) {
			$operation->setHtml('');

			return;
		}
	}
}

<?php
namespace Lukasbableck\Contao404LogBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Environment;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Lukasbableck\Contao404LogBundle\Model\Model404Log;

#[AsHook('generatePage')]
class GeneratePageListener {
	public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void {
		if ('error_404' === $pageModel->type) {
			if ($rootPage = PageModel::findById($pageModel->rootId)) {
				$logEntry = new Model404Log();
				$logEntry->tstamp = time();
				$logEntry->rootPage = $rootPage->id;
				$logEntry->ip = Environment::get('ip');
				$logEntry->url = Environment::get('uri');
				$logEntry->referrer = Environment::get('referer') ?? '';
				$logEntry->agent = Environment::get('httpUserAgent') ?? '';
				$logEntry->save();
			}
		}
	}
}

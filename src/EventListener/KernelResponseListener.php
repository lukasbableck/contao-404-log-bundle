<?php
namespace Lukasbableck\Contao404LogBundle\EventListener;

use Contao\PageModel;
use Lukasbableck\Contao404LogBundle\Model\Model404Log;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

#[AsEventListener('kernel.response')]
class KernelResponseListener {
	public function __invoke(ResponseEvent $event): void {
		if (!$event->isMainRequest()) {
			return;
		}

		$request = $event->getRequest();
		$pageModel = $request->attributes->get('pageModel');
		if (!$pageModel) {
			return;
		}

		if ('/_fragment' === rawurldecode($request->getPathInfo())) {
			return;
		}

		if ('error_404' === $pageModel->type) {
			$rootPage = PageModel::findById($pageModel->rootId);
			if ($rootPage) {
				$logEntry = new Model404Log();
				$logEntry->tstamp = time();
				$logEntry->rootPage = $rootPage->id;
				$logEntry->ip = $request->getClientIp();
				$logEntry->url = $request->getUri();
				$logEntry->referrer = $request->headers->get('referer') ?? '';
				$logEntry->agent = $request->headers->get('User-Agent') ?? '';
				$logEntry->save();
			}
		}
	}
}

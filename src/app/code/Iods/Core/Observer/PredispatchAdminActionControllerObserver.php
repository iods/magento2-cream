<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class PredispatchAdminActionControllerObserver implements ObserverInterface {

	/**
	 * @var NotificationFeedFactory
	 */
	private $feedFactory;

	/**
	 * @var ManagerInterface
	 */
	private $manager;

	/**
	 * @type Session
	 */
	protected $authSession;

	/**
	 * OnActionPredispatchObserver constructor.
	 * @param NotificationFeedFactory $feedFactory
	 * @param ManagerInterface $manager
	 * @param Session $authSession
	 */
	public function __construct(NotificationFeedFactory $feedFactory, ManagerInterface $manager, Session $authSession) {
		$this->feedFactory = $feedFactory;
		$this->manager = $manager;
		$this->authSession = $authSession;
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute(EventObserver $observer) {
		if ($this->authSession->isLoggedIn()) {
			$feedModel = $this->feedFactory->create();
			$feedModel->checkUpdate();
		}
	}
}

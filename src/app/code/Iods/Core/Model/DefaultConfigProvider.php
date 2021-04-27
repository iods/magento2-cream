<?php
/**
* 
* Core para Magento 2
* 
* @category     Dholi
* @package      Modulo Core
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.1.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Dholi\Core\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Store\Model\StoreManagerInterface;

class DefaultConfigProvider implements ConfigProviderInterface {

	private $storeManager;

	private $localeResolver;

	public function __construct(StoreManagerInterface $storeManager,
															ResolverInterface $localeResolver) {
		$this->storeManager = $storeManager;
		$this->localeResolver = $localeResolver;
	}

	public function getConfig() {
		return [
			'storeCode' => $this->getStoreCode(),
			'lang' => $this->getLanguage(),
		];
	}

	private function getStoreId() {
		return $this->storeManager->getStore()->getId();
	}

	private function getStoreCode(): string {
		return $this->storeManager->getStore()->getCode();
	}

	private function getLanguage(): string {
		return $this->localeResolver->getLocale();
	}
}
<?php
/**
* 
* Payment Core para Magento 2
* 
* @category     Dholi
* @package      Modulo Payment Core
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.1.1
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Dholi\Payment\Model\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\Asset\Repository;

class ConfigProvider implements ConfigProviderInterface {
	
	const CODE = 'dholi_payments';
	
	protected $assetRepo;
	
	public function __construct(Repository $assetRepo) {
		$this->assetRepo = $assetRepo;
	}
	
	public function getConfig() {
		return [
			'payment' => [
				self::CODE => [
					'icons' => [
						'visa' => [
							'height' => 30,
							'width' => 46,
							'url' => $this->assetRepo->getUrl("Dholi_Payment::images/cc/visa.png")
						]
					],
				],
			]
		];
	}
}
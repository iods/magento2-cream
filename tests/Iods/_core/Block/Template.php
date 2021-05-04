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

namespace Iods\Core\Block;

use Iods\Core\Model\DefaultConfigProvider;

class Template extends \Magento\Framework\View\Element\Template {

	/**
	 * @var \Dholi\Core\Model\DefaultConfigProvider
	 */
	protected $configProvider;

	/**
	 * @var \Magento\Framework\Serialize\SerializerInterface
	 */
	private $serializer;

	public function __construct(\Magento\Framework\View\Element\Template\Context $context,
															DefaultConfigProvider $configProvider,
															\Magento\Framework\Serialize\SerializerInterface $serializerInterface = null,
															array $data = []) {
		$this->configProvider = $configProvider;
		$this->serializer = $serializerInterface ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Magento\Framework\Serialize\Serializer\JsonHexTag::class);

		parent::__construct($context, $data);
	}

	/**
	 * Retrieve configuration
	 *
	 * @return array
	 * @codeCoverageIgnore
	 */
	public function getConfig() {
		return $this->configProvider->getConfig();
	}

	/**
	 * Retrieve serialized config.
	 *
	 * @return bool|string
	 * @since 100.2.0
	 */
	public function getSerializedConfig() {
		return $this->serializer->serialize($this->getConfig());
	}

}

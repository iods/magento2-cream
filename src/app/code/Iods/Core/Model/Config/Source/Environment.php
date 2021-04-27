<?php declare(strict_types=1);
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade the modules
 * in the Darkstar Magento 2 Suite to newer versions in the future.
 *
 * @category  Iods
 * @package   Iods_Core
 * @version   1.1.1
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2020, Rye Miller (http://ryemiller.io)
 * @license   MIT (https://en.wikipedia.org/wiki/MIT_License)
 */

namespace Iods\Core\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Environment
 * @package Iods\Core\Model\Config\Source
 */
class Environment implements OptionSourceInterface
{
    const ENV_LOCAL = 1;
    const ENV_CLOUD = 2;
    const ENV_PROD  = 3;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getEnvironmentType();
    }

    /**
     * @return array
     */
    public function getEnvironmentType(): array
    {
        return [
            self::ENV_LOCAL => __('Local/Development'),
            self::ENV_CLOUD => __('Cloud'),
            self::ENV_PROD => __('Production')
        ];
    }
}

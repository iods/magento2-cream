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

namespace Iods\Core\Setup\Patch;

use Magento\Framework\App\Area;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Widget\Model\ResourceModel\Widget\Instance as ResourceWidget;
use Magento\Widget\Model\Widget\Instance as Widget;

/**
 * @package Common\Base
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_base
 */
trait TraitWidgetData
{
    /**
     * @return ResourceWidget
     */
    private function getResourceWidget()
    {
        return $this->objectManager->get(ResourceWidget::class);
    }

    /**
     * @param array $data
     * @return Widget
     * @throws AlreadyExistsException
     */
    private function createWidget(array $data)
    {
        return $this->state->emulateAreaCode(
            Area::AREA_FRONTEND,
            function () use ($data) {
                $widget = $this->objectManager->create(Widget::class);
                $this->getResourceWidget()->save($widget->setData($data));
                return $widget;
            }
        );
    }
}

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

namespace Iods\Core\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;


abstract class AbstractAction extends Action
{
    /**
     * @param string $modelName
     * @return array
     * @throws NoSuchEntityException
     */
    protected function loadModel($modelName)
    {
        /* @var $model AbstractModel */
        /* @var $resourceModel AbstractDb */
        [$model, $resourceModel] = $this->getModels($modelName);

        if (($id = $this->getRequest()->getParam('id'))) {
            $resourceModel->load($model, $id);
            if (!$model->getId()) {
                throw new NoSuchEntityException();
            }
        }

        return [$model, $resourceModel];
    }

    /**
     * @param string $modelName
     * @return array
     */
    protected function getModels($modelName)
    {
        $model = $this->_objectManager->create($modelName);
        $resourceModel = $this->_objectManager->create($model->getResourceName());

        return [$model, $resourceModel];
    }
}

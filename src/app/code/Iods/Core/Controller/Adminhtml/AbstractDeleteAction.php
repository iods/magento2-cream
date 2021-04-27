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

use Exception;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;


abstract class AbstractDeleteAction extends AbstractAction implements HttpPostActionInterface
{
    /**
     * @param $modelName
     * @param $noEntityMessage
     * @param $successMessage
     * @return ResultInterface
     */
    protected function delete(
        $modelName,
        $noEntityMessage,
        $successMessage
    ) {
        /* @var $resultRedirect Redirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            [$model, $resourceModel] = $this->loadModel($modelName);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($noEntityMessage));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $resourceModel->delete($model);
            $this->messageManager->addSuccessMessage(__($successMessage));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}

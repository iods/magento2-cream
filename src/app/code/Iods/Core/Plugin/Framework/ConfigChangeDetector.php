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

namespace Iods\Core\Plugin\Block;

use Magento\Deploy\Model\Plugin\ConfigChangeDetector as MagentoConfigChangeDetector;
use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\State;
use Magento\Deploy\Model\DeploymentConfig\ChangeDetector;

/**
 * Prevents config changes from breaking development sites
 */
class ConfigChangeDetector extends MagentoConfigChangeDetector
{
    protected $errors = [];

    protected $appState;

    public function __construct(ChangeDetector $changeDetector, State $appState)
    {
        $this->changeDetector = $changeDetector;
        $this->appState       = $appState;
        parent::__construct($changeDetector);
    }

    public function beforeDispatch(FrontControllerInterface $subject, RequestInterface $request)
    {
        if ($this->appState->getMode() != State::MODE_PRODUCTION) {
            try {
                parent::beforeDispatch($subject, $request);
            } catch (LocalizedException $ex) {
                $this->errors[] = $ex->getMessage();
            }
        }
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function getErrorMessages()
    {
        return $this->errors;
    }
}

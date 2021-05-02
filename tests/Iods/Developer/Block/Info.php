<?php
/**
 * Developer tools for Magento 2
 *
 * @package   Iods_Developer
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2020, Rye Miller (https://ryemiller.io)
 * @license   MIT (https://en.wikipedia.org/wiki/MIT_License)
 */
declare(strict_types=1);

namespace Iods\Developer\Block;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class Info
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class Info extends Template
{
    /**
     * Use the sub construct class.
     *
     * Add the body class to display the hints if they are enabled and the site
     * is deployed in developer mode.
     */
    protected function _construct()
    {
        parent::_construct();
        if ($this->isDeveloperMode() && $this->hintsAreEnabled()) {
            $this->pageConfig->addBodyClass('justinkase-hints-enabled');
        }
    }

    /**
     *
     * Check if app is deployed in developer mode.
     *
     * @return bool
     */
    public function isDeveloperMode()
    {
        return $this->_appState->getMode() === $this->_appState::MODE_DEVELOPER;
    }

    /**
     * Are hints enabled?
     *
     * @return mixed
     */
    public function hintsAreEnabled()
    {
        return $this->_scopeConfig->getValue(WrapperInterface::JK_CONFIG_BLOCK_HINTS_STATUS);
    }
}

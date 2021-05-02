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

namespace Iods\Developer\Plugin;

use Magento\Customer\Model\Session;
use Magento\Themes\Block\Html\Footer;

class DisplayUserIpAddress
{
    protected $_customerSession;

    public function __construct(
        Session $customerSession
    ) {
        $this->_customerSession = $customerSession;
    }

    public function beforeToHtml(Footer $subject)
    {
        if ($subject->getNameInLayout() != 'absolute_footer') {
            return;
        }

        $subject->setTemplate('Iods_Developer::ip_address.phtml');
        $subject->assign('customer', $this->_customerSession->getCustomer());
    }
}

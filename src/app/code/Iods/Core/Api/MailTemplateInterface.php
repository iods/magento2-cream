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

namespace Iods\Core\Api;

interface MailTemplateInterface {

    /**
     * Get email templates id => value
     * @return string
     */
    public function all();


    /**
     * Save email template
     * @return string
     */
    public function save();


    /**
     * Delete email template
     * @return string
     */
    public function deleteone();


    /**
     * Get email template
     * @return string
     */
    public function getone();


}

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

/**
 * Class Multiline
 *
 * @package MageModule\Core\Plugin\Ui\Component\Form\Element
 */
class Multiline
{
    /**
     * This plugin fixes an issue with multiline component where it does not
     * display label, scope label, or notice under field
     *
     * @param \Magento\Ui\Component\Form\Element\Multiline $subject
     * @param \Closure                                     $procede
     *
     * @return null
     */
    public function aroundPrepare($subject, $procede)
    {
        $result = $procede();

        $config     = $subject->getConfiguration();
        $usePlugin  = is_array($config) && isset($config['isMageModuleForm']);
        $components = $subject->getChildComponents();

        if ($usePlugin && is_array($components)) {
            /** @var \Magento\Ui\Component\Form\Field $component */
            $count = count($components);
            foreach ($components as $identifier => $component) {
                $data = $component->getData();

                if (isset($config['label'])) {
                    $data['config']['label'] = $config['label'];
                }

                if (isset($config['scopeLabel'])) {
                    $data['config']['scopeLabel'] = $config['scopeLabel'];
                }

                if (isset($config['notice']) && $count === 1) {
                    $data['config']['notice'] = $config['notice'];
                }

                $component->setData($data);
                $subject->addComponent($identifier, $component);
                $count--;
            }
        }

        return $result;
    }
}

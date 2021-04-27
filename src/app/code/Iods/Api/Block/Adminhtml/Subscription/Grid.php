<?php

namespace AHT\ModuleHelloWorld\Block\Adminhtml\Subscription;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    protected $_subscriptionCollection;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \AHT\ModuleHelloWorld\Model\ResourceModel\Subscription\Collection
        $subscriptionCollection,
        array $data = []
    ) {
        $this->_subscriptionCollection = $subscriptionCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No Subscriptions Found'));
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_subscriptionCollection);
        return parent::_prepareCollection();
    }
    public function _prepareColumns()
    {
        $this->addColumn(
            'subscription_id',
            [
                'header' => __('ID'),
                'index' => 'subscription_id'
            ]
        );

        $this->addColumn(
            'firstname',
            [
                'header' => __('Firstname'),
                'index' => 'firstname'
            ]
        );
        $this->addColumn(
            'lastname',
            [
                'header' => __("Lastname"),
                'index' => 'lastname'
            ]
        );
        $this->addColumn(
            'email',
            [
                'header' => __('Status'),
                'index' => 'status',
                'frame_callback' => [$this, 'decorateStatus']
            ]
        );
        return $this;
    }
    public function decorateStatus($value)
    {
        $class = '';
        switch ($value) {
            case 'pending':
                $class = 'grid-severity-minor';
                break;
            case 'approved':
                $class = 'grid-severity-notice';
                break;
            case 'approved':
                $class = 'grid-severity-critical';
                break;
        }
        return '<span class="' . $class . '"><span>' . $value . '</span></span>';
    }
}

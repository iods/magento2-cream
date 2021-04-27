<?php
/**
* 
* Payment Core para Magento 2
* 
* @category     Dholi
* @package      Modulo Payment Core
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.1.1
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Dholi\Payment\Enumeration;

use Dholi\Core\Lib\Enumeration\AbstractMultiton;

class PaymentMethods extends AbstractMultiton {
	
	public function getModule(): string {
		return $this->module;
	}
	
	protected static function initializeMembers() {
		new static('dholi_payments_payu_cc', 'Dholi_PayU');
		new static('dholi_payments_payu_boleto', 'Dholi_PayU');
		new static('dholi_payments_payu_baloto', 'Dholi_PayU');
		new static('dholi_payments_payu_efecty', 'Dholi_PayU');
		new static('dholi_payments_payu_pagoefectivo', 'Dholi_PayU');
		new static('dholi_payments_payu_oxxo', 'Dholi_PayU');
		new static('dholi_payments_payu_seveneleven', 'Dholi_PayU');
		new static('dholi_payments_payu_multicaja', 'Dholi_PayU');
		new static('dholi_payments_payu_pagofacil', 'Dholi_PayU');
		new static('dholi_payments_payu_rapipago', 'Dholi_PayU');
	}
	
	protected function __construct($key, $module) {
		parent::__construct($key);
		$this->module = $module;
	}
	
	private $module;
}

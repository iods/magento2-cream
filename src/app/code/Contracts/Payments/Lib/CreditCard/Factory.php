<?php

namespace Dholi\Payment\Lib\CreditCard;

use Dholi\Payment\Lib\CreditCard\Cards\AmericanExpress;
use Dholi\Payment\Lib\CreditCard\Cards\Card;
use Dholi\Payment\Lib\CreditCard\Cards\Dankort;
use Dholi\Payment\Lib\CreditCard\Cards\DinersClub;
use Dholi\Payment\Lib\CreditCard\Cards\Discovery;
use Dholi\Payment\Lib\CreditCard\Cards\Elo;
use Dholi\Payment\Lib\CreditCard\Cards\Forbrugsforeningen;
use Dholi\Payment\Lib\CreditCard\Cards\Hipercard;
use Dholi\Payment\Lib\CreditCard\Cards\Jcb;
use Dholi\Payment\Lib\CreditCard\Cards\Maestro;
use Dholi\Payment\Lib\CreditCard\Cards\Mastercard;
use Dholi\Payment\Lib\CreditCard\Cards\Mir;
use Dholi\Payment\Lib\CreditCard\Cards\UnionPay;
use Dholi\Payment\Lib\CreditCard\Cards\Visa;
use Dholi\Payment\Lib\CreditCard\Cards\VisaElectron;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardException;

class Factory {
	protected static $availableCards = [
		// Firs debit cards
		Dankort::class,
		Forbrugsforeningen::class,
		Maestro::class,
		VisaElectron::class,
		// Debit cards
		AmericanExpress::class,
		DinersClub::class,
		Discovery::class,
		Elo::class,
		Jcb::class,
		Hipercard::class,
		Mastercard::class,
		UnionPay::class,
		Visa::class,
		Mir::class,
	];

	/**
	 * @param string $cardNumber
	 *
	 * @return Card
	 * @throws CreditCardException
	 */
	public static function makeFromNumber(string $cardNumber) {
		return self::determineCardByNumber($cardNumber);
	}

	/**
	 * @param string $cardNumber
	 *
	 * @return mixed
	 * @throws CreditCardException
	 */
	protected static function determineCardByNumber(string $cardNumber) {
		foreach (self::$availableCards as $card) {
			if (preg_match($card::$pattern, $cardNumber)) {
				return new $card($cardNumber);
			}
		}

		throw new CreditCardException('Card not found.');
	}
}

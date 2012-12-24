<?php

/**
 * Fuel-Abtest is a package to perform AB tests with 
 * Google Analytics' custom variables in FuelPHP
 *
 * @package    Fuel-Abtests
 * @version    1.0
 * @author     Mariano F.co Benítez Mulet 
 * @license    MIT License
 * @copyright  2012 - 2013 Mariano F.co Benítez Mulet 
 * @link       https://github.com/pachico/fuel-abtest
 */
return array(
	/**
	 * 
	 */
	'session_name' => 'abtests',
	/**
	 * 
	 */
	'cookie_name' => 'abtests',
	/**
	 * 
	 */
	'cookie_ttl' => 86400,
	/**
	 * 
	 */
	'tests' => array(
		'greeting' => array(
			'versions' => array(
				'hithere' => 48,
				'sup' => 123
			)
		),
		'button-colour' => array(
			'versions' => array(
				'red' => 48,
				'blue' => 123
			)
		)
	)
);
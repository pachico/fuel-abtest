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
	 * Name the session key has to store the test
	 */
	'session_name' => 'abtests',
	/**
	 * Name of the cookie
	 */
	'cookie_name' => 'abtests',
	/**
	 * Time-to-live of the cookie
	 */
	'cookie_ttl' => 86400,
	/**
	 * Tests to perform
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
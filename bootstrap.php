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
Autoloader::add_core_namespace('Abtest');

Autoloader::add_classes(array(
	'Abtest\\Abtest' => __DIR__ . '/classes/abtest.php',
));
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

namespace Abtest;

/**
 * 
 */
class Abtest
{

	/**
	 *
	 * @var array
	 */
	private static $_versions = array();

	/**
	 * 
	 */
	public static function _init()
	{

		\Config::load('abtest', true);


		/**
		 * For each test in config
		 */
		foreach (\Config::get('abtest.tests') as $test => $test_options)
		{

			$test_version = false;
			/**
			 * Search if the value in session
			 */
			$test_version = self::_get_from_session($test);

			if ($test_version !== false)
			{
				static::$_versions[$test] = $test_version;
			}
			else
			{
				/**
				 * If not found, search for it in cookie
				 */
				$test_version = static::_get_from_cookie($test);

				if ($test_version !== false)
				{
					static::$_versions[$test] = $test_version;
				}
				else
				{
					/**
					 * Otherwise, firstimers, make a version
					 */
					$test_version = static::_make_version($test_options['versions']);
					static::$_versions[$test] = $test_version;
				}
			}
		}

		/**
		 * Now that all versions are retrieved or set, let's store them
		 */
		\Session::set(\Config::get('abtest.session_name', 'abtests'), static::$_versions);

		/**
		 * Storing cookie as json since it's an array
		 */
		\Cookie::set(\Config::get('abtest.cookie_name', 'abtests'), json_encode(static::$_versions), \Config::get('abtest.cookie_ttl', 86400), '/');

	}

	/**
	 * 
	 * @param string $test_name
	 * @return string
	 */
	public static function get_version($test_name)
	{
		return isset(static::$_versions[$test_name]) ? static::$_versions[$test_name] : false;

	}

	/**
	 * 
	 * @param string $test
	 * @return string|false
	 */
	private static function _get_from_session($test)
	{
		$session = \Session::instance();
		$session_versions = $session->get(\Config::get('abtest.session_name', 'abtests'));

		/**
		 * Session values not set
		 */
		if (empty($session_versions))
		{
			return false;
		}

		/**
		 * If this test is not set
		 */
		if (!isset($session_versions[$test]))
		{
			return false;
		}

		$tests = \Config::get('abtest.tests');
		$version = $session_versions[$test];

		/**
		 * Option saved in session is not present in config, therefore 
		 * return false to be regenerated
		 */
		if (!isset($tests[$test]['versions'][$version]))
		{
			return false;
		}

		return $version;

	}

	/**
	 * 
	 * @param string $test
	 * @return string|false
	 */
	private static function _get_from_cookie($test)
	{

		$cookie_versions = \Cookie::get(\Config::get('abtest.cookie', 'abtests'));

		if (empty($cookie_versions) or !is_array(json_decode($cookie_versions, true)))
		{
			return false;
		}

		$cookie_versions = json_decode($cookie_versions, true);

		/**
		 * If this test is not set
		 */
		if (!isset($cookie_versions[$test]))
		{
			return false;
		}

		$tests = \Config::get('abtest.tests');
		$version = $cookie_versions[$test];

		/**
		 * Option saved in cookie is not present in config, therefore 
		 * return false to be regenerated
		 */
		if (!isset($tests[$test]['versions'][$version]))
		{
			return false;
		}

		return $version;

	}

	/**
	 * 
	 * @param array $test
	 * @return string
	 */
	private static function _make_version(array $test)
	{

		$random_number = mt_rand(0, array_sum($test));

		$chosen_version = false;
		$start_point = 0;

		foreach ($test as $version => $probability)
		{

			if ($random_number >= $start_point && $random_number < ($start_point + $probability))
			{
				$chosen_version = $version;
				break;
			}

			$start_point += $probability;
		}

		return $chosen_version;

	}

	/**
	 * 
	 * @return string
	 */
	public static function get_tracking_code()
	{

		$javascript_code = '';

		if (!empty(static::$_versions))
		{
			$javascript_code .= "<script type='javascript'>\n";
			$ga_string = "
			_gaq.push(['_setCustomVar',
				  1,                  
				  {TEST},     
				  {VERSION}
			   ]);
			";

			foreach (static::$_versions as $test => $version)
			{
				$javascript_code .= str_replace(
						array(
					'{TEST}', '{VERSION}'
						), array(
					"'" . $test . "'",
					"'" . $version . "'"
						), $ga_string);
			}
		}

		$javascript_code .= "</script>\n";

		return $javascript_code;

	}

}

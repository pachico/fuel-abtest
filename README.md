#Introduction
Fuel-Abtest is a simple package to perform AB(C,D, etc.) tests storing results in Google Analutics' custom variables
(https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingCustomVariables).

#Requirements
* FuelPHP
* Google Analitics properly running and saving data

#Installation
	cd /path_to_package_folder/
	git clone https://github.com/pachico/fuel-abtest fuel-abtest

In your bootstrap.php file add the following line:

	\Package::load('fuel-abtest');

#Usage

##Setting up your tests

Everything you need to setup your ab tests is inside the config file.
Setup cookie name and ttl, session key and all tests with their possible options, indicating the probabilities users have to hit each of them.

We will make a simple test to describe the entire flow.
In the config file we will use:

	'tests' => array(
		'button-colour' => array(
			'versions' => array(
				'red' => 75,
				'blue' => 90
			)
		)
	)

This sets a test that will choose more frequently the _blue_ option rather than the _red_ one.
Every time a new user visits the page a version for each tets will be chose, based on the probabilties set in the config file.
__Note:__ The probabilities of the options for each test don't have to sum 100. Chances will be balanced to the proportion of the sum of them all.

##Getting test version inside inside the application
Inside your app, you will want to show/behave according to version assigned to the user. In this example you might want to do something like:

		$button_test_version = \Abtest\Abtest::get_version('button-colour');
		if ($button_test_version === 'red')
		{
			//Do something for the red version of button-colour test
		}
		elseif ($button_test_version === 'green')
		{
			//Do something for the green version of button-colour test
		}

__Note:__ If you remove your test or test versions from the config file but you forget to remove the logic from the app, the _::get_version()_ method will retrieve false. You might, then, want to keep an else, to avoid problems.

##Print Google Analytics custom variables

In any place of your application, then, at _Controller_ or _View_ level, you can retrieve the Javascript code by using:
	
	\Abtest\Abtest::get_tracking_code();

#TODO
* Add unit test.
* Make it Composer compliant.
* Add possibility to make test expiry individually.
* Encrypt Cookie content. If so sanitize corruption attempts.

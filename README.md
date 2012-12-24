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
Everything you need to setup your ab tests is inside the config file.
Setup cookie name and ttl, session key and all tests with their possible options, indicating the probabilities users have to hit each of them.
Note: The probabilities of the options for each test don't have to sum 100. Chances will be balanced to the proportion of the sum of them all.

In any application, then, at _Controller_ or _View_ level, you can retrieve the Javascript code by using:
	
	\Abtest\Abtest::get_tracking_code();

#TODO
* Add unit test.
* Make it Composer compliant.
* Add possibility to make test expiry individually.
* Encrypt Cookie content. If so sanitize corruption attempts.
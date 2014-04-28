geo
===

Geographical data helpers

ISO / FIPS code conversions
===========================

Convert `FIPS 10-4` to `ISO 3166-1` code, or vice versa:

```php
require_once 'vendor/autoload.php';

use DatingVIP\geo\Country_Code;

echo (new Country_Code)->fips2iso ('SG');
// outputs: SN

echo (new Country_Code)->iso2fips ('PR');
// outputs: RQ
```

Postal Code Validation
======================

Validate or parse Postal Codes for almost any country (using regular expressions).
Country codes are accepted in `ISO 3166-1` format.

```php
require_once 'vendor/autoload.php';

use DatingVIP\geo\Postal_Code;
use DatingVIP\geo\Validation_Exception;

$postal_code = new Postal_Code ();

// check if country is covered
var_dump ($postal_code->coveringCountry ('SG'));
// bool(true)

// get an array of human readable postal code formats for given country
var_dump ($postal_code->getFormats ('RS'));
// array(1) {
//  [0]=>
//  string(5) "#####"
//}

// check if zip code is valid
var_dump ($postal_code->isValid ('RS', '11000'));
// bool(true)

try {
	$postal_code->isValid ('WW', '....');
} catch (Validation_Exception $e) {
	var_dump ($e->getMessage());
	// string(26) "Invalid country code: "WW""
}

if ($postal_code->contains ('RS', '11000, Beograd'))
{
	var_dump ($postal_code->capture ('RS', '11000, Beograd'));
	// string(5) "11000"
}
```

Map of wildcards to regexes:
+ `#` = `0-9`
+ `@` = `a-zA-Z`
+ `*` = `a-zA-Z0-9`

State Codes
===========

`ISO 3166-2` principal subdivisions (provinces, states, regions) utility class

```php
require_once 'vendor/autoload.php';

use DatingVIP\geo\State_Code;

$state_code = new State_Code ();

// get available states/regions in given country
var_dump ($state_code->getCountry ('CY'));
//array(6) {
//  ["04"]=>
//  string(12) "Ammóchostos"
//  ["06"]=>
//  string(9) "Kerýneia"
//  ["03"]=>
//  string(8) "Lárnaka"
//  ["01"]=>
//  string(9) "Lefkosía"
//  ["02"]=>
//  string(8) "Lemesós"
//  ["05"]=>
//  string(6) "Páfos"
//}

// get region/state name based on given code
var_dump ($state_code->getName ('CY', '02'));
//string(8) "Lemesós"

// get region/state code based on given name
var_dump ($state_code->get ('US', 'Alabama'));
//string(2) "AL"

// check if given country / state code combo is valid
var_dump ($state_code->isValid ('AB', 'CD'));
//bool(false)

// check if given country / state code combo is valid
var_dump ($state_code->isValid ('RS', '03'));
//bool(true)
```
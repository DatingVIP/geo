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

```
require_once 'vendor/autoload.php';

use DatingVIP\geo\Postal_Code;
use DatingVIP\geo\Validation_Exception;

$postal_code = new Postal_Code ();

// check if country is covered
var_dump ($postal_code->coveringCountry ('SG'));
// bool(true)

// get an array of human readable of postal codes formats for given country
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
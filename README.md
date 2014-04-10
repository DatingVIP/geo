geo
===

Geographical data helpers

ISO / FIPS code conversions
===========================

Convert `FIPS 10-4` to `ISO 3166-1` code, or vice versa:

```php
require_once 'src/DatingVIP/geo/Country_Code.php';

use DatingVIP\geo\Country_Code;

echo (new Country_Code)->fips2iso ('SG');
// outputs: SN

echo (new Country_Code)->iso2fips ('PR');
// outputs: RQ
```
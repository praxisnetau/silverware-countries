# SilverWare Countries Module

Provides a `CountryDropdownField` for use in [SilverStripe v4][silverstripe-framework] forms.

## Contents

- [Background](#background)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Issues](#issues)
- [Contribution](#contribution)
- [Maintainers](#maintainers)
- [License](#license)

## Background

SilverStripe decided to remove `CountryDropdownField` from `framework` in v4, which can be
a pretty handy field when you need an international address entered into a form. This module
provides a replacement field, with similar [configuration](#configuration) options to the original.

## Requirements

- [SilverStripe Framework v4][silverstripe-framework]

## Installation

Installation is via [Composer][composer]:

```
$ composer require silverware/countries
```

## Configuration

As with all SilverStripe modules, configuration is via YAML. There are three
configuration options available for `CountryDropdownField`:

- `default_to_locale` - default setting is false; if set to true, the default value
  for the field will be based on either the locale of the current user, or the default
  locale for the app (obtained from `i18n`).
- `default_country` - default setting is null; defines the country code to use as the
  default value if `default_to_locale` is set to false.
- `invalid_countries` - defines a list of country codes which are considered invalid
  and are removed from the default source data.

### Differences from Original Class

**Note:** `default_to_locale` and `default_country` in this module are different from the
original SilverStripe field. The original class had `default_to_locale`
set to true, and `default_country` set to `NZ`.

You can still set these defaults through configuration if you wish, however I figured
it would be better to not make assumptions about locale or country by default. More often
than not these defaults were overridden for projects using the original field.

## Usage

To make use of the field within your code, simply `use` the class within the header
of your file:

```php
use SilverWare\Countries\Forms\CountryDropdownField;
```

You can then create an instance of the field within your form code:

```php
CountryDropdownField::create('MyCountryCode', 'Country');
```

## Issues

Please use the [GitHub issue tracker][issues] for bug reports and feature requests.

## Contribution

Your contributions are gladly welcomed to help make this project better.
Please see [contributing](CONTRIBUTING.md) for more information.

## Maintainers

[![Colin Tucker](https://avatars3.githubusercontent.com/u/1853705?s=144)](https://github.com/colintucker) | [![Praxis Interactive](https://avatars2.githubusercontent.com/u/1782612?s=144)](http://www.praxis.net.au)
---|---
[Colin Tucker](https://github.com/colintucker) | [Praxis Interactive](http://www.praxis.net.au)

## License

[BSD-3-Clause](LICENSE.md) &copy; Praxis Interactive

[composer]: https://getcomposer.org
[silverstripe-framework]: https://github.com/silverstripe/silverstripe-framework
[issues]: https://github.com/praxisnetau/silverware-countries/issues

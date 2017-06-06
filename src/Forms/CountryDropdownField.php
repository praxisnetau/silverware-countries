<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Countries\Forms
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-countries
 */

namespace SilverWare\Countries\Forms;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Security\Member;
use SilverStripe\i18n\i18n;

/**
 * An extension of the dropdown field class for a country dropdown field.
 *
 * @package SilverWare\Countries\Forms
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-countries
 */
class CountryDropdownField extends DropdownField
{
    /**
     * Should the default value be the current user's locale?
     *
     * @var boolean
     * @config
     */
    private static $default_to_locale = false;
    
    /**
     * Default country code if $default_to_locale is false.
     *
     * @var string
     * @config
     */
    private static $default_country;
    
    /**
     * Defines the country codes to filter from the default source.
     *
     * @var array
     * @config
     */
    private static $invalid_countries = [];
    
    /**
     * Constructs the object upon instantiation.
     *
     * @param string $name Name of field.
     * @param string $title Title of field.
     * @param array|ArrayAccess $source A map of options used as the data source.
     * @param mixed $value Value of field.
     */
    public function __construct($name, $title = null, $source = [], $value = null)
    {
        // Construct Parent:
        
        parent::__construct($name, $title, $source);
        
        // Define Value:
        
        $this->setValue($value);
    }
    
    /**
     * Answers the field type for the template.
     *
     * @return string
     */
    public function Type()
    {
        return 'countrydropdown dropdown';
    }
    
    /**
     * Defines the source options for the receiver.
     *
     * @param array|ArrayAccess $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        return parent::setSource($source ? $source : $this->getDefaultSource());
    }
    
    /**
     * Answers the default source options for the receiver.
     *
     * @return array
     */
    public function getDefaultSource()
    {
        $source  = i18n::getData()->getCountries();
        $invalid = $this->config()->invalid_countries;
        
        return array_filter($source, function($code) use ($invalid) {
            return !in_array($code, $invalid);
        }, ARRAY_FILTER_USE_KEY);
    }
    
    /**
     * Defines the value of the receiver.
     *
     * @param mixed $value
     * @param array|DataObject $data
     *
     * @return $this
     */
    public function setValue($value, $data = null)
    {
        // Check Provided Value:
        
        if ($value && $this->isValidValue($value)) {
            return parent::setValue($value, $data);
        }
        
        // Default to Locale (if enabled):
        
        if ($this->config()->default_to_locale) {
            
            if (($code = $this->getCountryFromLocale()) && $this->isValidValue($code)) {
                return parent::setValue($code, $data);
            }
            
        }
        
        // Default to Country (if defined):
        
        if (($code = $this->config()->default_country) && $this->isValidValue($code)) {
            return parent::setValue($code, $data);
        }
        
        // Answer Self:
        
        return $this;
    }
    
    /**
     * Answers true if the given value is valid for the receiver.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function isValidValue($value)
    {
        return in_array($value, $this->getValidValues());
    }
    
    /**
     * Answers the locale either from the current user or from i18n.
     *
     * @return string
     */
    protected function getLocale()
    {
        if ($member = Member::currentUser()) {
            return $member->getLocale();
        }
        
        return i18n::get_locale();
    }
    
    /**
     * Answers the country code associated with the locale value.
     *
     * @return string
     */
    protected function getCountryFromLocale()
    {
        return i18n::getData()->countryFromLocale($this->getLocale());
    }
}

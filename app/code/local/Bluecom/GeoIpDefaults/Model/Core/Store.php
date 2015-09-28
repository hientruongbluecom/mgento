<?php
class Bluecom_GeoIpDefaults_Model_Core_Store extends Mage_Core_Model_Store{
    public function getDefaultCurrencyCode ()
    {

        // by default we look for the configured currency code
        $result = $this->getConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_DEFAULT);
        // however, in our case we want to determine the default currency depending on the country/continent of the visitor
        $geoCountryCode = null;
        $geoContinentCode = null;
        try {
            // we'll try to get the visitor country/continent
            if (!Mage::getSingleton('core/session')->getCountryCode()) {
                Mage::helper('ugeoip')->getGeoInstance('GeoIP');
                $geoIp = Mage::helper('ugeoip')->getGeoLocation(true);
                $geoCountryCode = $geoIp->getData('countryCode');
                $geoContinentCode = $geoIp->getData('countryContinent');
                Mage::getSingleton('core/session')->setCountryCode($geoCountryCode);
                Mage::getSingleton('core/session')->setContinentCode($geoContinentCode);
            } else {
                $geoCountryCode = Mage::getSingleton('core/session')->getCountryCode();
                $geoContinentCode = Mage::getSingleton('core/session')->getContinentCode();
            }
        } catch (Exception $e) {
            // prevent NOTICE error - for example we are running the code on a localhost
        }
        // first tier check is the specific countries to set the currency for
        // NOTE: you can roll your own logic here depending on your enabled/supported countries/currencies
        // this example assumes that AUD, GBP, JPY, USD, EUR and NZD are the supported currencies

        switch ($geoCountryCode) {
            case "NZ":
                $result = "NZD";
                break;
            case "AU":
                $result = "AUD";
                break;
            case "GB":
                $result = "GBP";
                break;
            default:
                // Now decide what currency to set depending on broad regions
                switch ($geoContinentCode) {
                    case "EU": // we'll set EUR for European countries
                        $result = "EUR";
                        break;
                    case "NA": // North America
                    case "SA": // South America
                    case "AS": // Asia
                    case "AF": // Africa - all of them will see USD
                        $result = "USD";
                        break;
                    default: // everything else uses the default store currency as set in config
                }
        }
        return $result;
    }
}
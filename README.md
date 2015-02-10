Zillow API PHP Wrapper
================================

This is a simple PHP Wrapper for the Zillow API services.

Requirements
------------

depends on PHP 5.4+, Guzzle 4+.

Installation
------------

Add `brentmullen/zillow-api`` as a require dependency in your ``composer.json`` file:

.. code-block:: bash

    php composer.phar require brentmullen/zillow-api:~1.0

Usage
-----

.. code-block:: php

    use ZillowApi\ZillowApiClient;

    $client = new ZillowApiClient('zws-id');

Make requests with a specific API call method:

.. code-block:: php

    // Run GetSearchResults
    $response = $client->execute('GetSearchResults', ['address' => '1600 Pennsylvania Ave NW', 'citystatezip' => 'Washington DC 20006']);

Any Zillow API call will work. Valid methods are:

- GetZestimate
- GetSearchResults
- GetChart
- GetComps
- GetDeepComps
- GetDeepSearchResults
- GetUpdatedPropertyDetails
- GetDemographics
- GetRegionChildren
- GetRegionChart
- GetRateSummary
- GetMonthlyPayments
- CalculateMonthlyPaymentsAdvanced
- CalculateAffordability
- CalculateRefinance
- CalculateAdjustableMortgage
- CalculateMortgageTerms
- CalculateDiscountPoints
- CalculateBiWeeklyPayment
- CalculateNoCostVsTraditional
- CalculateTaxSavings
- CalculateFixedVsAdjustableRate
- CalculateInterstOnlyVsTraditional
- CalculateHELOC


License
-------

MIT license.

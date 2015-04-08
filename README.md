# Overcast
An easy to use wrapper for the [Forecast.io](https://forecast.io) API v2.

Overcast will query the Forecast.io API for weather information for the longitude and latitude you specify. Additionally
you may specify the specific time, past or present. 

See the [Forecast.io API documentation](https://developer.forecast.io/docs/v2) for more information.

## Installation
Installation is as simple as using [Composer](http://getcomposer.org/):

```
{
    "require": {
        "vertigolabs/overcast": "dev-master"
    }
}
```

## Example
Since the Forecast.io API is simple, Overcast is equally easy to use.
Simply create an instance of the Overcast class, then call the getForecast() method.

Overcast::getForecast() returns a nicely structured Forecast object which contains other data structures for handy access to all of the response data from Forecast.io.  

```php
$overcast = new \VertigoLabs\Overcast\Overcast('YOUR API KEY');
$forecast = $overcast->getForecast(37.8267,-122.423);

// check the number of API calls you've made with your API key for today
echo $overcast->getApiCalls().' API Calls Today'."\n";

// temperature current information
echo 'Current Temp: '.$forecast->getCurrently()->getTemperature()->getCurrent()."\n";
echo 'Feels Like: '.$forecast->getCurrently()->getApparentTemperature()->getCurrent()."\n";
echo 'Min Temp: '.$forecast->getCurrently()->getTemperature()->getMin()."\n";
echo 'Max Temp: '.$forecast->getCurrently()->getTemperature()->getMax()."\n";

// get daily summary
echo 'Daily Summary: '.$forecast->getDaily()->getSummary()."\n";

// loop daily data points
foreach($forecast->getDaily()->getData() as $dailyData) {
	echo 'Date: '.$dailyData->getTime()->format('D, M jS y')."\n";
	// get daily temperature information
	echo 'Min Temp: '.$dailyData->getTemperature()->getMin()."\n";
	echo 'Max Temp: '.$dailyData->getTemperature()->getMax()."\n";

	// get daily precipitation information
	echo 'Precipitation Probability: '.$dailyData->getPrecipitation()->getProbability()."\n";
	echo 'Precipitation Intensity: '.$dailyData->getPrecipitation()->getIntensity()."\n";

	// get other general daily information
	echo 'Wind Speed: '.$dailyData->getWindSpeed()."\n";
	echo 'Wind Direction: '.$dailyData->getWindBearing()."\n";
	echo 'Visibility: '.$dailyData->getVisibility()."\n";
	echo 'Cloud Coverage: '.$dailyData->getCloudCover()."\n";
}
```

This will output:

```
18 API Calls Today

Current Temp: 61.05
Feels Like: 61.05
Min Temp: 
Max Temp: 

Daily Summary: Drizzle on Tuesday, with temperatures peaking at 65°F on Thursday.

Date: Tue, Mar 31st 15
Min Temp: 53.83
Max Temp: 61.81
Precipitation Probability: 0
Precipitation Intensity: 0
Wind Speed: 12.77
Wind Direction: 308
Visibility: 8.93
Cloud Coverage: 0.25

Date: Wed, Apr 1st 15
Min Temp: 48.72
Max Temp: 60.08
Precipitation Probability: 0
Precipitation Intensity: 0
Wind Speed: 14.47
Wind Direction: 321
Visibility: 10
Cloud Coverage: 0.06

Date: Thu, Apr 2nd 15
Min Temp: 48.96
Max Temp: 65.46
Precipitation Probability: 0
Precipitation Intensity: 0
Wind Speed: 10.02
Wind Direction: 346
Visibility: 10
Cloud Coverage: 0

Date: Fri, Apr 3rd 15
Min Temp: 49.17
Max Temp: 63.68
Precipitation Probability: 0
Precipitation Intensity: 0
Wind Speed: 6.03
Wind Direction: 292
Visibility: 10
Cloud Coverage: 0.07

Date: Sat, Apr 4th 15
Min Temp: 47.14
Max Temp: 58.44
Precipitation Probability: 0
Precipitation Intensity: 0
Wind Speed: 11.48
Wind Direction: 288
Visibility: 
Cloud Coverage: 0.3

Date: Sun, Apr 5th 15
Min Temp: 47.95
Max Temp: 56.2
Precipitation Probability: 0.09
Precipitation Intensity: 0.0017
Wind Speed: 14.35
Wind Direction: 285
Visibility: 
Cloud Coverage: 0.06

Date: Mon, Apr 6th 15
Min Temp: 44.63
Max Temp: 57.25
Precipitation Probability: 0.01
Precipitation Intensity: 0.0005
Wind Speed: 8.06
Wind Direction: 281
Visibility: 
Cloud Coverage: 0

Date: Tue, Apr 7th 15
Min Temp: 51.23
Max Temp: 60.55
Precipitation Probability: 0.32
Precipitation Intensity: 0.0022
Wind Speed: 8.06
Wind Direction: 258
Visibility: 
Cloud Coverage: 0.24
```

## Todo
* Accept additional API options

# DateTime

_Working with dates, times and timezones_

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.5.4

- [Introduction](#introduction)
- [Configuration](#configuration)
    - [Timezone](#timezone)
    - [Locale & Date Format](#locale)
- [Create a DateTime Instance](#instance)
    - [Cloning](#cloning)
- [String Formatting](#formatting)
- [Date Calculation](#calculation)
    - [Date Time Parts](#parts)
    - [Addition and Subtraction](#add-and-sub)
    - [Differences](#differences)
    - [Start Of and End Of](#start-and-end)
    - [Comparison Methods](#comparison)

<!--
evtl so aufteielen:
    use Traits\ComparisonTrait;
    use Traits\DifferenceTrait;
    use Traits\FactoryTrait;
    use Traits\FormattingTrait;
    use Traits\MagicPropertyTrait;
    use Traits\ModifierTrait;
    use Traits\RelativeKeywordTrait;
    use Traits\TestingAidTrait;
    use Traits\TimezoneTrait;
-->

<a name="introduction"></a>
## Introduction

Pletfix's `DateTime` class extends PHP's [`DateTimeImmutable`](http://php.net/manual/en/class.datetimeimmutable.php) class.

The implementation was also inspired by CakePHP's [Chronos](https://github.com/cakephp/chronos) as well as by 
[Carbon](https://github.com/briannesbitt/Carbon/tree/1.22.1/src/Carbon/Lang), licensed under the MIT license (see 
[here](https://cakephp.org/) and [here](https://github.com/briannesbitt/Carbon/blob/1.22.1/LICENSE)). 

Therefore, this documentation has taken over a few passages from [CakePHP Documentation](https://book.cakephp.org/3.0/en/chronos.html)
and [Carbon Introduction](http://carbon.nesbot.com/docs/).

The language files based on [moment.php](https://github.com/fightbulc/moment.php/tree/1.26.2/src/Locales) by Tino Ehrich, 
licensed under the [MIT License](https://github.com/fightbulc/moment.php/tree/1.26.2#license).

The date values are [immutable](<https://en.wikipedia.org/wiki/Immutable_object>), so you don't have to worry about the 
underlying data being changed by another entity.
TODO letztes stimmt wahrscheinlch nicht

<a name="configuration"></a>
## Configuration

<a name="timezone"></a>
### Timezone

You may set the default timezone in `config/app.php`:

    /**
     * Default Timezone
     */
	'timezone' => 'UTC' // 'Europe/London',
	
#### Switch Timezones

Use `setDefaultTimezone` to switch the active timezone at runtime:

	DateTime::setDefaultTimezone('UTC'); 
	
You can also set the timezone just for a once `DateTime` instance:

	$dt = datetime()->setTimezone('CET');
	
The `getDefaultTimezone` and `getTimezone` methods return the default and actual timezone:

    $tz = DateTime::getDefaultTimezone();    
    $tz = $dt->getTimezone(); // 'Europe/London'	
	
#### Supported Timezones

You can use the abbreviations of timezone identifier like 'UTC', or the full name like 'Europe/London'. 

A completely table of valid timezones is available in the PHP's [List of Supported Timezones](http://php.net/manual/en/timezones.php).

The supported abbreviations are:

Abbr. | Name | UTC offset
--------------------------------------
UTC | Coordinated Universal | [UTC±00](https://en.wikipedia.org/wiki/UTC%C2%B100:00)
CET | Central European Time | UTC+01

See PHP's [`DateTimeZone`] (http://php.net/manual/en/class.datetimezone.php) class.
See also [List of time zone abbreviations](https://en.wikipedia.org/wiki/List_of_time_zone_abbreviations) by Wikipedia.

TODO Liste vervollständigen 	
	
<a name="locale"></a>
### Locale & Date Format

Read chapter [Localization](localization#configuration) to learn how to configure the default locale and switch it at 
runtime. It will be used by the translation service. 

The translation files for the `DateTime` class are defined in `resources/lang/<lang>/datetime.php`, where the locale date 
formats are also defined. Apply the format options from PHP's [`date`](http://php.net/manual/en/function.date.php) function.

#### Switch Locale

The `setDefaultLocale` method switches the default local for the `DateTime`class:
	
	DateTime::setDefaultLocale('de');	

> You can also use the global `locale` method instead, which makes the setting not only for the `DateTime` class, 
> but also for the `Translater`.	

If you like to set the locale just for a once `DateTime` instance, use the `setLocale` method:

	datetime()->setLocale('de');

Of course, there are also the getters:
	
    $lang = DateTime::getDefaultLocale();    
    $lang = $dt->getLocale(); // 'de'	
	
#### Supported Languages

The supported locales for the `DateTime` class are:
 
	ar Arabic
	ca Catalan
	zh Chinese
	cs Czech
	da Danish
	nl Dutch
	en English
	fr French
	de German
	hu Hungarian
	in Indonesian
	it Italian
	ja Japanese
	oc Lengadocian
	pl Polish
	pt Portuguese
	ru Russian
	es Spanish
	se Swedish
	uk Ukrainian
	th Thai
	tr Turkish
	vi Vietnamese

The language files based on [moment.php](https://github.com/fightbulc/moment.php/tree/1.26.2/src/Locales) by Tino Ehrich, 
licensed under the [MIT License](https://github.com/fightbulc/moment.php/tree/1.26.2#license).

The language files based on [Carbon](https://github.com/briannesbitt/Carbon/tree/1.22.1/src/Carbon/Lang) by Brian Nesbitt, 
licensed under the [MIT License](https://github.com/briannesbitt/Carbon/blob/master/LICENSE).

TODO Liste abgleichen oder entfernen


<a name="instance"></a>	
## Create a DateTime Instance

You may use the `datetime` method to get the current time:

	$now = datetime();

The `datetime` method accept also a date formatted string as argument and optional a timezone: 

	$dt = datetime('2015-10-21 16:29:00', 'Europe/London');

If you don't set a timezone, the [default setting](#timezone) is taken.  

Supported date and time formats are listed on the PHP's [DateTime documentation](http://php.net/manual/de/datetime.formats.php)	.
For example, you may set `'today'` as date string if you want to set the time to '00:00:00'.

Furthermore, you can define a specified format as third argument: 

	$dt = datetime('21.10.2015 16:29', null, 'd.m.Y H:i');

Apply the formatting options from PHP's [date_create_from_format](http://php.net/manual/en/datetime.createfromformat.php) function. 
As an additional option, you can set `'locale'`, `'locale.date'` and `'locale.time'` if you like to use the actual 
locale format. 

    $dt = datetime('21.10.2015', null, 'locale.date');

Instead of a string, an array with the date parts can also be passed:

	$dt = datetime([2015, 10, 21, 16, 29, 0], 'UTC');
	
A unix timestamp will be accepted, too:
	
	$timestamp = time();
	$dt = datetime($timestamp);

Last but not least, any `DateTimeInterface` object can also used as argument:

	$dt = datetime(Carbon::now());
	
> The `datetime` function is just a shortcut to get the `Core\Services\DateTime` instance supported by [Dependency Injector](di): 
>    
>       $dt = DI::getInstance()->get('date-time', [$value, $timezone, $format]);

<a name="cloning"></a>
### Cloning

TODO kann weg?

The `cloning`method create a new `DateTime` instance from another:

    $dt = datetime('1970-12-15 00:00:00');
	$dt2 = $dt->cloning()->addDays(1);
	echo $dt->getDay();  // 15
	echo $dt2->getDay(); // 16
	
<a name="formatting"></a>	
## String Formatting

<a name="custom-formats"></a>
#### Custom Formats

The base function for formatting date times is `format`: 

    echo $dt->format('l jS \\of F Y h:i:s A'); // Thursday 25th of December 1975 02:15:16 PM

Apply the options to build the format string from PHP's [date](http://php.net/manual/en/function.date.php) function. 

TODO: Ist der Link richtig?

<a name="default-and-local-formats"></a>
#### Default and Locale Formats

If you do not specify a format string, the [locale format](locale) is used:

    echo $dt->format(); // 25.12.1975 14:15:16
    
For convenience, there are a few other format functions that ultimately call the `format` method: 

    echo $dt->toDateTimeString();       // 1975-12-25 14:15:16  == format('Y-m-d H:i:s') 
    echo $dt->toDateString();           // 1975-12-25           == format('Y-m-d')
    echo $dt->toTimeString();           // 14:15:16             == format('H:i:s') 
    echo $dt->toLocaleDateTimeString(); // 25.12.1975 14:15:16  == format(null)
    echo $dt->toLocaleDateString();     // 25.12.1975           == format(t('datetime.date_format'))
    echo $dt->toLocaleTimeString();     // 14:15:16             == format(t('datetime.time_format'))
    
<a name="common-formats"></a>
#### Common Formats
    
The following are wrappers for the common formats provided in the PHP's [DateTime](http://php.net/manual/en/class.datetime.php) 
class.

    echo $dt->toAtomString();      // 1975-12-25T14:15:16-05:00
    echo $dt->toCookieString();    // Thursday, 25-Dec-1975 14:15:16 EST
    echo $dt->toIso8601String();   // 1975-12-25T14:15:16-0500
    echo $dt->toRfc822String();    // Thu, 25 Dec 75 14:15:16 -0500
    echo $dt->toRfc850String();    // Thursday, 25-Dec-75 14:15:16 EST
    echo $dt->toRfc1036String();   // Thu, 25 Dec 75 14:15:16 -0500
    echo $dt->toRfc1123String();   // Thu, 25 Dec 1975 14:15:16 -0500
    echo $dt->toRfc2822String();   // Thu, 25 Dec 1975 14:15:16 -0500
    echo $dt->toRfc3339String();   // 1975-12-25T14:15:16-05:00
    echo $dt->toRssString();       // Thu, 25 Dec 1975 14:15:16 -0500
    echo $dt->toW3cString();       // 1975-12-25T14:15:16-05:00    

<a name="string"></a>	
#### String Representation

Because the `__toString()` method is defined, the datetime will be print [locale](locale) formatted if you use a
`DateTime` instance in a string context: 

    echo 'Date/Time:' . $dt; // Date/Time: 25.12.1975 14:15:16

<a name="json"></a>	
#### JSON Serializer

The `DateTime` object are serialized into ISO-8601 strings:

    $date = new DateTime("2014-10-23 13:50:10", "Europe/Paris");
    
    echo json_encode([ 'date' => $date ]);
    // {"date":"2014-10-23T13:50:10+0200"}

<a name="calculation"></a>	
## Date Calculation
	
<a name="parts"></a>
### Date Time Parts	

#### Setter

You may set the parts of the datetime like this:

	$halloween = datetime()
		->setYear(2015)
		->setMonth(10)
		->setDay(31)
		->setHour(20)
		->setMinute(30)
		->setSecond(0);

    $hallowen = $dt->setDateTime(2015, 10, 31, 20, 30, 0);

> Note that these methods modifies their own instance. No new instance is created.

#### Getter

Getting parts of a date object can be done like below:

	$dt = datetime('2015-12-31 23:59:58');
	$y = $dt->getYear();   // 2015
	$m = $dt->getMonth();  // 12
	$d = $dt->getDay();    // 31
	$h = $dt->getHour();   // 23
	$n = $dt->getMinute(); // 59
	$s = $dt->getSecond(); // 58

In addition, there are a few other features to get special date parts:

    $dt  = datetime('2012-9-5 23:26:11.123789');
	$ms  = $dt->micro();       // 123789
	$dow = $dt->dayOfWeek();   // 3
	$doy = $dt->dayOfYear();   // 248
	$wom = $dt->weekOfMonth(); // 1
	$woy = $dt->weekOfYear();  // 36
	$dim = $dt->daysInMonth(); // 30
	$ts  = $dt->timestamp();   // 1346901971
	$age = $dt->age();         // 41
	$qu  = $dt->quarter();     // 3
	$qu  = $dt->isLeapYear();  // true
    $b   = $dt->isSunday();    // false
    $b   = $dt->isMonday();    // false 
    $b   = $dt->isTuesday();   // false
    $b   = $dt->isWednesday(); // true
    $b   = $dt->isThursday();  // false
    $b   = $dt->isFriday();    // false
    $b   = $dt->isSaturday();  // false 
		
		
<a name="add-and-sub"></a>		
### Addition and Subtraction

You can also modify parts of a date relatively:

	$future = datetime()->addYear(1);

#### Add
		
	$dt->addYears($y)	
	$dt->addQuarters($q)	
	$dt->addMonths($m)	
	$dt->addWeeks($w)	
	$dt->addDays($d)		
	$dt->addHours($h)	
	$dt->addMinutes($i)	
	$dt->addSeconds($s)	
		
#### Subtract
		
	$dt->subYears($y)	
	$dt->subQuarters($q)	
	$dt->subMonths($m)
    $dt->subWeeks($w)
	$dt->subDays($d)
	$dt->subHours($h)
	$dt->subMinutes($i)
	$dt->subSeconds($s)

<a name="differences"></a>
### Differences

The methods below calculate the difference between two date times:

	$dt1->diffInYears($dt2);
	$dt1->diffInQuarters($dt2);
	$dt1->diffInMonth($dt2);
	$dt1->diffInWeeks($dt2);
	$dt1->diffInDays($dt2);
	$dt1->diffInHours($dt2);
	$dt1->diffInSeconds($dt2);

<a name="start-and-end"></a>		
### Start Of and End Of

You may set the value to the start/end of a unit of time.

#### startOf
	
	$dt->startOfYear();    // set to January 1st, 00:00 this year
	$dt->startOfQuarter(); // set to the beginning of the current quarter, 1st day of months, 00:00
	$dt->startOfMonth();   // set to the first of this month, 00:00
	$dt->startOfWeek();    // set to the first day of this week, 00:00
	$dt->startOfDay();     // set to 00:00 today
	$dt->startOfHour();    // set to now, but with 0 mins, 0 secs
	$dt->startOfMinute();  // set to now, but with 0 seconds

#### endOf
	
	$dt->endOfYear();      // set to December 31st, 23:59 this year
	$dt->endOfQuarter();   // set to the end of the current quarter, last day of month, 23:59
	$dt->endOfMonth();     // set to the last of this month, 23:59
	$dt->endOfWeek();      // set to the last day of this week, 23:59
	$dt->endOfDay();       // set to 23:59 today
	$dt->endOfHour();      // set to now, but with 59 mins, 59 secs
	$dt->endOfMinute();    // set to now, but with 59 seconds

	
<a name="comparison"></a>
### Comparison Methods
	
The extended PHP DateTime class overloads the comparison operators. It is possibible because it is a built in 
implementation. Therefore, you may compare two `DateTime` instances as below:

    $d1 == $d2;
    $d1 != $d2;
    $d1 >= $d2;
    $d1 <= $d2;
    $d1 >  $d2;
    $d1 <  $d2;
    
Furthermore, you may use PHP's `min` and `max` functions:

    min($d1, $d2);
    max($d1, $d2);
	
# DateTime

_Working with dates, times and timezones_

[Since 0.5.0]

- [Introduction](#introduction)
- [Configuration](#configuration)
    - [Timezone](#timezone)
    - [First Day of Week](#first-dow)
    - [Locale & Date Format](#locale)
- [Create a DateTime Instance](#instance)
    - [Static Functions](#create)
    - [datetime](#method-datetime)
    - [copy](#method-copy)
- [String Formatting](#formatting)
- [Date Time Parts](#parts)
    - [Getter](#getter)
    - [Setter](#setter)
- [Date Calculation](#calculation)
    - [Addition and Subtraction](#add-and-sub)
    - [Differences](#differences)
    - [Start Of and End Of](#start-and-end)
    - [Comparison Methods](#comparison)

<a name="introduction"></a>
## Introduction

Pletfix's `DateTime` class extends PHP's [`DateTimeImmutable`](http://php.net/manual/en/class.datetimeimmutable.php) class.
It is very useful to calculate dates and times.

The implementation was also inspired by CakePHP's [Chronos](https://github.com/cakephp/chronos) as well as by 
[Carbon](https://github.com/briannesbitt/Carbon/tree/1.22.1/src/Carbon/Lang), licensed under the MIT license (see 
[here](https://cakephp.org/) and [here](https://github.com/briannesbitt/Carbon/blob/1.22.1/LICENSE)). 
Therefore, this documentation has taken over a few passages from [CakePHP Documentation](https://book.cakephp.org/3.0/en/chronos.html)
and [Carbon Introduction](http://carbon.nesbot.com/docs/).

Except for the setters the methods are [immutable](<https://en.wikipedia.org/wiki/Immutable_object>), so you don't have 
to worry about the underlying data being unintentionally changed by another entity.

<a name="configuration"></a>
## Configuration

<a name="timezone"></a>
### Timezone

You may set the default timezone in `config/app.php`:

    /**
     * ----------------------------------------------------------------
     * Default Timezone
     * ----------------------------------------------------------------
     */
	'timezone' => 'UTC' // 'Europe/London',
	
#### Get and Set the Timezone

Use `setDefaultTimezone` to switch the active timezone at runtime:

	DateTime::setDefaultTimezone('UTC'); 
	
You can also set the timezone just for a once `DateTime` instance:

	$dt = datetime()->setTimezone('CET');
	
The `getDefaultTimezone` and `getTimezone` methods return the default and actual timezone:

    $tz = DateTime::getDefaultTimezone();    
    $tz = $dt->getTimezone(); // 'Europe/London'	
	
The `getOffset` method returns the timezone offset:
                       
    $offset = $dt->getOffset();

#### Supported Timezones

You can use the official abbreviations of timezone identifier like 'UTC', or the full name like 'Europe/London'. 

A completely table of valid timezones is available in the PHP's [List of Supported Timezones](http://php.net/manual/en/timezones.php).

See also [List of time zone abbreviations](https://en.wikipedia.org/wiki/List_of_time_zone_abbreviations) by Wikipedia.

<a name="first-dow"></a>
### First Day of Week

According to international standard ISO 8601, Monday is the first day of the week.
Yet several countries, including the United States and Canada, consider Sunday as the start of the week.

Like the timezone, you can set the first day of week in `config/app.php`:
 
    /**
     * ----------------------------------------------------------------
     * First day of the week.
     * ----------------------------------------------------------------
     */
    'first_dow' => 1, // Monday 

The day of week is an integer between 0 (for Sunday) and 6 (for Saturday).

#### Set the First Day of Week

However, you could determine and redefine the first day of week at runtime:
	
	$dow = DateTime::getFirstDayOfWeek();	
	DateTime::setFirstDayOfWeek('0); // Sunday
	  
<a name="locale"></a>
### Locale & Date Format

Read chapter [Localization](localization#configuration) to learn how to configure the default locale and switch it at 
runtime. It is used to set the locale date and time formats.

The translation files for the `DateTime` class are defined in `datetime.php` under the `resources/lang` directory:
 
    return [
        'datetime' => 'Y-m-d H:i',
        'date'     => 'Y-m-d',
        'time'     => 'H:i',
    ];
 
Apply the format options for this files from PHP's [date_create_from_format](http://php.net/manual/en/datetime.createfromformat.php) 
function.

#### Set the Locale Date and Time Formats

The `setLocale` method switches the locale for the `DateTime`class:
	
	DateTime::setLocale('de');	

> You can also use the global [`locale` method](localization#runtime) instead, which makes the setting not only for the 
> `DateTime` class, but also for the `Translater`.	

Of course, there are also the getters:
	
    $lang = DateTime::getLocale();    
	

<a name="instance"></a>	
## Create a DateTime Instance

<a name="create"></a>	
### Static Functions

Pletfix's `DateTime` class provide some static member functions to create a new `DataTime` instance:

    use Core\Services\DateTime;
    
    DateTime::instance($dateTimeObject);
	DateTime::createFromParts($parts, $timezone);
	DateTime::createFromFormat($format, $dateTimeString, $timezone);
	DateTime::createFromLocaleFormat($format, $dateTimeString, $timezone);
	DateTime::createFromLocaleDateFormat($format, $datetring, $timezone);
	DateTime::createFromLocaleTimeFormat($format, $timeString, $timezone);
	DateTime::createFromTimestamp($timestamp, $timezone);
	DateTime::createFromTimestampUTC($timestamp, $timezone);

> Of course, you could use these functions directly. Disadvantage is then that you create direct dependencies. 
> If you do not like this, use the helper function `datetime` (see below), which takes itself the [Dependency Injector](di).

<a name="method-datetime"></a>	
### `datetime()`

You may use the `datetime` method without arguments to get the current time:

	$now = datetime();

The `datetime` method accept also a date formatted string as argument and optional a timezone: 

	$dt = datetime('2015-10-21 16:29:00', 'Europe/London');

If you don't set a timezone, the [default setting](#timezone) is taken.  

Supported formats for the datetime string are listed on the PHP's [documentation](http://php.net/manual/de/datetime.formats.php).
For example, you may set `'today'` as date string if you want to set the time to '00:00:00'.

Furthermore, you can define a specified format as third argument: 

	$dt = datetime('21.10.2015 16:29', null, 'd.m.Y H:i');

Apply the formatting options from PHP's [date_create_from_format](http://php.net/manual/en/datetime.createfromformat.php) function. 
As an additional option, you can set `'locale'`, `'locale.date'` and `'locale.time'` if you like to use the actual 
locale format:

    $dt = datetime('21.10.2015', null, 'locale.date');

Instead of a string, an array with the date parts can also be passed:

	$dt = datetime([2015, 10, 21, 16, 29, 0], 'UTC');
	
A unix timestamp will be accepted, too:
	
	$timestamp = time();
	$dt = datetime($timestamp);

Last but not least, any `DateTimeInterface` object can also used as argument:

	$dt = datetime(Carbon::now());
	
<a name="method-copy"></a>
### `copy()`

The `copy`method create a new `DateTime` instance from another:

    $dt = datetime('1970-12-15 00:00:00');
	$dt2 = $dt->copy()->addDays(1);
	echo $dt->getDay();  // 15
	echo $dt2->getDay(); // 16
	
<a name="formatting"></a>	
## String Formatting

<a name="custom-formats"></a>
#### Custom Formats

The base function for formatting date times is `format`: 

    echo $dt->format('l jS \\of F Y h:i:s A'); // Thursday 25th of December 1975 02:15:16 PM

Apply the options to build the format string from PHP's [date_create_from_format](http://php.net/manual/en/datetime.createfromformat.php) function. 

<a name="default-and-local-formats"></a>
#### Default and Locale Formats

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

Because the `__toString()` method is defined, the datetime will be print locale formatted if you use a `DateTime` 
instance in a string context: 

    echo 'Date/Time:' . $dt; // Date/Time: 25.12.1975 14:15:16

<a name="json"></a>	
#### JSON Serializer

The `DateTime` object are serialized into ISO-8601 strings:

    $dt = new DateTime('2017-12-24 20:00:00', 'Europe/Paris');
    echo json_encode([ 'date' => $dt ]); // {"date":"2017-12-24T20:00:10+0200"}

<a name="parts"></a>
### Date Time Parts	

<a name="getter"></a>
### Getter

Get the unix timestamp like this:

    $unixtimestamp = $dt->getTimestamp();
    
> Note that for dates before the unix epoch (1970-01-01 00:00:00 GMT) `getTimestamp()` will return false, wheres 
> `timestamp()` will return a negative number.    

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
		
<a name="setter"></a>	
### Setter

You can set the date and time based on a Unix timestamp like this:

    $dt->setTimestamp($unixtimestamp);

You may set the parts of the datetime like this:

	$halloween = datetime()
		->setYear(2015)
		->setMonth(10)
		->setDay(31)
		->setHour(20)
		->setMinute(30)
		->setSecond(0);

    $hallowen = datetime()
        ->setDate (2015, 10, 31)
        ->setTime (20, 30, 0);

    $hallowen = datetime()
        ->setDateTime(2015, 10, 31, 20, 30, 0);

    $hallowen = datetime()->setISODate( 2015, 44, 6); arguments: year, week, day    

See PHP' [setISODate](http://php.net/manual/en/datetime.setisodate.php) to read more about `setISODate` method.

> Note that these methods modifies their own instance. No new instance is created.


<a name="calculation"></a>	
## Date Calculation
			
<a name="add-and-sub"></a>		
### Addition and Subtraction

The PHP's `DateTime` class provides the functions `add`, `sub` and `modify` for addition an subtraction dates and times, 
for example:  

    $dt->add(new DateInterval('P10D'));
    $dt->sub(new DateInterval('P10D'));
    $dt->modify('+1 day'); 
    
See the PHP's [documentation](http://de2.php.net/manual/en/datetime.add.php) to read more details.    

However, it may be easier to use the following extended functions for modify dates and times relatively:

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

The PHP's base function `diff` returns the difference between two `DateTime` objects represented as a `DateInterval`.

    $interval = $dt1->diff($dt2);

The methods below calculate also the difference between two `DateTime` objects, but returns an integer: 

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
	
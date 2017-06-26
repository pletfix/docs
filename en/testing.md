<style>

</style>

# Testing

_Test your code with PHPUnit and Mink_

<!--
    TODO: Travis CI
        https://travis-ci.org
        https://www.thewebhatesme.com/entwicklung/travis-ci/
        https://tester.nette.org/en/testing-with-travis
-->

[Since 0.5.0]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Running Tests](#cli)
- [Code Coverage](#code-coverage)
- [Writing Unit Tests](#unit-tests)
    - [Available Unit Test Methods](#unit-test-methods)
- [Writing Integration Tests](#integration-tests)
    - [Available Integration Test Methods](#integration-test-methods)

<a name="introduction"></a>
## Introduction
        
Pletfix comes with [PHPUnit](https://phpunit.de/) for [Unit Testing](https://en.wikipedia.org/wiki/Unit_testing)
and [Mink](http://mink.behat.org/) for [Integration Testing](https://en.wikipedia.org/wiki/Integration_testing).

<a name="configuration"></a>
## Configuration

The default test options for your application are stored in `phpunit.xml.dist` under the application root folder.
In addition, all plugins should include a `phpunit.xml.dist` with test settings.

Read [The Appendix C - The XML Configuration File](https://phpunit.de/manual/5.7/en/appendixes.configuration.html#appendixes.configuration.whitelisting-files)  
by the official PHPUnit Page to learn what options are available.

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Don't modify this files directly because it comes with the git repository. The changes would be overwritten by the next 
> update! Rather, you should copy `phpunit.xml.dist` to `phpunit.xml` (without ".dist") which you can edit.
>
> `phpunit.xml.dist` is ignored by PHPUnit if `phpunit.xml` exists in the same directory. 

<a name="cli"></a>
## Running Tests

Just enter this command in the terminal to run all tests you have defined:

    vendor/bin/phpunit

You can enter a class as argument to run only one test case:

    vendor/bin/phpunit tests/ExampleTest
    
Use switch `-c` to run the test suites that comes with a plugin (or another third party package) like below:
    
    vendor/bin/phpunit -c ./vendor/pletfix/core
    
The following code shows how to run tests with the PHPUnit command-line test runner:

    HPUnit 5.7.14 by Sebastian Bergmann and contributors.
    
    ..                                                                  2 / 2 (100%)
    
    Time: 91 ms, Memory: 6.50MB
    
    OK (2 tests, 2 assertions)

For each test run, the PHPUnit command-line tool prints one character to indicate progress:

- . - The test succeeds.
- F - An assertion fails while running the test method.
- E - An error occurs while running the test method.
- R - The test has been marked as risky.
- S - The test has been skipped.
- I - Test is marked as being incomplete or not yet implemented.

See <https://phpunit.de/manual/5.7/en/textui.html> for more information.

<a name="code-coverage"></a>
## Code Coverage

By default the [Pletfix Application Skeleton](https://github.com/pletfix/app) has pre-configured the unit test to 
generate a code coverage. The files for that are stored in `storage/coverage` as HTML report.

Without a route entry, these pages can not be displayed with the browser. Either you change the default, or you create 
a symlink anywhere under the web root but outside the application. To do this, change to the application directory and 
enter a command in the terminal such like:
    
    ln -s .storage/temp/coverage/ ../coverage
    
Now you can view the report with the browser by visiting this folder.
    
![Code Coverage Report](https://raw.githubusercontent.com/pletfix/docs/master/images/testing_coverage.png)
    
<a name="unit-tests"></a>
## Writing Unit Tests

Create the test class in folder `tests`, e.g.:

    <?php
    
    use Core\Testing\TestCase;
    
    class ExampleTest extends TestCase
    {
        /**
         * A basic functional test example.
         */
        public function testBasicExample()
        {
            $this->assertEquals(1, 1);
        }
    }
    
Please note that the test cases have some conventions:

- PHP files containing tests should be in your `tests` directory.
- The names of these files should end in "Test.php".
- The classes containing tests should extend `Core\Testing\TestCase` (for unit tests) or `Core\Testing\MinkTestCase` (for integration tests).
- The name of any method containing a test should begin with "test".     

<a name="unit-test-methods"></a>
### Available Unit Test Methods

You may define test methods as you normally would using PHPUnit. 
See the [PHPUnit Documentation](https://phpunit.de/manual/current/en/appendixes.assertions.html) for additional information.

<div class="method-list" markdown="1">

[assertArrayHasKey](#method-assertArrayHasKey)
[assertArraySubset](#method-assertArraySubset)
[assertClassHasAttribute](#method-assertClassHasAttribute)
[assertClassHasStaticAttribute](#method-assertClassHasStaticAttribute)
[assertContains](#method-assertContains)
[assertContainsOnly](#method-assertContainsOnly)
[assertContainsOnlyInstancesOf](#method-assertContainsOnlyInstancesOf)
[assertCount](#method-assertCount)
[assertDirectoryExists](#method-assertDirectoryExists)
[assertDirectoryIsReadable](#method-assertDirectoryIsReadable)
[assertDirectoryIsWritable](#method-assertDirectoryIsWritable)
[assertEmpty](#method-assertEmpty)
[assertEqualXMLStructure](#method-assertEqualXMLStructure)
[assertEquals](#method-assertEquals)
[assertFalse](#method-assertFalse)
[assertFileEquals](#method-assertFileEquals)
[assertFileExists](#method-assertFileExists)
[assertFileIsReadable](#method-assertFileIsReadable)
[assertFileIsWritable](#method-assertFileIsWritable)
[assertGreaterThan](#method-assertGreaterThan)
[assertGreaterThanOrEqual](#method-assertGreaterThanOrEqual)
[assertInfinite](#method-assertInfinite)
[assertInstanceOf](#method-assertInstanceOf)
[assertInternalType](#method-assertInternalType)
[assertIsReadable](#method-assertIsReadable)
[assertIsWritable](#method-assertIsWritable)
[assertJsonFileEqualsJsonFile](#method-assertJsonFileEqualsJsonFile)
[assertJsonStringEqualsJsonFile](#method-assertJsonStringEqualsJsonFile)
[assertJsonStringEqualsJsonString](#method-assertJsonStringEqualsJsonString)
[assertLessThan](#method-assertLessThan)
[assertLessThanOrEqual](#method-assertLessThanOrEqual)
[assertNan](#method-assertNan)
[assertNull](#method-assertNull)
[assertObjectHasAttribute](#method-assertObjectHasAttribute)
[assertRegExp](#method-assertRegExp)
[assertSame](#method-assertSame)
[assertStringMatchesFormat](#method-assertStringMatchesFormat)
[assertStringMatchesFormatFile](#method-assertStringMatchesFormatFile)
[assertStringEndsWith](#method-assertStringEndsWith)
[assertStringEqualsFile](#method-assertStringEqualsFile)
[assertStringStartsWith](#method-assertStringStartsWith)
[assertThat](#method-assertThat)
[assertTrue](#method-assertTrue)
[assertXmlFileEqualsXmlFile](#method-assertXmlFileEqualsXmlFile)
[assertXmlStringEqualsXmlFile](#method-assertXmlStringEqualsXmlFile)
[assertXmlStringEqualsXmlString](#method-assertXmlStringEqualsXmlString)

</div>

<a name="unit-test-method-listing"></a>
### Unit Test Method Listing

<a name="method-assertArrayHasKey"></a>
#### `assertArrayHasKey()` {.method .first-method}

Reports an error if the array does not have the key.
`assertArrayNotHasKey()` is the inverse of this assertion.    

    $this->assertArrayHasKey('foo', ['bar' => 'baz']);


<a name="method-assertArraySubset"></a>
#### `assertArraySubset()` {.method}

Reports an error if $array does not contains the $subset.

    $this->assertArraySubset(['config' => ['key-a', 'key-b']], ['config' => ['key-a']]);
    
    
<a name="method-assertClassHasAttribute"></a>
#### `assertClassHasAttribute()` {.method}

Reports an error if the class attribute does not exist.
`assertClassNotHasAttribute()` is the inverse of this assertion.

    $this->assertClassHasAttribute('foo', stdClass::class);


<a name="method-assertClassHasStaticAttribute"></a>
#### `assertClassHasStaticAttribute()` {.method}

Reports an error if the class attribute does not exist.
`assertClassNotHasStaticAttribute()` is the inverse of this assertion.

    $this->assertClassHasStaticAttribute('foo', stdClass::class);


<a name="method-assertContains"></a>
#### `assertContains()` {.method}

Reports an error if the needle is not an element of the haystack.

    $this->assertContains(4, [1, 2, 3]);


<a name="method-assertContainsOnly"></a>
#### `assertContainsOnly()` {.method}

Reports an error if the haystack does not contain only variables of the given type.

    $this->assertContainsOnly('string', ['1', '2', 3]);
    

<a name="method-assertContainsOnlyInstancesOf"></a>
#### `assertContainsOnlyInstancesOf()` {.method}

Reports an error if the haystack does not contain only instances of the given class.

    $this->assertContainsOnlyInstancesOf(Foo::class, [new Foo, new Bar, new Foo]);
    
    
<a name="method-assertCount"></a>
#### `assertCount()` {.method}

Reports an error if the number of elements in the haystack is not the expected count.
`assertNotCount()` is the inverse of this assertion.

    $this->assertCount(0, ['foo']);


<a name="method-assertDirectoryExists"></a>
#### `assertDirectoryExists()` {.method}

Reports an error if the specified directory does not exist.
`assertDirectoryNotExists()` is the inverse of this assertion.

    $this->assertDirectoryExists('/path/to/directory');


<a name="method-assertDirectoryIsReadable"></a>
#### `assertDirectoryIsReadable()` {.method}

Reports an error if the directory specified by $directory is not a directory or is not readable.
`assertDirectoryNotIsReadable()` is the inverse of this assertion.

    $this->assertDirectoryIsReadable('/path/to/directory');
    
    
<a name="method-assertDirectoryIsWritable"></a>
#### `assertDirectoryIsWritable()` {.method}

Reports an error if the directory specified by $directory is not a directory or is not writable.
`assertDirectoryNotIsWritable()` is the inverse of this assertion.

    $this->assertDirectoryIsWritable('/path/to/directory');
    
    
<a name="method-assertEmpty"></a>
#### `assertEmpty()` {.method}

Reports an error if the given value is not empty.
`assertNotEmpty() is the inverse of this assertion.

    $this->assertEmpty(['foo']);


<a name="method-assertEqualXMLStructure"></a>
#### `assertEqualXMLStructure()` {.method}

Reports an error if the XML Structure of the given DOMElement is not equal to the expected XML structure.

    // failure with different node attributes

    $expected = new DOMDocument;
    $expected->loadXML('<foo bar="true" />');

    $actual = new DOMDocument;
    $actual->loadXML('<foo/>');

    $this->assertEqualXMLStructure(
      $expected->firstChild, $actual->firstChild, true
    );


<a name="method-assertEquals"></a>
#### `assertEquals()` {.method}

Reports an error if the two variables are not equal.
`assertNotEquals()` is the inverse of this assertion.

    $this->assertEquals('bar', 'baz');
    

<a name="method-assertFalse"></a>
#### `assertFalse()` {.method}

Reports an error if the condition is true.
`assertNotFalse()` is the inverse of this assertion.

    $this->assertFalse(true);
    

<a name="method-assertFileEquals"></a>
#### `assertFileEquals()` {.method}

Reports an error if the actual file does not have the same contents as the expected file.
`assertFileNotEquals()` is the inverse of this assertion.

    $this->assertFileEquals('/home/sb/expected', '/home/sb/actual');


<a name="method-assertFileExists"></a>
#### `assertFileExists()` {.method}

Reports an error if the given file does not exist.
`assertFileNotExists()` is the inverse of this assertion.

    $this->assertFileExists('/path/to/file');
    

<a name="method-assertFileIsReadable"></a>
#### `assertFileIsReadable()` {.method}

Reports an error if the given file is not a real file or is not readable.
`assertFileNotIsReadable()` is the inverse of this assertion.

    $this->assertFileIsReadable('/path/to/file');
    
   
<a name="method-assertFileIsWritable"></a>
#### `assertFileIsWritable()` {.method}

Reports an error if the given file is not a real file or is not writable.
`assertFileNotIsWritable()` is the inverse of this assertion.

    $this->assertFileIsWritable('/path/to/file');
    

<a name="method-assertGreaterThan"></a>
#### `assertGreaterThan()` {.method}

Reports an error if the actual value is not greater than the expected value.

    $this->assertGreaterThan(2, 1);


<a name="method-assertGreaterThanOrEqual"></a>
#### `assertGreaterThanOrEqual()` {.method}

Reports an error if the actual value is not greater than or equal to the expected value.

    $this->assertGreaterThanOrEqual(2, 1);


<a name="method-assertInfinite"></a>
#### `assertInfinite()` {.method}

Reports an error if the given variable is not INF. 
`assertFinite()` is the inverse of this assertion.

    $this->assertInfinite(1);
    

<a name="method-assertInstanceOf"></a>
#### `assertInstanceOf()` {.method}

Reports an error if $actual is not an instance of $expected.
`assertNotInstanceOf()` is the inverse of this assertion.

    $this->assertInstanceOf(RuntimeException::class, new Exception);
    
    
<a name="method-assertInternalType"></a>
#### `assertInternalType()` {.method}

Reports an error if $actual is not of the $expected type.
`assertNotInternalType()` is the inverse of this assertion.

    $this->assertInternalType('string', 42);
    
    
<a name="method-assertIsReadable"></a>
#### `assertIsReadable()` {.method}

Reports an error if the file or directory specified by $filename is not readable.
`assertNotIsReadable()` is the inverse of this assertion.

    $this->assertIsReadable('/path/to/unreadable');
    
    
<a name="method-assertIsWritable"></a>
#### `assertIsWritable()` {.method}

Reports an error if the file or directory specified by $filename is not writable.
`assertNotIsWritable()` is the inverse of this assertion.

    $this->assertIsWritable('/path/to/unwritable');
    
    
<a name="method-assertJsonFileEqualsJsonFile"></a>
#### `assertJsonFileEqualsJsonFile()` {.method}

Reports an error if the value of $actualFile does not match the value of $expectedFile.

    $this->assertJsonFileEqualsJsonFile('path/to/fixture/file', 'path/to/actual/file');
    
    
<a name="method-assertJsonStringEqualsJsonFile"></a>
#### `assertJsonStringEqualsJsonFile()` {.method}

Reports an error if the value of $actualJson does not match the value of $expectedFile.

    $this->assertJsonStringEqualsJsonFile('path/to/fixture/file', json_encode(['Mascot' => 'ux']));
    
    
<a name="method-assertJsonStringEqualsJsonString"></a>
#### `assertJsonStringEqualsJsonString()` {.method}

Reports an error if the value of $actualJson does not match the value of $expectedJson.

    $this->assertJsonStringEqualsJsonString(
        json_encode(['Mascot' => 'Tux']),
        json_encode(['Mascot' => 'ux'])
    );
    
    
<a name="method-assertLessThan"></a>
#### `assertLessThan()` {.method}

Reports an error if the value of $actual is not less than the value of $expected.

    $this->assertLessThan(1, 2);
    
    
<a name="method-assertLessThanOrEqual"></a>
#### `assertLessThanOrEqual()` {.method}

Reports an error if the value of $actual is not less than or equal to the value of $expected.

    $this->assertLessThanOrEqual(1, 2);
    
    
<a name="method-assertNan"></a>
#### `assertNan()` {.method}

Reports an error if if $variable is not NAN.

    $this->assertNan(1);
    
    
<a name="method-assertNull"></a>
#### `assertNull()` {.method}

Reports an error if $variable is not null.
`assertNotNull()` is the inverse of this assertion.

    $this->assertNull('foo');
    
    
<a name="method-assertObjectHasAttribute"></a>
#### `assertObjectHasAttribute()` {.method}

Reports an error if $object->attributeName does not exist.
`assertObjectNotHasAttribute()` is the inverse of this assertion.

    $this->assertObjectHasAttribute('foo', new stdClass);
    
    
<a name="method-assertRegExp"></a>
#### `assertRegExp()` {.method}

Reports an error if $string does not match the regular expression $pattern.
`assertNotRegExp()` is the inverse of this assertion.

    $this->assertRegExp('/foo/', 'bar');
    
    
<a name="method-assertSame"></a>
#### `assertSame()` {.method}

Reports an error if the two variables $expected and $actual do not have the same type and value.
`assertNotSame()` is the inverse of this assertion.

    $this->assertSame('2204', 2204);
    
    
<a name="method-assertStringMatchesFormat"></a>
#### `assertStringMatchesFormat()` {.method}

Reports an error if the $string does not match the $format string.
`assertStringNotMatchesFormat()` is the inverse of this assertion.

The format string (first argument) may contain the following placeholders:

- %e: Represents a directory separator, for example / on Linux.
- %s: One or more of anything (character or white space) except the end of line character.
- %S: Zero or more of anything (character or white space) except the end of line character.
- %a: One or more of anything (character or white space) including the end of line character.
- %A: Zero or more of anything (character or white space) including the end of line character.
- %w: Zero or more white space characters.
- %i: A signed integer value, for example +3142, -3142.
- %d: An unsigned integer value, for example 123456.
- %x: One or more hexadecimal character. That is, characters in the range 0-9, a-f, A-F.
- %f: A floating point number, for example: 3.142, -3.142, 3.142E-10, 3.142e+10.
- %c: A single character of any sort.    

    $this->assertStringMatchesFormat('%i', 'foo');
        
        
<a name="method-assertStringMatchesFormatFile"></a>
#### `assertStringMatchesFormatFile()` {.method}

Reports an error if the $string does not match the contents of the $formatFile.
`assertStringNotMatchesFormatFile()` is the inverse of this assertion.

    $this->assertStringMatchesFormatFile('/path/to/expected.txt', 'foo');
    
    
<a name="method-assertStringEndsWith"></a>
#### `assertStringEndsWith()` {.method}

Reports an error if the $string does not end with $suffix.
`assertStringEndsNotWith()` is the inverse of this assertion.

    $this->assertStringEndsWith('suffix', 'foo');
    
    
<a name="method-assertStringEqualsFile"></a>
#### `assertStringEqualsFile()` {.method}

Reports an error if the file specified by $expectedFile does not have $actualString as its contents.
`assertStringNotEqualsFile()` is the inverse of this assertion.

    $this->assertStringEqualsFile('/home/sb/expected', 'actual');
    
    
<a name="method-assertStringStartsWith"></a>
#### `assertStringStartsWith()` {.method}

Reports an error if the $string does not start with $prefix.
`assertStringStartsNotWith()` is the inverse of this assertion.

    $this->assertStringStartsWith('prefix', 'foo');
    
    
<a name="method-assertThat"></a>
#### `assertThat()` {.method}

Reports an error if the $value does not match the $constraint.

    $theBiscuit = new Biscuit('Ginger');
    $myBiscuit  = new Biscuit('Ginger');

    $this->assertThat(
        $theBiscuit,
        $this->logicalNot(
            $this->equalTo($myBiscuit)
        )
    );
    
    See the [original PHPUnit Documentation](https://phpunit.de/manual/5.7/en/appendixes.assertions.html#appendixes.assertions.assertThat) for more details.
    
<a name="method-assertTrue"></a>
#### `assertTrue()` {.method}

Reports an error if the condition is false.
`assertNotTrue()` is the inverse of this assertion.

    $this->assertTrue(false);
    

<a name="method-assertXmlFileEqualsXmlFile"></a>
#### `assertXmlFileEqualsXmlFile()` {.method}

Reports an error if the XML document in $actualFile is not equal to the XML document in $expectedFile.
`assertXmlFileNotEqualsXmlFile()` is the inverse of this assertion.

    $this->assertXmlFileEqualsXmlFile('/home/sb/expected.xml', '/home/sb/actual.xml');
    
    
<a name="method-assertXmlStringEqualsXmlFile"></a>
#### `assertXmlStringEqualsXmlFile()` {.method}

Reports an error if the XML document in $actualXml is not equal to the XML document in $expectedFile.
`assertXmlStringNotEqualsXmlFile()` is the inverse of this assertion.

    $this->$this->assertXmlStringEqualsXmlFile('/home/sb/expected.xml', '<foo><baz/></foo>');
    
    
<a name="method-assertXmlStringEqualsXmlString"></a>
#### `assertXmlStringEqualsXmlString()` {.method}

Reports an error if the XML document in $actualXml is not equal to the XML document in $expectedXml.
`assertXmlStringNotEqualsXmlString()` is the inverse of this assertion.

    $this->$this->assertXmlStringEqualsXmlString('<foo><bar/></foo>', '<foo><baz/></foo>');
    
    
<a name="integration-tests"></a>
## Writing Integration Tests

    <?php
    
    use Core\Testing\MinkTestCase;
    
    class ExampleTest extends MinkTestCase
    {
        /**
         * A mink test example.
         */
        public function testMinkExample()
        {
            $url = config('app.url');
            $this->session->visit($url);
            $page = $this->session->getPage();
    
            $title = $page->find('xpath', '//title');
            if ($title !== null) {
                $title = $title->getText();
            }
    
            $this->assertEquals($title, 'Pletfix Workbench');
        }    
    }
    
<a name="integration-test-methods"></a>
### Available Integration Test Methods

You may define test methods as you normally would using Mink. 
See the [Mink Documentation](http://mink.behat.org/en/latest/index.html) for additional information.

<div class="method-list" markdown="1">

[attachFile](#method-attachFile)
[attachFileToField](#method-attachFileToField)
[back](#method-back)
[blur](#method-blur)
[check](#method-check)
[checkField](#method-checkField)
[click](#method-click)
[clickLink](#method-clickLink)
[doubleClick](#method-doubleClick)
[evaluateScript](#method-evaluateScript)
[executeScript](#method-executeScript)
[fillField](#method-fillField)
[find](#method-find)
[findButton](#method-findButton)
[findById](#method-findById)
[findField](#method-findField)
[findLink](#method-findLink)
[focus](#method-focus)
[forward](#method-forward)
[getAttribute](#method-getAttribute)
[getCookie](#method-getCookie)
[getCurrentUrl](#method-getCurrentUrl)
[getPage](#method-getPage)
[getHtml](#method-getHtml)
[getOuterHtml](#method-getOuterHtml)
[getResponseHeader](#method-getResponseHeader)
[getResponseHeaders](#method-getResponseHeaders)
[getScreenshot](#method-getScreenshot)
[getStatusCode](#method-getStatusCode)
[getTagName](#method-getTagName)
[getText](#method-getText)
[getWindowName](#method-getWindowName)
[getWindowNames](#method-getWindowNames)
[getValue](#method-getValue) 
[has](#method-has)
[hasAttribute](#method-hasAttribute)
[hasButton](#method-hasButton)
[hasCheckedField](#method-hasCheckedField)
[hasClass](#method-hasClass)
[hasField](#method-hasField)
[hasLink](#method-hasLink)
[hasSelect](#method-hasSelect)
[hasTable](#method-hasTable)
[hasUncheckedField](#method-hasUncheckedField)
[isChecked](#method-isChecked)
[isSelected](#method-isSelected)
[isVisible](#method-isVisible)
[keyDown](#method-keyDown)
[keyPress](#method-keyPress)
[keyUp](#method-keyUp)
[maximizeWindow](#method-maximizeWindow)
[mouseOver](#method-mouseOver)
[rightClick](#method-rightClick)
[reload](#method-reload)
[press](#method-press)
[pressButton](#method-pressButton)
[resizeWindow](#method-resizeWindow)
[selectFieldOption](#method-selectFieldOption)
[selectOption](#method-selectOption)
[setBasicAuth](#method-setBasicAuth)
[setCookie](#method-setCookie)
[setRequestHeader](#method-setRequestHeader)
[setValue](#method-setValue)
[switchToIFrame](#method-switchToIFrame)
[switchToWindow](#method-switchToWindow)
[submit](#method-submit)
[visit](#method-visit)
[uncheck](#method-uncheck)
[uncheckField](#method-uncheckField)
[wait](#method-wait)

</div>

<a name="integration-test-method-listing"></a>
### Integration Test Method Listing

<a name="method-attachFile"></a>
#### `attachFile()` {.method .first-method}
     
Attaches a file in a file input.

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->attachFile($path);
    
    
<a name="method-attachFileToField"></a>
#### `attachFileToField()` {.method}
     
Attaches file to file field with specified locator (input id, name or label).

    $page = $this->session->getPage();   
    $page->attachFileToField($locator, $path);
    

<a name="method-back"></a>
#### `back()` {.method}

Moves backward 1 page in history.

    $this->session->back();
    
    
<a name="method-blur"></a>
#### `blur()` {.method}
     
Removes focus from element.

See also [focus](#method-focus). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->blur(); 
        
        
<a name="method-check"></a>
#### `check()` {.method}
     
Checks a checkbox field.

See also [uncheck](#method-uncheck) and [isChecked](#method-isChecked). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->check();
    
    
<a name="method-checkField"></a>
#### `checkField()` {.method}
     
Checks checkbox with specified locator (input id, name or label).

See also [uncheckField](#method-uncheckField) and [hasCheckedField](#method-hasCheckedField). 

    $page = $this->session->getPage();
    $page->checkField($locator);  


<a name="method-click"></a>
#### `click()` {.method}
     
This method lets you click the links on the page.

See also [clickLink](#method-clickLink), [doubleClick](#method-doubleClick), [rightClick](#method-rightClick) and [press](#method-press)

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->click();

          
<a name="method-clickLink"></a>
#### `clickLink()` {.method}
     
Clicks link with specified locator (link id, title, text or image alt).

See also [click](#method-click)

    $page = $this->session->getPage();  
    $page->clickLink($locator);
    
    
<a name="method-doubleClick"></a>
#### `doubleClick()` {.method}
     
Performs a double click on the element.

See also [click](#method-click) and [rightClick](#method-rightClick).

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->doubleClick();
             
         
<a name="method-dragTo"></a>
#### `dragTo()` {.method}
     
Drags current node onto other node.

    $page = $this->session->getPage();
    $dragged = $page->find(...);
    $target = $page->find(...);
    $dragged->dragTo($target);
              
              
<a name="method-evaluateScript"></a>
#### `evaluateScript()` {.method}

Executes JS in browser and return it's response.

    $this->session->evaluateScript($script);
    

<a name="method-executeScript"></a>
#### `executeScript()` {.method}

Executes JS in browser.

    $this->session->executeScript($script);
    
    
<a name="method-fillField"></a>
#### `fillField()` {.method}
  
Fills in field (input, textarea, select) with specified locator (input id, name or label).

    $page = $this->session->getPage();  
    $page->fillField($locator, 'foo'); 
        

<a name="method-find"></a>
#### `find()` {.method}

Finds first element with specified selector inside the current element.

    $page = $this->session->getPage();
    $registerForm = $page->find('css', 'form.register');
    
The first argument of `find` is the kind of the selector. Following kinds of selectors are supported:

- css
    ~~~
    $title = $page->find('css', 'h1');
    
    $buttonIcon = $page->find('css', '.btn > .icon');
    ~~~
- xpath
    ~~~
    $anchorsWithoutUrl = $page->findAll('xpath', '//a[not(@href)]');
    ~~~
- named
    ~~~
    $topLink = $page->find('named', array('link', $escapedValue));
    ~~~

    For the named selector type, the second argument of the find() method is an array with 2 elements:
    The name of the query to use and the value to search with this query.
    
    The following queries are supported by the named selector:
    - id - Searches for an element by its id.
    - id_or_name - Searches for an element by its id or name.
    - link - Searches for a link by its id, title, img alt, rel or text.
    - button - Searches for a button by its name, id, text, img alt or title.
    - link_or_button - Searches for both links and buttons.
    - content - Searches for a specific page content (text).
    - field - Searches for a form field by its id, name, label or placeholder.
    - select - Searches for a select field by its id, name or label.
    - checkbox - Searches for a checkbox by its id, name, or label.
    - radio - Searches for a radio button by its id, name, or label.
    - file - Searches for a file input by its id, name, or label.
    - optgroup - Searches for an optgroup by its label.
    - option - Searches for an option by its content or value.
    - fieldset - Searches for a fieldset by its id or legend.
    - table - Searches for a table by its id or caption.


<a name="method-find"></a>
#### `findAll()` {.method}

Finds all element with specified selector inside the current element.

The first argument of `findAll` is the kind of the selector, as in [find](#method-find).

    $page = $this->session->getPage();
    $registerForm = $page->findAll('css', 'form.register');
    

<a name="method-findButton"></a>
#### `findButton()` {.method}

Looks for a button with the given text, title, id, name attribute or alt attribute (for images used inside links).

See also [hasButton](#method-hasButton). 

    $page = $this->session->getPage();
    $button = $page->findButton($locator);       

     
<a name="method-findById"></a>
#### `findById()` {.method}

Looks for a child element with the given id.


    $page = $this->session->getPage();
    $mainContent = $page->findById('main-content');     
     
     
<a name="method-findField"></a>
#### `findField()` {.method}

Looks for a field (input, textarea or select) with the given label, placeholder, id or name attribute.

See also [hasField](#method-hasField).

    $page = $this->session->getPage();
    $field = $registerForm->findField($locator);    
     

<a name="method-findLink"></a>
#### `findLink()` {.method}

Looks for a link with the given text, title, id or alt attribute (for images used inside links).

See also [hasLink](#method-hasLink). 

    $page = $this->session->getPage();
    $link = $page->findLink($locator);
    
    
<a name="method-hasSelect"></a>
#### `hasSelect()` {.method}

Checks whether element has a select field with specified locator (select id, name or label).

    $page = $this->session->getPage();
    $hasSelect = $page->hasSelect($locator);
     
    
<a name="method-hasTable"></a>
#### `hasTable()` {.method}

Checks whether element has a table with specified locator (table id or caption).

    $page = $this->session->getPage();
    $hasTable = $page->hasTable($locator);
     

<a name="method-forward"></a>
#### `forward()` {.method}

Moves forward 1 page in history.

    $this->session->forward();


<a name="method-focus"></a>
#### `focus()` {.method}
     
Brings focus to element.

See also [blur](#method-blur). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->focus(); 
    

<a name="method-getAttribute"></a>
#### `getAttribute()` {.method}
     
Gets the value of an attribute.

See also [hasAttribute](#method-hasAttribute).

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    if ($el->hasAttribute('href')) {
        echo $el->getAttribute('href');
    } else {
        echo 'This anchor is not a link. It does not have an href.';
    }
    
    
<a name="method-getCookie"></a>
#### `getCookie()` {.method}

Returns cookie by name.

    $this->session->getCookie($name);


<a name="method-getCurrentUrl"></a>
#### `getCurrentUrl()` {.method}
    
Returns current URL address.

    $this->session->getCurrentUrl();


<a name="method-getHtml"></a>
#### `getHtml()` {.method}
     
Gets the inner HTML of the element, i.e. all children of the element.

See also [getOuterHtml](#method-getOuterHtml) and [getText](#method-getText).

    $page = $this->session->getPage();
    $title = $page->find('xpath', '//title');
    if ($title !== null) {
        $title = $title->getHtml();
    }


<a name="method-getOuterHtml"></a>
#### `getOuterHtml()` {.method}
     
Gets the outer HTML of the element, i.e. including the element itself.

See also [getHtml](#method-getHtml) and [getText](#method-getText).

    $page = $this->session->getPage();
    $title = $page->find('xpath', '//title');
    if ($title !== null) {
        $title = $title->getOuterHtml();
    }
    

<a name="method-getPage"></a>
#### `getPage()` {.method}

Returns page element.

    $this->session->getPage();


<a name="method-getResponseHeader"></a>
#### `getResponseHeader()` {.method}

Returns specific response header.

    $this->session->getResponseHeader($name);
    

<a name="method-getResponseHeaders"></a>
#### `getResponseHeaders()` {.method}

Returns all response headers.

    $this->session->getResponseHeaders();


<a name="method-getScreenshot"></a>
#### `getScreenshot()` {.method}

Capture a screenshot of the current window.

The function returns the screenshot of MIME type image/* depending on driver (e.g., image/png, image/jpeg).

    $this->session->getScreenshot();


<a name="method-getStatusCode"></a>
#### `getStatusCode()` {.method}

Returns response status code.

    $this->session->getStatusCode();


<a name="method-getTagName"></a>
#### `getTagName()` {.method}
     
This method allows you to get the tag name of the element. This tag name is always returned lowercased.

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $tagName = $el->getTagName();

    
<a name="method-getText"></a>
#### `getText()` {.method}
     
Returns element text (inside tag).

See also [getHtml](#method-getHtml) and [getOuterHtml](#method-getOuterHtml).

    $page = $this->session->getPage();
    $title = $page->find('xpath', '//title');
    if ($title !== null) {
        $title = $title->getText();
    }
    
    
<a name="method-getWindowName"></a>
#### `getWindowName()` {.method}

Return the name of the currently active window.
     
    $this->session->getWindowName();


<a name="method-getWindowNames"></a>
#### `getWindowNames()` {.method}

Return the names of all open windows.

    $this->session->getWindowNames();


<a name="method-getValue"></a>
#### `getValue()` {.method}
     
Gets the value of the element. 

See also [setValue](#method-setValue). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $value = $el->getValue();


<a name="method-has"></a>
#### `has()` {.method}
     
Checks whether a child element matches the given selector but without returning it.     
The first argument of `findAll` is the kind of the selector, as in [find](#method-find).

    $page = $this->session->getPage();
    $registerForm = $page->has('css', 'form.register');
    
    
<a name="method-hasAttribute"></a>
#### `hasAttribute()` {.method}
     
Checks whether the element has a given attribute.

See also [getAttribute](#method-getAttribute), [hasClass](#method-hasClass).

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    if ($el->hasAttribute('href')) {
        echo $el->getAttribute('href');
    } else {
        echo 'This anchor is not a link. It does not have an href.';
    }    
    
    
<a name="method-hasButton"></a>
#### `hasButton()` {.method}
     
Checks whether element has a button (input[type=submit|image|button|reset], button) with specified locator (button id, value or alt).

See also [findButton](#method-findButton).

    $page = $this->session->getPage(); 
    $hasButton = $page->hasButton($locator);
        
        
<a name="method-hasCheckedField"></a>
#### `hasCheckedField()` {.method}
     
Checks whether element has a checkbox with specified locator (input id, name or label), which is checked.

See also [hasUncheckedField](#method-hasUncheckedField), [checkField](#method-checkField) and [isChecked](#method-isChecked). 

    $page = $this->session->getPage();
    $hasCheckedField = $page->hasCheckedField($locator);    


<a name="method-hasClass"></a>
#### `hasClass()` {.method}
     
Checks whether the element has the given class (convenience wrapper around getAttribute('class')).

See also [hasAttribute](#method-hasAttribute).

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $hasButton = $el->hasClass('button');


<a name="method-hasField"></a>
#### `hasField()` {.method}
     
Checks whether element has a field (input, textarea, select) with specified locator (input id, name or label).

See also [findField](#method-findField).

    $page = $this->session->getPage(); 
    $hasField = $page->hasField($locator);
    
    
<a name="method-hasLink"></a>
#### `hasLink()` {.method}
     
Checks whether element has a link with specified locator (link id, title, text or image alt).

See also [findLink](#method-findLink).

    $page = $this->session->getPage(); 
    $hasLink = $page->hasLink($locator);
    
   
<a name="method-hasUncheckedField"></a>
#### `hasUncheckedField()` {.method}
    
Checks whether element has a checkbox with specified locator (input id, name or label), which is unchecked.
See also [hasCheckedField](#method-hasCheckedField), [uncheckField](#method-uncheckField) and [isChecked](#method-isChecked) 

    $page = $this->session->getPage();
    $hasUncheckedField = $form->hasUncheckedField($locator); 


<a name="method-isChecked"></a>
#### `isChecked()` {.method}
     
Checks whether the checkbox or radio button is checked.

See also [check](#method-check) and [uncheck](#method-uncheck). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $isChecked = $el->isChecked();
    
    
<a name="method-isSelected"></a>
#### `isSelected()` {.method}
     
Checks whether the &lt;option&gt; element is selected.

See also [isVisible](#method-isVisible), [isChecked](#method-isChecked) and [getValue](#method-getValue). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $isSelected = $el->isSelected();                
        
        
<a name="method-keyDown"></a>
#### `keyDown()` {.method}
     
Pressed down specific keyboard key.
The first argument could be either char ('b') or char-code (98).
The second argument is a keyboard modifier (could be 'ctrl', 'alt', 'shift' or 'meta').

See also [keyUp](#method-keyUp) and [keyPress](#method-keyPress). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->keyDown('b', 'ctrl');
    
    
<a name="method-keyPress"></a>
#### `keyPress()` {.method}
     
Presses specific keyboard key.
The first argument could be either char ('b') or char-code (98).
The second argument is a keyboard modifier (could be 'ctrl', 'alt', 'shift' or 'meta').

See also [keyUp](#method-keyUp) and [keyDown](#method-keyDown). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->keyPress('b', 'ctrl');    
        
        
<a name="method-keyUp"></a>
#### `keyUp()` {.method}
     
Pressed up specific keyboard key.
The first argument could be either char ('b') or char-code (98).
The second argument is a keyboard modifier (could be 'ctrl', 'alt', 'shift' or 'meta').

See also [keyDown](#method-keyDown) and [keyPress](#method-keyPress). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->keyUp('b', 'ctrl');   
          
          
<a name="method-mouseOver"></a>
#### `mouseOver()` {.method}
     
Moves the mouse over the element.

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->mouseOver();         
        
        
<a name="method-maximizeWindow"></a>
#### `maximizeWindow()` {.method}

Maximize the window if it is not maximized already.

    $this->session->maximizeWindow($name)


<a name="method-press"></a>
#### `press()` {.method}
     
This method let you press the buttons on the page.

See also [pressButton](#method-pressButton) and [click](#method-click).

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->press();
    
    
<a name="method-pressButton"></a>
#### `pressButton()` {.method}
     
Presses button (input[type=submit|image|button|reset], button) with specified locator (button id, value or alt).

See also [press](#method-press).

    $page = $this->session->getPage();    
    $page->pressButton($locator);
        
        
<a name="method-reload"></a>
#### `reload()` {.method}

Reloads current session page.

    $this->session->reload();


<a name="method-resizeWindow"></a>
#### `resizeWindow()` {.method}

Set the dimensions of the window.

    $this->session->resizeWindow($width, $height, $name);
    
         
<a name="method-rightClick"></a>
#### `rightClick()` {.method}
     
Performs a right click on the element.

See also [click](#method-click) and [doubleClick](#method-doubleClick).

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->rightClick();
    
                  
<a name="method-mouseOver"></a>
#### `mouseOver()` {.method}
     
Moves the mouse over the element.

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->mouseOver();  
    
    
<a name="method-selectFieldOption"></a>
#### `selectFieldOption()` {.method}
     
Selects option from select field with specified locator (input id, name or label).

    $page = $this->session->getPage(); 
    $page->selectFieldOption($locator, $value, $multiple);   
     
    
<a name="method-selectOption"></a>
#### `selectOption()` {.method}
     
Selects an option in a select box or in a radio group.

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->selectOption('foo');
    
    
<a name="method-setBasicAuth"></a>
#### `setBasicAuth()` {.method}

Sets HTTP Basic authentication parameters.

    $this->session->setBasicAuth($user, $password);


<a name="method-setCookie"></a>
#### `setCookie()` {.method}

Sets cookie.

    $this->session->setCookie($name, $value);


<a name="method-setRequestHeader"></a>
#### `setRequestHeader()` {.method}

Sets specific request header.

    $this->session->setRequestHeader($name, $value);
    
    
<a name="method-setValue"></a>
#### `setValue()` {.method}
     
Gets the value of the element. 

See also [getValue](#method-getValue). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $value = $el->setValue('foo'); 
        
     
<a name="method-submit"></a>
#### `submit()` {.method}
     
Submits the form.

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->submit();
          
          
<a name="method-switchToIFrame"></a>
#### `switchToIFrame()` {.method}

Switches to specific iFrame.

    $this->session->switchToIFrame($name);
          
          
<a name="method-switchToWindow"></a>
#### `switchToWindow()` {.method}

Switches to specific browser window.

    public function switchToWindow($name);
    

<a name="method-visit"></a>
#### `visit()` {.method}

Visit specified URL:

    $this->session->visit('http://my_project.dev/some_page.php');
     

<a name="method-uncheck"></a>
#### `uncheck()` {.method}
     
Unchecks a checkbox field.

See also [check](#method-check) and [isChecked](#method-isChecked). 

    $page = $this->session->getPage();
    $el = $page->find('css', '.something');    
    $el->uncheck();
     
      
<a name="method-uncheckField"></a>
#### `uncheckField()` {.method}
     
Unchecks checkbox with specified locator (input id, name or label).

See also [checkField](#method-checkField) and [hasUncheckedField](#method-hasUncheckedField). 

    $page = $this->session->getPage();
    $page->uncheckField($locator);     
    

<a name="method-wait"></a>
#### `wait()` {.method}

Waits some time or until JS condition turns true.

    $this->session->wait($time, $condition);      
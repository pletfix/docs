# HTTP Requests

[Since 0.5.0]

- [Introduction](#introduction)
- [Accessing the HTTP Request](#accessing)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

The Request object is the current context for the HTTP Request.

<a name="accessing"></a>
## Accessing the HTTP Request

You can get an instance of the HTTP Request from the Dependency Injector:

    /** @var \Core\Services\Contracts\Request $request */
    $request = DI::getInstance()->get('request');
    $name = $request->input('name);
    
You can also use the global `request()` function to get the HTTP Request, it is more comfortable:
       
    $name = request()->input('name');


<a name="available-methods"></a>
## Available Methods

The Request object has these methods:

<div class="method-list" markdown="1">

[baseUrl](#method-base-url)
[body](#method-body)
[cookie](#method-cookie)
[file](#method-file)
[fullUrl](#method-full-url)
[input](#method-input)
[ip](#method-ip)
[isAjax](#method-is-ajax)
[isJson](#method-is-json)
[isSecure](#method-is-secure)
[method](#method-method)
[path](#method-path)
[segment](#method-segment)
[url](#method-url)
[wantsJson](#method-wants-json)
</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-base-url"></a>
#### `baseUrl()` {.method .first-method}

> This method based on the post ["Get the full URL in PHP"](http://stackoverflow.com/questions/6768793/get-the-full-url-in-php) at stackoverflow.    

The `baseUrl` gets the root URL for the application:

    echo request()->baseUrl();

    // https://www.example.com
    
> Notes:
> - This function does not include username:password from a full URL or the fragment (hash).
> - The host is lowercase as per RFC 952/2181.
> - It will not show the default port 80 for HTTP and port 443 for HTTPS.    

Im [Pletfix Application Skeleton](https://github.com/pletfix/app) wird die Base-URL über ein Meta-Tag bereitgestellt, 
da Sie auch clientseitig nützlich sein kann: 
  
    <meta name="base-url" content="{{ request()->baseUrl() }}"/>

Per JavaScript kann die Base-URL nun leicht ausgelesen werden:

    window.baseUrl = $('meta[name="base-url"]').attr('content').replace(/\/$/, '') + '/';

See also [fullUrl](#method-full-url) and [url](#method-url).


<a name="method-body"></a>
#### `body()` {.method}

The `body` method gets the raw HTTP request body of the request:

    echo request()->body();
    

<a name="method-cookie"></a>
#### `cookie()` {.method}

The `cookie` method retrieves a cookie from the request:

    echo request()->cookie($key, $default);
    

<a name="method-file"></a>
#### `file()` {.method}

The `file` method gets an uploaded file which has been sent via HTML form.  

The [http://php.net/manual/en/features.file-upload.post-method.php](official PHP page) shows how you can build a
File Upload Form:
    
    <form enctype="multipart/form-data" action="{{url('upload')}}" method="POST">
        <input name="_token" value="{{csrf_token()}}" type="hidden"/>
        <input type="hidden" name="MAX_FILE_SIZE" value="30000"/>
        File: <input name="userfile" type="file"/>
        <input type="submit" value="Send File"/>
    </form>

Note, that the data encoding type must be specified as "multipart/form-data". Furthermore, the MAX_FILE_SIZE, if used, 
must precede the file input field. 

If the the file was uploades via the form like above, you can get the file information like this:
 
    $uploadedFile = request()->file('userfile');
    
The `file` method returns an `UploadedFile` instance. If the passed key does not exist, null is returned. 
    
`UploadedFile` provides the following methods to get information about the uploaded file:

    $uploadedFile->originalName();      // Get the original name of the uploaded file.
    $uploadedFile->size();              // Get the file size in bytes. Returns false, if the file was not uploaded 
                                        // successfully.
    $uploadedFile->modificationTime();  // Get the modification time of the uploaded file. Returns false, if the file 
                                        // was not uploaded successfully.
    $uploadedFile->mimeType();          // Get the MIME type of the uploaded file. Returns false, if the file was not 
                                        // uploaded successfully or the MIME type is unknown.
    $uploadedFile->guessExtension();    // Guess the file extension based on the mime type. Returns false, if the file 
                                        // was not uploaded successfully or the MIME type is unknown.
    $uploadedFile->hash();              // Get the unique 32 character hash value of the file. Returns false, if the 
                                        // file was not uploaded successfully.
    $uploadedFile->errorCode();         // Get the error code, see http://php.net/manual/en/features.file-upload.errors.php
                                        // for description.
    $uploadedFile->errorMessage();      // Get the error message.
    $uploadedFile->isValid();           // Determine if the file was uploaded successfully via HTTP POST and is ready to 
                                        // move. The method returns false if the file has already been moved from the  
                                        // temporary directory.

The uploaded file is stored in a temporary directory first of all. Use the `move` method of `UploadedFile` to move this 
file to your target folder. The method returns the new file path:

    $fileName = request()->file('image')->move($targetFolder);
    
You may set a file name as the second parameter if you don't like to save the file under the original file name: 

    $fileName = request()->file('image')->move($targetFolder, 'logo.png'); 

An `UploadException` is thrown by the `move`method, if the file is not valid or if, for any reason, the file could not 
have been saved.

#### Nested Input

The input may also using array notation for the name like this:

    <input type="file" name="my-form[details][avatar]"/>

In this case you can get the file information with the "dot" notation:
 
    $uploadedFile = request()->file('my-form.details.avatar');

#### Multiple File Upload
    
The input may also specify an array of files:    
    
    <input type="file" name="articles[]"/>
    <input type="file" name="articles[]"/>

In this case, if multiple files have been uploaded under the same key, the `file` method gets an array of `UploadedFile` 
instances: 
                     
    foreach (request()->file('articles') as $uploadedFile) {
        $uploadedFile->move($targetFolder);
    }
 

<a name="method-full-url"></a>
#### `fullUrl()` {.method}

The `fullUrl` method gets the full [Uniform Resource Identifier](https://en.wikipedia.org/wiki/Uniform_Resource_Identifier) for the request:

    echo request()->fullUrl();

    // https://www.example.com/path?a=4
  
> Notes:
> - This function does not include username:password from a full URL or the fragment (hash).
> - The host is lowercase as per RFC 952/2181.
> - It will not show the default port 80 for HTTP and port 443 for HTTPS.
> - The #fragment_id is not sent to the server by the client (browser) and will not be added to the full URL.    

See also [baseUrl](#method-full-url) and [url](#method-url).


<a name="method-input"></a>
#### `input()` {.method}

The `input` method retrieves an input item from the request ($_GET and $_POST).:

    echo request()->input($key, $default);
    

<a name="method-ip"></a>
#### `ip()` {.method}

The `ip` method returns the client IP address:

    echo request()->ip();

    
<a name="method-is-ajax"></a>
#### `isAjax()` {.method}

The `isAjax` method determines if the request is the result of an AJAX call:

    echo request()->isAjax();

It works if your JavaScript library sets an X-Requested-With HTTP header. It is known to work with common
[JavaScript frameworks](http://en.wikipedia.org/wiki/List_of_Ajax_frameworks#JavaScript).


<a name="method-is-json"></a>
#### `isJson()` {.method}

The `isJson` method determines if the request is sending JSON:

    echo request()->isJson();
    
See also [wantsJson](#method-wants-json)


<a name="method-is-secure"></a>
#### `isSecure()` {.method}

The `isSecure` method checks whether the request is secure or not:

    echo request()->isSecure();
    

<a name="method-method"></a>
#### `method()` {.method}

> This method based on getMethod() at [Symfony's Request Object](https://github.com/symfony/http-foundation/blob/3.2/Request.php).

The `method` method gets the request method:

    echo request()->method();

    
The method is always an uppercase string: GET, HEAD, POST, PUT, PATCH or DELETE

If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method.

     
<a name="method-path"></a>
#### `path()` {.method}

The `path` method gets the path for the request without query string:

    // Example: fullUrl = "https://www.example.com/test?a=4"
    
    echo request()->path();

    // test
    
    
<a name="method-segment"></a>
#### `segment()` {.method}

The `segment` method gets a segment from the path (zero based index).

    // Example: path = "foo/bar/baz"
    
    echo request()->segment(1);

    // bar
    
    
<a name="method-url"></a>
#### `url()` {.method}

The `url` method gets the the URL for the request without query string:

    echo request()->url();

    // https://www.example.com/path
  
See also [baseUrl](#method-base-url) and [fullUrl](#method-full-url).

    
<a name="method-wants-json"></a>
#### `wantsJson()` {.method}

The `wantsJson` method determines if the current request is asking for JSON in return:

    echo request()->wantsJson();
    
See also [isJson](#method-is-json)

# HTTP Client

- [Introduction](#introduction)
- [Configuration](#configuration)
    - [Base URL and Port](#base-url)
    - [HTTP Authorization](#auth)
    - [Bearer Token](#bearer)
    - [HTTP Proxy](#proxy)
- [Create a Client](#instance)
- [Send a Request](#send)
    - [Response Info](#info)
    - [Error](#error)
- [File Upload](#file)
- [Cookies](#cookies)

<a name="introduction"></a>
## Introduction

Pletfix HTTPClient is a HTTP client by using the [cURL Library](http://php.net/manual/en/book.curl.php).
That makes it easy to send HTTP requests and trivial to integrate with web services. 

<a name="configuration"></a>
## Configuration

<a name="base-url"></a>
### Base URL and Port

You can specify a baseUrl.
     
    $client->baseUrl($url);
 
You can also specify a port which is to used to:
    
    $client->port($port);

<a name="auth"></a>
### HTTP Authentication

Use the `auth` method to set username and password for the HTTP connection:

    $client->auth($username, $password);

By default this function uses the basic authentication. You can change the authentication method by pass a third argument:

    $client->auth($username, $password, CURLAUTH_DIGEST);

Possible authentication methods are `CURLAUTH_BASIC`, `CURLAUTH_DIGEST`, `CURLAUTH_GSSNEGOTIATE`, `CURLAUTH_NTLM`, 
`CURLAUTH_ANY` and/or `CURLAUTH_ANYSAFE`. The bitwise `|` operator can be used to combine more than one method.

<a name="bearer"></a>
### Bearer Token

You may set the Bearer Token like this:

    $client->bearerToken($token);
    
<a name="proxie"></a>
### HTTP Proxie

You can specify a HTTP proxy to tunnel requests through:

    $client->proxy($address, $username, $password, $authMethod, $type);
    
You may set the address like "addr:port". 

Username and password are optional. The `$authMethod` argument is `CURLAUTH_BASIC` (default) and/or `CURLAUTH_NTLM`. 
The bitwise `|` operator can be used to combine more than one method. 

The optional `$type` argument could be either `CURLPROXY_HTTP`, `CURLPROXY_SOCKS4`, `CURLPROXY_SOCKS5`, `CURLPROXY_SOCKS4A`
or `CURLPROXY_SOCKS5_HOSTNAME`.

> <i class="fa fa-info fa-2x" aria-hidden="true"></i>
> If this method is not used, the environment variable `HTTPS_PROXY` and `HTTP_PROXY` is read to determine the HTTP 
> proxy address automatically.

<a name="options"></a>
### Additional Options

    /**
     * Set the User-Agent.
     *
     * The user agent identifies the application type, operating system, software vendor or software version.
     *
     * @param string $userAgent
     * @return $this
     */
    public function userAgent($userAgent);
    
    /**
     * Add a header to the response.
     *
     * @param string|array $key Header key or array of key and values
     * @param string $value Header value
     * @return $this
     */
    public function header($key, $value = null);

    /**
     * Enable SSL verify.
     *
     * @param bool $enable
     * @return $this
     */
    public function sslVerify($enable = true);

    /**
     * Encode request data to JSON.
     *
     * @param bool $enable
     * @return $this
     */
    public function jsonEncode($enable = true);

    /**
     * Accept json as response.
     *
     * @param bool $enable
     * @return $this
     */
    public function acceptJson($enable = true);

<a name="instance"></a>
## Create a Client

You may use the `http_client()` function to access a HTTPClient instance:

    $client = http_client();
    
> The `http_client()` function is just a shortcut to get the `HttpClient` instance supported by [Dependency Injector](di): 
>    
>       $client = DI::getInstance()->get('http-client');

<a name="send"></a>
## Send a Request
	
The client provides the typical HTTP methods to send a request to a REST service:
	
    $result = $client->get($url, $params);
    $result = $client->head($url, $params);
    $result = $client->post($url, $data);
    $result = $client->put($url, $data);
    $result = $client->patch($url, $data);
    $result = $client->delete($url, $data);
    $result = $client->options($url, $data);

The first argument is the full Address of the HTTP Server where the request is sent to. The second argument is the data 
which is append to the message. The functions returns the response of the webservice.

By the way, you may also use the `send` method, which the HTTP method ("GET", "HEAD", "POST", "PUT", "PATCH", 
"DELETE", "OPTIONS") is passed as argument: 

    $result = $client->send($method, $url, $data);
    
<a name="info"></a>
### Response Info

After the request you may get the HTTP status code like below:

    $httpCode = client()->getStatusCode();

Furthermore, you may get more details about the request like this: 
    
    $info client()->getInfo();
    
[PHP manual](http://php.net/manual/en/function.curl-getinfo.php) describes what information there is.

<a name="Error"></a>
### Error

If the request fails, an Exception is raised.

You can also get the last error like this:

    $error = $client->getLastError();

<a name="file"></a>
## File Upload

    /**
     * Set a file to upload.
     *
     * Note that files are only sent using the POST method.
     *
     * @param string $filename Name of the file to be uploaded.
     * @param string|null $mimetype MIME type of the file (automatically detected if omitted)
     * @param string|null $postname The name of the file in the upload data (basename of filename if omitted).
     * @return $this
     */
    public function file($filename, $mimetype = null, $postname = null);

<a name="cookies"></a>
## Cookies

    /**
     * Set cookies to be used in the HTTP request.
     *
     * @param array|string $cookies Cookies as array (key/value pair) or string (e.g. "fruit=apple; colour=red").
     * @return $this
     */
    public function cookies($cookies);
    
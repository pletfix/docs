# Pagination

_Generate the HTML for paginating your tables_

[Since 0.7.2]

- [Introduction](#introduction)
- [Basic Usage](#usage)
    - [Limit the Source](#limit)
    - [Render the Paginator](#view)
- [Available Methods](#available-methods)

<a name="introduction"></a>
## Introduction

With Pletfix's paginator, you can simply paginate database tables and other lists.

![Paginator - Slider at the left site](https://raw.githubusercontent.com/pletfix/docs/master/images/paginator_left.png)
![Paginator - Slider in the middle](https://raw.githubusercontent.com/pletfix/docs/master/images/paginator_middle.png)
![Paginator - Slider at the right site](https://raw.githubusercontent.com/pletfix/docs/master/images/paginator_right.png)


<a name="usage"></a>
## Basic Usage

You may use the `paginator` function to create a new `Paginator` instance:

    $paginator = paginator($total, $limit);

The first argument passed to the paginate method is the total number of items. 
The second argument specified the maximum of items you would like displayed "per page".
You may also set the current page as third argument, but, of course, this value is automatically detected.

<a name="limit"></a>
### Limit the Source

The following example illustrates a typical use case with a Query Builder into a controller action method:

    public function index()
    {
        $builder   = User::builder();
        $paginator = paginator($builder->count(), 10);
        $users     = $builder
                        ->offset($paginator->offset())
                        ->limit($paginator->limit())
                        ->all();
        
        return view('users.index', compact('paginator', 'users'));
    }

In this example we have specify that we would like to display 10 user accounts per page. The view 'users.index' 
have to include a [partial view](#view) to render the paginator control, for example:
 
    @extends('app')
    
    @section('content')
        <h2>Users</h2>
        
        <div class="table-responsive">
            <!-- show table data -->
        </div>
    
        @include('_pagination')
    @endsection

<a name="view"></a>
### Render the Paginator

The [Pletfix Application Skeleton](https://github.com/pletfix/app) has already placed the partial view 
`_pagination.blade.php` in the view directory to rendering the pagination control. The partial view is compatible with 
the [Bootstrap CSS framework](https://getbootstrap.com). Feel free to customize this as you wish.

    @if ($paginator->hasMultiplePages())
        <ul class="pagination">
            @if ($url = $paginator->previousUrl())
                <li><a href="{{$url}}" title="previous"><span>&laquo;</span></a></li>
            @else
                <li class="disabled"><span>&laquo;</span></li>
            @endif
            @foreach ($paginator->pages() as $page)
                @if($page == '...')
                    <li class="disabled"><span>...</span></li>
                @elseif ($page == $paginator->currentPage())
                    <li class="active"><span>{{$page}}</span></li>
                @else
                    <li><a href="{{$paginator->url($page)}}">{{$page}}</a></li>
                @endif
            @endforeach
            @if ($url = $paginator->nextUrl())
                <li><a href="{{$url}}" title="next"><span>&raquo;</span></a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    @endif

As shown above, you may include this partial in your view with the [@include](blade#including) directive: 

    @include('_pagination')

Of course, if the paginator is not stored in the `$paginator` variable, you have to passed this one as the second argument:

    @include('_pagination', ['paginator' => $myPaginator])
    
    
<a name="available-methods"></a>
## Available Methods

<div class="method-list" markdown="1">

[currentPage](#method-currentPage)
[getFragment](#method-getFragment)
[getPageKey](#method-getPageKey)
[getParameters](#method-getParameters)
[hasMultiplePages](#method-hasMultiplePages)
[lastPage](#method-lastPage)
[limit](#method-limit)
[nextUrl](#method-nextUrl)
[offset](#method-offset)
[pages](#method-pages)
[previousUrl](#method-previousUrl)
[setFragment](#method-setFragment)
[setPageKey](#method-setPageKey)
[setParameters](#method-setParameters)
[total](#method-total)
[url](#method-url)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-currentPage"></a>
#### `currentPage()` {.method .first-method}

The `currentPage` method gets the current page. 

    $currentPage = $paginator->currentPage();


<a name="method-getFragment"></a>
#### `getFragment()` {.method}

The `getFragment` method gets the URL fragment. 

    $fragment = $paginator->getFragment();


<a name="method-getPageKey"></a>
#### `getPageKey()` {.method}

The `getPageKey` method gets the query string variable used to store the page. 

    $key = $paginator->getPageKey();
    
    
<a name="method-getParameters"></a>
#### `getParameters()` {.method}

The `getParameters` method gets the query parameters.

    $params = $paginator->getParameters();    
    
    
<a name="method-hasMultiplePages"></a>
#### `hasMultiplePages()` {.method}

The `hasMultiplePages` method determines if there are enough items to split into multiple pages.

    $canPaginate = $paginator->hasMultiplePages();  


<a name="method-lastPage"></a>
#### `lastPage()` {.method}

The `lastPage` method gets the last page.

    $canPaginate = $paginator->lastPage();  


<a name="method-limit"></a>
#### `limit()` {.method}

The `limit` method gets the maximal number of items per page.

    $limit = $paginator->limit();  


<a name="method-nextUrl"></a>
#### `nextUrl()` {.method}

The `nextUrl` method gets the URL for the next page.

    $canPaginate = $paginator->nextUrl();  


<a name="method-offset"></a>
#### `offset()` {.method}

The `offset` method gets the offset of items for the current page.

    $offset = $paginator->offset();  


<a name="method-pages"></a>
#### `pages()` {.method}

The `pages` method gets the pages.

    $pages = $paginator->pages(); // e.g. [1, 2, '...', 5, 6, 7, 8, 9, 10, 11, '...', 14, 15]


<a name="method-previousUrl"></a>
#### `previousUrl()` {.method}

The `previousUrl` method gets the URL for the previous page.

    $prevUrl = $paginator->previousUrl();  


<a name="method-setFragment"></a>
#### `setFragment()` {.method}

The `setFragment` method sets a URL fragment to add to all URLs.

    $paginator->setFragment('foo');  


<a name="method-setPageKey"></a>
#### `setPageKey()` {.method}

The `setPageKey` method sets the query string variable used to store the page.

    $paginator->setPageKey('page');  


<a name="method-setParameters"></a>
#### `setParameters()` {.method}

The `setParameters` method sets a query parameters to add to all URLs.

    $paginator->setParameters(['foo' => 'bar']);  
    

<a name="method-total"></a>
#### `total()` {.method}

The `total` method gets the total number of items.

    $total = $paginator->total();  
    
    
<a name="method-url"></a>
#### `url()` {.method}

The `url` method gets the URL for a given page number.

    §url = $paginator->url(3);  

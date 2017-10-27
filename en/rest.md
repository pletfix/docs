# REST Service

_A base controller for RESTful API's_

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.9.2

- [Introduction](#introduction)
- [RESTful Server](#server)
- [RESTful Client](#client)

<a name="introduction"></a>
## Introduction

TODO...

<a name="server"></a>
## RESTful Server

TODO...

#### Actions Handled By Resource Controller

Verb      | URI                    | Action       | Route Name
----------|------------------------|--------------|---------------------
GET       | `/photos`              | index        | photos.index
GET       | `/photos/create`       | create       | photos.create
POST      | `/photos`              | store        | photos.store
GET       | `/photos/{photo}`      | show         | photos.show
GET       | `/photos/{photo}/edit` | edit         | photos.edit
PUT/PATCH | `/photos/{photo}`      | update       | photos.update
DELETE    | `/photos/{photo}`      | destroy      | photos.destroy

TODO:
Sinnvolle Status Codes 

Verweis auf [Routing](routing#http-method) und
[Resource Controllers](controllers#resource)

<a name="client"></a>
## RESTful Client

TODO...

Verweis auf [HTTP Client](httpclient)


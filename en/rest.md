# REST Service

_A base controller for RESTful API's_

[Since 0.5.0]

Planned release: 0.9.2

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

<a name="client"></a>
## RESTful Client

TODO...

Curl - Load external data using the Curl library


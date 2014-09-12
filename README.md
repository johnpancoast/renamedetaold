*this project is defunct as all hell*

deta
====
Deta is a form and pager builder for [Kohana](http://kohanaframework.org/). It includes ORM integration and a generic CRUD controller that you can extend which allows you to create a scaffold quickly but still allows you to override the functionality as necessary. Deta does not "render" content. Instead it prepares data to be used in a view. Meaning it's meant for something like [KOstache](https://github.com/zombor/KOstache).

At present, my implementation uses KOstache and twitter bootstrap but you can use whatever views/templates you'd like.

*The CRUD controller is presently dependent on [https://github.com/shideon/application-common](https://github.com/shideon/application-common) but you can decouple this easily.*

## License
This software is licensed under the MIT license. See LICENSE.

## Version 0.4.0.
This is version 0.4.0.

## Changelog
See CHANGELOG.md for details on what has changed in this and previous versions.

## Install
* Clone it to (or add as a submodule to) APPPATH/modules/deta.
* [Enable your module](http://kohanaframework.org/3.3/guide/kohana/modules#enabling-modules).

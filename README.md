# CodeIgniter 4 Backend Medihub

## Setup

Create new database and run this code.
```
composer config minimum-stability dev
composer config prefer-stable true
composer require codeigniter4/shield
php spark shield:setup
```

## cURL

```
Get
/api/invalid-access

Post
/api/register

Post
/api/login

Get
/api/logout
```
```
Post
/api/administrator/register
```
```
Post
/api/manajer/register

Get
/api/manajer/list

Delete
/api/manajer/delete/(:num)
```
```
Get
/api/supplier/profile

Get
/api/supplier/list

Get
/api/supplier/single/(:num)

Put
/api/supplier/accept/(:num)

Put
/api/supplier/update

Delete
/api/supplier/delete/(:num)
```
```
Post
/api/news/add

Get
/api/news/list

Get
/api/news/single/(:num)

Put
/api/news/update/(:num)

Delete
/api/news/delete/(:num)
```

## Access Control

> Administrator, Manajer, Supplier, Umum
```
/api/invalid-access
/api/register
/api/login
/api/logout
/api/news/list
```

> Administrator, Manajer
```
/api/supplier/list
/api/supplier/single/(:num)
```

> Administrator
```
/api/manajer/register
/api/manajer/list
/api/manajer/delete/(:num)
/api/supplier/accept/(:num)
/api/supplier/delete/(:num)
/api/news/add
/api/news/single/(:num)
/api/news/update/(:num)
/api/news/delete/(:num)
```

> Supplier
```
/api/supplier/profile
/api/supplier/update
```
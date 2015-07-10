# REST-API

A customizable Representational State Transfer (REST) Application Program Interface (API). 

## Features

* MySQL database preset
* Protection against MySQL injection
* Supports basic CRUD (Create Read Update Delete) operations
* Supports HTTP requests GET POST PUT and DELETE
* Can interact with anything that can send an HTTP request
* Interfacing with new tables is as simple as adding new models

## MySQL Schema

The sample code is based on the following MySQL table:

```
CREATE TABLE `person` (
  `id` mediumint(8) unsigned NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL
);
```

To insert sample data into this database:

```
INSERT INTO `person` (`id`, `Name`, `City`, `Email`) VALUES
(1, 'Clark Kent', 'Smallville', 'superman@justiceleague.com');
```


## Configuration

To configure this REST-API to work with your database follow these steps:

1. Modify `config.php` with the appropriate credentials. 
2. Create your own DTO (Data Transfer Object) and place it in the `models` directory. (see [models/person.php]( https://github.com/maxcarter/REST-API/blob/master/models/person.php) for a sample DTO) 


## Future Updates

* Live Demo
* HTTP request documentation
* Multiple table support
* More database presets

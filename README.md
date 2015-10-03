# REST-UP

A customizable Representational State Transfer (REST) Application Program Interface (API) designed to provide a quick set of tools for developers to quickly build their own API. 

**Note**: this repository is currently under construction.

## Features

* Supports basic CRUD (Create Read Update Delete) operations
* Supports HTTP requests GET POST PUT and DELETE
* Can interact with anything that can send an HTTP request
* Data is returned in JSON (JavaScript Object Notation) format
* MySQL database preset
* Protection against MySQL injection
* Interfacing with new tables is as simple as adding new models
* Customizable controllers to interface with other databases 

## Installation

[Composer](https://getcomposer.org/):

```
composer require maxcarter/REST-UP
```

OR simply extract all files to the desired location in your website directory.

### Test
Once installed you should be able to see the welcome text at: `http://YourDomain.com/PathToAPI`

Another way to test the API is to install the Chrome Extension [Postman](https://chrome.google.com/webstore/detail/postman/fhbjgbiflinjbdggehcddcbncdddomop) then open the app and send http requests to `http://YourDomain.com/PathToAPI`.

### Server Requirements

* PHP v5.6+
* MySQL v5.6+

### MySQL Schema

The sample code is based on the following MySQL table:

```
CREATE TABLE `person` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL
);
```

To insert sample data into this database:

```
INSERT INTO `person` (`Name`, `City`, `Email`) VALUES
('Clark Kent', 'Smallville', 'superman@justiceleague.com');
```


## Configuration

To configure this REST-API to work with your database follow these steps:

1. Modify `config.php` with the appropriate credentials. 
2. Create your own DTO (Data Transfer Object) and place it in the `models` directory. (see [models/person.php]( https://github.com/maxcarter/REST-API/blob/master/models/person.php) for a sample DTO) 


## Customize

This REST API can be customized to work with different databases. The default preset is MySQL, however, you can create your own database controller to interface with different databases and implement custom functionality.

To create a custom controller follow these steps:

1. Create a new PHP file to implement the *Controller* class (see [controllers/mysql.php](https://github.com/maxcarter/REST-API/blob/master/controllers/mysql.php) for an example)
2. Ensure your class implements the required CRUD functions.
3. Modify [config.php](https://github.com/maxcarter/REST-API/blob/master/config/config.php) to include your controller's file name and database credentials. 

### Required Functions
```
/**
 * Create a new entry
 * @param [object] - The entry to be inserted
 * @return [object] - JSON result of insertion
 */
postValue($data);

/**
 * Read all entries
 * @return [array] - An array of objects 
 */
getValues();

/**
 * Read a single entry
 * @param [int] - The unique id of the entry
 * @return [object] - The requested entry
 */
getValue($value);

/**
 * Update an entry
 * @param [object] - The entry to be updated
 * @return [object] - JSON result of update
 */
putValue($data);

/**
 * Delete a single entry
 * @param [int] - The unique id of the entry
 * @return [object] - JSON result of deletion
 */
deleteValue($value);

```

## Future Updates

* Live Demo
* HTTP request documentation
* Multiple table support
* More database presets

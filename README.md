[logo]: https://emailage.com/Content/Images/logo.svg "Emailage Logo"

![alt text][logo](https://www.emailage.com)

The EmailageTM API is organized around REST (Representational State Transfer). The API was built to help companies integrate with our highly efficient fraud risk and scoring system. By calling our API endpoints and simply passing us an email and/or IP Address, companies will be provided with real-time risk scoring assessments based around machine learning and proprietary algorithms that evolve with new fraud trends.

See our [Example script](example.php) for full code example.

Creating the Class

```php
	include 'Emailage.class.php';
	
	$account_sid = 'My Account SID';
	$authToken = 'My Auth Token';
	
	$Emailage = new Emailage($account_sid, $authToken);
```

###Changing Settings.

#####Option 1, on Class Creation

```php
	include 'Emailage.class.php';
	
	$account_sid = 'My Account SID';
	$authToken = 'My Auth Token';
	$sandbox = TRUE; // Do I connect to the Sandbox or FALSE for the live system
	$format = 'json'; // What format do I want returned ?  json or xml ?
	$signature_method = 'sha1'; // What Encrption Method do I want to use ? Alowed types ('sha1', 'sha256', 'sha384', 'sha512')
	$validate_response = TRUE; // Should the SDK Validate the response and throw an error if an error is found?
	$return_parsed_result = TRUE; // Do I want my results returned to me already formatted. I.E. Already turned into Simple XML Object or JSON Object ?
	
	$Emailage = new Emailage($account_sid, $authToken, $sandbox, $format, $signature_method, $validate_response, $return_parsed_result);
```

#####Option 2, after Class Creation

```php
	include 'Emailage.class.php';
	
	$account_sid = 'My Account SID';
	$authToken = 'My Auth Token';
	
	$Emailage = new Emailage($account_sid, $authToken);
	$Emailage->changeSetting('format', 'json');
	$Emailage->changeSetting('signature_method', 'sha256');
	$Emailage->changeSetting('validate_response', FALSE);
	$Emailage->changeSetting('return_parsed_results', FALSE);
```

###Validating By Email Address

```php
	$Emailage->validateEmail('example@example.com');
```

###Validating By IP

```php
	$Emailage->validateIP('127.0.0.1');
```

###Validating By Both Email and IP

```php
	$Emailage->validateBoth('example@example.com', '127.0.0.1');
```

###Adding a User Defined Record ID. This parameter can be used when you want to add an identifier for a query. The identifier will display in the result.

```php
	$Emailage->validateEmail('example@example.com', 1234);
	$Emailage->validateIP('127.0.0.1', 1235);
	$Emailage->validateBoth('example@example.com', '127.0.0.1', 1236);
```
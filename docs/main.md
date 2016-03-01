#Authentication

Security is very important to EmailageTM. All API requests must contain some mechanism for identifying the user and ensuring they are authorized to make the request. The EmailageTM API supports OAuth 1.0.
Developers seeking to implement our API must first register to receive an Account ID and Authorization Token. Your Authorization Token can be found by logging into the following Emailage Portal websites at:

Sandbox:
[https://sandbox.emailage.com/login]

Production:
[https://app.emailage.com/login]

After logging in, navigate to Settings -> API Key Info.

Using the Account SID and Auth Token to setup authorization for the API.

```php
include '../lib/include.inc.php'; // Loading Emailage
	
	$config = Array();
	$config['account_sid'] = 'MYACCOUNTSID';
	$config['auth_token'] = 'MYAUTHTOKEN';
	
	$results = \Emailage\validate::email('example@example.com');
```

# Configuration

This SDK has many configuration options to make your interaction with Emailage easier to manage and control.

```
All configuration variables are lower case and will be converted to lower case when stored for the SDK to use.
```

1. account_sid

   The Account SID that you get from your sandbox or live environment

2. auth_token

   The Auth Token that you get from your sandbox or live environment

3. format

   The Format the Results are returned to you in.  Allowed values are 'json' or 'xml'.  If a value not matching that is provided, it will be ignored and defaulted back to json.

4. sandbox

   Boolean (TRUE || FALSE) If it is TRUE, the SDK will send your calls to the Sandbox URL, if False will query the live system

5. log_level

   Takes a value of 1, 2 or 3.  
   3 will only log Major messages to the PHP error log file. (Default Value)
   2 will log Notices, like invalid format choices.
   1 Verbose,  This will log everything the system does to the error log in an easy to read process.

6. throw_errors

   Boolean (TRUE || FALSE) Will throw errors on Major Messages and on Errors returned from the Emailage API.  False will let your scripts deal with the responses.


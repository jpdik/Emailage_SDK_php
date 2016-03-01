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
	$config['account_SID'] = 'MYACCOUNTSID';
	$config['auth_token'] = 'MYAUTHTOKEN';
```
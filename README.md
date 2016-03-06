[logo]: https://emailage.com/Content/Images/logo.svg "Emailage Logo"

![alt text][logo](https://www.emailage.com)

The EmailageTM API is organized around REST (Representational State Transfer). The API was built to help companies integrate with our highly efficient fraud risk and scoring system. By calling our API endpoints and simply passing us an email and/or IP Address, companies will be provided with real-time risk scoring assessments based around machine learning and proprietary algorithms that evolve with new fraud trends.

See our [Example script](example.php) for full code example.

Creating the Class

```php
	include 'Emailage.class.php';
	
	$account_sid = 'My Account SID';
	$authToken = 'My Auth Token';
	$testEmail = 'example@example.com';
	
	$Emailage = new Emailage($account_sid, $authToken);
```
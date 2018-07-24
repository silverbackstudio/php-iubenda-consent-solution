# Iubenda Consent Solution PHP client library

## Installation

Install this package in Yii project root with [Composer](https://getcomposer.org/).

`composer require silverback/iubenda-consent-solution`

## Usage

### Create a new consent

```php

use Iubenda\ConsentSolution\Client;
use Iubenda\ConsentSolution\Consent;

$consentSolution = new ConsentSolution\Client( 'your-private-api-key' );
$consent = new ConsentSolution\Consent;

$user_id = 10;

$consent->setSubject( 
    [
        'id' => sha1( 'my_application_' . $user_id ), // you can omit this field
        'email' => 'user@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'full_name' => 'John Doe',
        'verified' => false
    ]
);

$consent->addLegalNotice( [ 'identifier' => 'privacy_policy' ] );            

$consent->addProof( [
    'content' => json_encode( [ 
        'first_name' => 'John', 
        'last_name' => 'Doe', 
        // other useful form fields
    ] ),
    'form' => '<form><input type="text" name="first_name">[...]</form>',
] );

$consent->preferences['privacy_policy'] = true;
$consent->preferences['third_party'] = false;
$consent->preferences['newsletter'] = true;

try {
    $saved_consent = $consentSolution->createConsent( $consent );
    echo "Successfully saved consent: " . $saved_consent->id;
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

```

## Testing

This class uses [PHPUnit](https://phpunit.de/) as test suite, to test the classes and functions follow this steps.

Copy the file `phpunit.xml.dist` in `phpunit.xml` in the library folder and define Api-Key and addresses inside it:

```xml
	<php>
        <const name="CONSENT_SOLUTION_API_KEY" value="foobar"/>			
        <const name="CONSENT_SOLUTION_TEST_CONSENT" value="foobar"/>			
        <const name="CONSENT_SOLUTION_TEST_SUBJECT" value="foobar"/>			        
        ...
	</php>
```

Launch a `composer update` to install all the dependencies and test suite.

Run the test with the following commands

```bash
./vendor/bin/phpunit  tests/  # all tests
./vendor/bin/phpunit  tests/ClientTest # single test
```

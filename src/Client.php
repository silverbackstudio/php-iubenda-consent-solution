<?php
/**
 * Iubenda Consent Class.
 *
 * @category   Iubenda
 * @package    ConsentSolution
 * @subpackage Consent
 * @author     Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license    BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @link       https://github.com/silverbackstudio/php-iubenda-consent-solution
 */

namespace Iubenda\ConsentSolution;

use GuzzleHttp;
use GuzzleHttp\Psr7\Request;
use Psr;

/**
 * Contacts is the class to manage contacts in Sendinblue CRM
 *
 * @category   Iubenda
 * @package    ConsentSolution
 * @subpackage Consent
 * @author     Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license    BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @version    Release: 1.0
 * @link       https://github.com/silverbackstudio/php-iubenda-consent-solution
 */
class Client
{
    /**
     * Iubenda Api Key 
     *
     * @var string
     */
    public $apikey;
    
    /**
     * PSR Loger
     *
     * @var Psr\Log\LoggerInterface
     */
    public $logger;    
    
    /**
     * The HTTP client user dot send requests
     *
     * @var GuzzleHttp\Client
     */       
    protected $http_client;
    
    
    /**
     * The Sendinblue contacts API client
     *
     * @var array
     */       
    public $headers = array(
        'content-type' => 'application/json'
    );
    
    const ENDPOINT_URL = 'https://consent.iubenda.com';

    /**
     * Checks that the API key has indeed been set.
     *
     * @param string            $apikey      The Iubenda Consent Solution 
     *                                       private Api Key
     * @param GuzzleHttp\Client $http_client An alternative HTTP client 
     * 
     * @throws Exception 
     * @return void
     */
    public function __construct( $apikey, $http_client = null )
    {
        
        $this->logger = new Psr\Log\NullLogger;     
        
        if (! $apikey || !is_string($apikey) ) {
            throw new \Exception('Invalid api key');
        }
        
        $this->apikey = $apikey;
        
        if (! $http_client instanceof GuzzleHttp\Client ) {
            $http_client = new GuzzleHttp\Client();
        }

        $this->http_client = $http_client;
        
    }
    
    /**
     * Get a saved Consent
     * 
     * @param string $consent_id The ID of the consent to retreive
     * 
     * @return Consent
     */    
    public function getConsent( $consent_id )
    {
        
        $request = new Request( 
            'GET', 
            self::ENDPOINT_URL . '/consent/' . $consent_id
        );

        $response = $this->request($request);

        return new Consent($response);
    }
    
    /**
     * Sends a request to add a new Consent
     * 
     * @param Consent $consent The consent object to save.
     * 
     * @return Consent The created consent completed with id and subject id.
     */    
    public function createConsent( $consent )
    {
        
        $request = new Request( 
            'POST',
            self::ENDPOINT_URL . '/consent/', 
            [ 'content-type' => 'application/json'  ], 
            json_encode($consent->toArray()) 
        );

        $response = $this->request($request);
        
        if (false === $response ) {
            return $response;
        }
        
        $consent->subject->id = $response['subject_id'];
        $consent->setTimestamp($response['timestamp']);
        $consent->id = $response['id'];
        
        return $consent;
    }  
    
    /**
     * Retrieve all inserted consents
     * 
     * @param array $params The query params to limit or filter the results
     * 
     * @return Consent[]
     */    
    public function listConsents( $params = array() )
    {
        
        $request = new Request( 
            'GET', 
            self::ENDPOINT_URL . '/consent/', 
            $params 
        );

        $consents = $this->request($request);
        
        foreach ( $consents as &$consent ) {
            $consent = new Consent($consent);
        }
        
        return $consents;
    }   
    
    /**
     * Get a saved Subject
     * 
     * @param string $subject_id The ID of the subject to retreive
     * 
     * @return Subject
     */      
    public function getSubject( $subject_id )
    {
        
        $request = new Request(
            'GET', 
            self::ENDPOINT_URL . '/subjects/' . $subject_id
        );

        $response = $this->request($request);

        return new Subject($response);
    }
    
    /**
     * Sends a request to add a new Subject
     * 
     * @param Subject $subject The subject object to save.
     * 
     * @return Subject The created subject completed with id.
     */    
    public function createSubject( $subject )
    {
        
        $request = new Request( 
            'POST', 
            self::ENDPOINT_URL . '/subjects/', 
            [ 'content-type' => 'application/json' ], 
            json_encode($subject->toArray())
        );
        
        
        $response = $this->request($request);
        
        if (false === $response ) {
            return $response;
        }
        
        $subject->configure($response);

        return $subject;
    } 
    
    /**
     * Update and existing Subject
     * 
     * @param Subject $subject The subject object to save.
     * 
     * @return Subject
     */ 
    public function updateSubject( $subject )
    {
        
        $request = new Request( 
            'PUT', 
            self::ENDPOINT_URL . '/subjects/' . $subject->id, 
            [ 'content-type' => 'application/json'  ], 
            json_encode($subject->toArray())
        );

        $response = $this->request($request);
        
        $subject->configure($response);
        
        return $subject;
    }          

    /**
     * Authenticate and sends the actual HTTP request. 
     * 
     * @param Request $request The PSR7 request object
     * 
     * @return array
     */   
    public function request( $request )
    {
        $request = $request->withHeader('ApiKey', $this->apikey);
        
        $result = $this->http_client->send($request);    
        
        return json_decode($result->getBody(), true);
    }   
    
} 
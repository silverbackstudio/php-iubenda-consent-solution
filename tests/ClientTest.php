<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iubenda\ConsentSolution;


final class ClientTest extends TestCase
{
    
    protected $client;

    protected function setUp()
    {
        $this->client = new ConsentSolution\Client( CONSENT_SOLUTION_API_KEY );
    }    
    
    public function testCanSetApiKey()
    {
        $this->assertEquals($this->client->apikey, CONSENT_SOLUTION_API_KEY);
    
        $this->expectException(\Exception::class);
        $fake_client = new ConsentSolution\Client('');
        
    }
    
    public function testCanListConsent()
    {
        $consents = $this->client->listConsents();
        
        $this->assertContainsOnly(ConsentSolution\Consent::class, $consents);
    
    }

    public function testCanGetConsent()
    {
        $response = $this->client->getConsent(CONSENT_SOLUTION_TEST_CONSENT);
        
        $this->assertInstanceOf(ConsentSolution\Consent::class, $response); 
    }    
    
    public function testCanCreateConsent()
    {
        $consent_data = json_decode(file_get_contents(__DIR__ . '/data/consent.json'), true);
        
        $consent = new ConsentSolution\Consent($consent_data);

        $response = $this->client->createConsent($consent);
        
        $this->assertInstanceOf(ConsentSolution\Consent::class, $response); 
    }    
    
    public function testCanGetSubject()
    {
        $subject_id = CONSENT_SOLUTION_TEST_SUBJECT;
        
        $response = $this->client->getSubject($subject_id);
        
        $this->assertInstanceOf(ConsentSolution\Subject::class, $response); 
        $this->assertEquals($subject_id, $response->id); 
    }   
    
    public function testCanCreateSubject()
    {
        $subject_data = json_decode(file_get_contents(__DIR__ . '/data/subject.json'), true);
        
        unset($subject_data['id']);
        
        $subject = new ConsentSolution\Subject($subject_data);
        
        $response = $this->client->createSubject($subject);
        
        $this->assertInstanceOf(ConsentSolution\Subject::class, $response); 
        $this->assertNotEmpty($response->id); 
    } 
    
    public function testCanUpdateSubject()
    {
        $subject_data = json_decode(file_get_contents(__DIR__ . '/data/subject.json'), true);
        
        $subject = new ConsentSolution\Subject($subject_data);
        
        $response = $this->client->updateSubject($subject);
        
        $this->assertInstanceOf(ConsentSolution\Subject::class, $response); 
        $this->assertNotEmpty($response->id); 
    }     
    
}
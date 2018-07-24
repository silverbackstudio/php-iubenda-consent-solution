<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iubenda\ConsentSolution\Client;
use Iubenda\ConsentSolution\Consent;
use Iubenda\ConsentSolution;

final class ConsentTest extends TestCase
{
    
    protected $consent;

    protected function setUp()
    {
        $this->consent = new Consent;
    }        
    
    public function testCanConfig()
    {
        
        $consent_data = json_decode(file_get_contents(__DIR__ . '/data/consent.json'), true);
        
        $consent = new Consent($consent_data);
        
        $this->assertEquals($consent_data,  $consent->toArray());        
        
        $this->assertInstanceOf(ConsentSolution\Subject::class,  $consent->subject);        
        $this->assertContainsOnly(ConsentSolution\Proof::class,  $consent->proofs);        
        $this->assertContainsOnly(ConsentSolution\LegalNotice::class, $consent->legal_notices);        
        
        $this->assertEquals($consent_data['subject'],  $consent->subject->toArray());
        $this->assertEquals($consent_data['proofs'][0],  $consent->proofs[0]->toArray());
        $this->assertEquals($consent_data['legal_notices'][0], $consent->legal_notices[0]->toArray());
        $this->assertEquals($consent_data['preferences'], $consent->preferences);

    }
    
    public function testCanSetTimestamp()
    {
        
        $date = new DateTime();
        $date->setTime(0, 0, 0, 0);
        
        $this->consent->setTimestamp($date->format(DateTime::ATOM));
        $this->assertAttributeEquals($date, 'timestamp', $this->consent);
        
        $this->consent->setTimestamp($date);
        $this->assertAttributeEquals($date, 'timestamp', $this->consent);        
    
    }
    
}
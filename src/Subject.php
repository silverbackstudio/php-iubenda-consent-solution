<?php
/**
 * Iubenda Consent Class.
 *
 * @category   Iubenda
 * @package    ConsentSolution
 * @subpackage Subject
 * @author     Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license    BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @link       https://github.com/silverbackstudio/php-iubenda-consent-solution
 */

namespace Iubenda\ConsentSolution;

use DateTime;

/**
 * Contacts is the class to manage contacts in Sendinblue CRM
 *
 * @category Iubenda
 * @package  ConsentSolution
 * @author   Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license  BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @version  Release: 1.0
 * @link     https://github.com/silverbackstudio/php-iubenda-consent-solution
 */
class Subject extends Object
{

    /**
     * The ID of the subject in Iubenda database;
     *
     * @var string
     */
    public $id;

    /**
     * The email fo the subject.
     *
     * @var string
     */
    public $email;

    /**
     * First name of the subject
     *
     * @var string
     */
    public $first_name;
    
    /**
     * Last name of the subject
     *
     * @var string
     */
    public $last_name;  
    
    /**
     * Proofs of this consent
     *
     * @var string
     */
    public $full_name;
    
    /**
     * Timestamo of creation of the subject
     *
     * @var DateTime
     */
    public $timestamp;    
    
    /**
     * If this consent has been verrified
     *
     * @var bool
     */
    public $verified;    
    
    /**
     * Preferences of this consent
     *
     * @var array
     */
    public $preferences;    
    
    /**
     * Class constructor
     * 
     * @param array $properties the properties to be set in this class instance
     * 
     * @return void
     */       
    public function configure( $properties = array() )
    {
      
        if (!empty($properties['timestamp']) ) {
            $this->setTimestamp($properties['timestamp']); 
            unset($properties['timestamp']);
        }
      
        parent::configure($properties); 
      
    }    
    
    /**
     * Set the specified timestamp in this Subject
     *
     * @param string|DateTime $timestamp The datetime to be set in this Subject
     * @param string          $format    Is datetime is a string, specify the 
     *                                   date format. Defaults to DateTime::ATOM
     * 
     * @return void
     */
    public function setTimestamp( $timestamp, $format = DateTime::ATOM )
    {
      
        if (! $timestamp instanceof DateTime ) {
            $timestamp = DateTime::createFromFormat($format, $timestamp);
        }
      
          $this->timestamp = $timestamp;  
    }    
    
    /**
     * Cast the object as array
     *
     * @return array
     */
    public function toArray()
    {
        
        $output = array( );

        if ($this->id  ) {
            $output['id']  = $this->id;
        }
        
        if ($this->email  ) {
            $output['email']  = $this->email;
        }    

        if ($this->first_name  ) {
            $output['first_name']  = $this->first_name;
        }   
    
        if ($this->last_name  ) {
            $output['last_name']  = $this->last_name;
        }    
        
        if ($this->full_name ) {
            $output['full_name']  = $this->full_name;
        }    
        
        if (null !== $this->verified ) {
            $output['verified']  = $this->verified;
        }    
        
        if ($this->preferences ) {
            $output['preferences']  = $this->preferences;
        }    
        
        if ($this->timestamp ) {
            $output['timestamp']  = $this->timestamp->format(DateTime::ATOM);
        }            
        
        return $output;
    }
    
} 
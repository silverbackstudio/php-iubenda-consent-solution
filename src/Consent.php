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

use DateTime;

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
class Consent extends ICSObject
{

    /**
     * The ID of the consent in Iubenda database;
     *
     * @var string
     */
    public $id;

    /**
     * Timestamp at which the consent occurred. Auto-filled if not provided.
     *
     * @var DateTime
     */
    public $timestamp = false;

    /**
     * Wrapper for the subject set of properties, which can be saved both via 
     * the Subject method and from within the Consent method. Check the 
     * Subject method for the properties supported within this set.
     *
     * @var Iubenda\ConsentSolution\Subject
     */
    public $subject;
    
    /**
     * Array of the legal notices to attach to the consent event, 
     * identified by their identifier and version. 
     *
     * @var Iubenda\ConsentSolution\LegalNotice[]
     */
    public $legal_notices = array();    
    
    /**
     * Array of the proofs to attach to the consent event. It’s normally used
     * to attach what the subject was prompted with (e.g. the form) and what the
     * subject has filled (e.g. the content of the form)
     *
     * @var Iubenda\ConsentSolution\Proof[]
     */
    public $proofs = array();   
    
    /**
     * Set of key-value pairs with preferences that you’re saving with the 
     * consent action. These preferences will also be updated for the subject 
     * and will be retrievable with the Subject method. It’s advisable to 
     * define a preferences naming and stick to it for all your calls. For 
     * instance, you could pass: 
     * general: true|false
     * newsletter: true|false
     * third_party: true|false
     * profiling: true|false
     * etc.
     *
     * @var array
     */
    public $preferences = array();   

    /**
     * The owner ID of this consent
     *
     * @var string
     */
    public $owner;       

    /**
     * The source of this consent, can be 'private' (HTTP) or 'public' (JS)
     *
     * @var string
     */
    public $source;       


    /**
     * Configures the specified content in the class
     * 
     * @param array $properties the properties to be set in this class instance
     * 
     * @return void
     */   
    public function configure( $properties = array() )
    {
      
        if (!empty($properties['subject']) ) {
            $this->setSubject($properties['subject']); 
            unset($properties['subject']);
        }

        if (!empty($properties['proofs']) ) {
            $this->setProofs($properties['proofs']);
            unset($properties['proofs']);
        }

        if (!empty($properties['legal_notices']) ) {
            $this->setLegalNotices($properties['legal_notices']);
            unset($properties['legal_notices']);
        }
        
        if (!empty($properties['timestamp']) ) {
            $this->setTimestamp($properties['timestamp']); 
            unset($properties['timestamp']);
        }        
      
        parent::configure($properties); 
      
    }

    /**
     * Set the specified subject in this Consent
     *
     * @param Subject $subject The Subejct to be set in
     *                         this Consent
     * 
     * @return void
     */
    public function setSubject( $subject )
    {
      
        if (! $subject instanceof Subject ) {
            $subject = new Subject($subject);
        }
      
          $this->subject = $subject;  
    }
  
    
    /**
     * Set the specified proofs in this Consent
     *
     * @param Proof[] $proofs The Proof to be set in 
     *                        this Consent
     * 
     * @return void
     */
    public function setProofs( $proofs )
    {
      
          $this->proofs = array();
      
        foreach ( $proofs as $proof ) {
            $this->addProof($proof);  
        }
    }
    
    /**
     * Add the specified Proof this Consent
     *
     * @param Proof $proof The Proof to add to this 
     *                     Consent
     * 
     * @return void
     */    
    public function addProof( $proof )
    {
      
        if (! $proof instanceof Proof ) {
            $proof = new Proof($proof);
        }
      
          $this->proofs[] = $proof;   
    }    
    
    /**
     * Set the specified LegalNotices in this Consent
     *
     * @param LegalNotice[] $legal_notices The LegalNotices to be set in this
     *                                     Consent
     * 
     * @return void
     */
    public function setLegalNotices( $legal_notices )
    {
      
          $this->legal_notices = array();
      
        foreach ( $legal_notices as $legal_notice ) {
            $this->addLegalNotice($legal_notice);  
        }
    }
    
    /**
     * Add the specified LegalNotice this Consent
     *
     * @param LegalNotice $legal_notice The LegalNotice 
     *                                  to add to this Consent
     * 
     * @return void
     */    
    public function addLegalNotice( $legal_notice )
    {
      
        if (! $legal_notice instanceof LegalNotice ) {
            $legal_notice = new LegalNotice($legal_notice);
        }
      
          $this->legal_notices[] = $legal_notice;   
    }      

    /**
     * Set the specified timestamp in this Consent
     *
     * @param string|DateTime $timestamp The datetime to be set in this Consent
     * @param string          $format    Is datetime is a string, specify the 
     *                                   date format.
     *                                   Defaults to DateTime::ATOM.
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
     * Cast this object as array
     * 
     * @return array
     */
    public function toArray()
    {
        
        $output = array( );

        if ($this->id  ) {
            $output['id']  = $this->id;
        }
        
        if ($this->preferences  ) {
            $output['preferences']  = $this->preferences;
        }    

        if ($this->timestamp  ) {
            $output['timestamp']  = $this->timestamp->format(DateTime::ATOM);
        }   
    
        if ($this->owner  ) {
            $output['owner']  = $this->owner;
        }    
        
        if ($this->source  ) {
            $output['source']  = $this->source;
        }  
        
        if ($this->subject ) {
            $output['subject'] = $this->subject->toArray();
        } else {
            $output['subject'] = false;
        }

        foreach ( $this->legal_notices as $legal_notice ) {
            $output['legal_notices'][] = $legal_notice->toArray();
        }
        
        foreach ( $this->proofs as $proof ) {
            $output['proofs'][] = $proof->toArray();
        }   

        return $output;

    }
    
} 
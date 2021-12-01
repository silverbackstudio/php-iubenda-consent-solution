<?php
/**
 * Iubenda Consent Proof Class.
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
 * This class contains details of th consent proof
 *
 * @category Iubenda
 * @package  ConsentSolution
 * @author   Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license  BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @version  Release: 1.0
 * @link     https://github.com/silverbackstudio/php-iubenda-consent-solution
 */
class LegalNotice extends ICSObject
{

    /**
     * Used to pass an identifier of your legal documents. Accepts semantic 
     * names or custom values. Pre-defined semantic names are: 'privacy_policy',
     * 'cookie_policy', 'terms'.
     *
     * @var string
     */
    public $identifier = '';

    /**
     * The content of the policy accepted by the user
     *
     * @var string
     */
    public $content = '';
    
    /**
     * The timestamp at which the consent occurred
     *
     * @var DateTime
     */
    public $timestamp = null;    
    
    /**
     * Used to specify the version of legal documents that your user has 
     * accepted. Default is “latest”.
     *
     * @var string
     */
    public $version = '';
        
    
    /**
     * Cast the object as array
     *
     * @return array
     */
    public function toArray()
    {
        
        $output = array();
        
        if ($this->identifier ) {
            $output['identifier'] = $this->identifier;
        }

        if ($this->version ) {
            $output['version'] = $this->version;
        }
        
        if ($this->content ) {
            $output['content'] = $this->content;
        }        
        
        if ($this->timestamp ) {
            $output['timestamp'] = $this->timestamp->format(DateTime::ATOM);
        }          
        
        return $output;
    }
    
} 
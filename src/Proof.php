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

/**
 * This class contains details of the form consent proof
 *
 * @category Iubenda
 * @package  ConsentSolution
 * @author   Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license  BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @version  Release: 1.0
 * @link     https://github.com/silverbackstudio/php-iubenda-consent-solution
 */
class Proof extends ICSObject
{

    /**
     * What the subject has filled (e.g. the content of the form)
     * 
     * @var string
     */
    public $content = '';

    /**
     * It’s normally used to attach what the subject was prompted with
     * 
     * @var string
     */
    public $form = '';

    
    /**
     * Cast the object as array
     * 
     * @return array
     */
    public function toArray()
    {
        
        return array(
            'content' => $this->content,
            'form' => $this->form,
        );

    }
    
} 
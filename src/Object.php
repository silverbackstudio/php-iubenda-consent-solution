<?php
/**
 * Iubenda Consent Obejct Class.
 *
 * @category Iubenda
 * @package  ConsentSolution
 * @author   Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license  BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @link     https://github.com/silverbackstudio/php-iubenda-consent-solution
 */

namespace Iubenda\ConsentSolution;

/**
 * This class contains the basic functions and requirements for other Objects.
 *
 * @category Iubenda
 * @package  ConsentSolution
 * @author   Brando Meniconi <b.meniconi@silverbackstudio.it>
 * @license  BSD-3-Clause https://opensource.org/licenses/BSD-3-Clause 
 * @version  Release: 1.0
 * @link     https://github.com/silverbackstudio/php-iubenda-consent-solution
 */
abstract class Object
{

    /**
     * Class constructor
     * 
     * @param array $properties the properties to be set in this class instance
     * 
     * @return void
     */    
    public function __construct( $properties = array() )
    {
        $this->configure($properties);
    }    
    
    
    /**
     * Configures the specified content in the class
     * 
     * @param array $properties the properties to be set in this class instance
     * 
     * @return void
     */        
    public function configure( $properties )
    {
        
        foreach ( $properties as $property => $value ) {
            if (! property_exists($this, $property) ) {
                continue;
            }
                
            $this->$property = $value;
        }      
        
    }
    
    /**
     * Cast the object as array
     * 
     * @return array
     */
    abstract public function toArray();
} 
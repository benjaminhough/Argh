<?php
	
namespace NetFocus\Argh;

class Parameter
{
	
	//
	// CONSTANTS
	//
	
	// Parameter Data Types
	const ARGH_TYPE_BOOLEAN	= 1;
	const ARGH_TYPE_INT			= 2;
	const ARGH_TYPE_STRING	= 3;
	const ARGH_TYPE_LIST		= 4;
	
	//
	// PUBLIC PROPERTIES
	//
	
	private $name = null;
	private $flag = null;
	private $type = null;
	private $required = null;
	private $default = null;
	private $text = null;
	
	//
	// STATIC METHODS
	//
	
	public static function createFromArray(array $p)
	{
		
		try
		{	
			// Defaults
			$name = null;
			$flag = null;
			$type = self::ARGH_TYPE_BOOLEAN;
			$required = FALSE;
			$default = FALSE;
			$text = null;
			
			if( array_key_exists('name', $p) ) $name = $p['name'];
			if( array_key_exists('flag', $p) ) $flag = $p['flag'];
			if( array_key_exists('type', $p) ) $type = $p['type'];
			if( array_key_exists('required', $p) ) $required = $p['required'];
			if( array_key_exists('default', $p) ) $default = $p['default'];
			if( array_key_exists('text', $p) ) $text = $p['text'];
			
			// Create a new Parameter instance
			$parameter = new self($name, $flag, $type, $required, $default, $text);
			return $parameter;
		}
		catch(Exception $e)
		{
			throw($e);
		}
	}
	
	//
	// PUBLIC METHODS
	//
	
	public function __construct($name, $flag=null, $type=self::ARGH_TYPE_BOOLEAN, $required=FALSE, $default=FALSE, $text=null)
	{
		
		//echo "new Parameter(name=$name, flag=$flag, type=$type, required=$required, default=$default, text=$text)\n";
		
		// Check for required $name
		if( empty($name) )
		{
			throw new ArghException('Parameter is missing required name');
		}
		
		// Check for optional $type
		if( !empty($type) )
		{
			// Check for valid $type
			$valid = array(self::ARGH_TYPE_BOOLEAN, self::ARGH_TYPE_INT, self::ARGH_TYPE_STRING, self::ARGH_TYPE_LIST);
			if( !in_array($type, $valid) )
			{
				throw new ArghException('Parameter \'' . $name . '\' has an invalid type');
			}
		}
		
		// Check for optional $required
		if( !empty($required) )
		{
			// Assign literal TRUE
			$required = TRUE;
		}
		
		// Check for optional $default
		if( !empty($defaut) )
		{
			if(self::ARGH_TYPE_BOOLEAN == $type)
			{
				// Assign literal TRUE for boolean defaults
				$default = TRUE;
			}	
		}
		else
		{
			if(self::ARGH_TYPE_BOOLEAN == $type)
			{
				// Assign literal FALSE for boolean defaults
				$default = FALSE;
			}			
		}
		
		// Set properties on this object
		$this->name = $name;
		$this->flag = $flag;
		$this->type = $type;
		$this->required = $required;
		$this->default = $default;
		$this->text = $text;
	}
	
	public function name() { return $this->name; }
	
	public function flag() { return $this->flag; }
	
	public function type() { return $this->type; }
	
	public function required() { return $this->required; }
	
	public function default() { return $this->default; }
	
	public function text() { return $this->text; }
	
}
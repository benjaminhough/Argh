<?php
	
/*
** Command Line Program
** Uses Argh.php to parse arguments supplied to this program
** Demonstrates the capabilities of Argh
*/

require "vendor/autoload.php";

use netfocusinc\argh\Argh;
use netfocusinc\argh\ArghException;
use netfocusinc\argh\ParameterBoolean;
use netfocusinc\argh\ParameterCommand;
use netfocusinc\argh\ParameterInteger;
use netfocusinc\argh\ParameterList;
use netfocusinc\argh\ParameterString;
use netfocusinc\argh\ParameterVariable;


/*
// Init memory
*/

echo "\n---------------------\n";
echo "RAW \$argv:\n";
print_r($argv);
echo "---------------------\n\n";

try
{
	$argh = new Argh(
		[
			ParameterBoolean::createWithAttributes(
				[
					'name'				=>	'debug',
					'flag'				=>	'd',
					'required'		=>	FALSE,
					'default'			=>	FALSE,
					'description'	=>	'Enables debug mode.'					
				]
			),
			ParameterCommand::createWithAttributes(
				[
					'name'				=>	'cmd',
					'flag'				=>	'x',
					'required'		=>	FALSE,
					'default'			=>	null,
					'description'	=>	'A command to run.',
					'options'			=>	array('help','joke')				
				]
			),
			ParameterString::createWithAttributes(
				[
					'name'				=>	'file',
					'flag'				=>	'f',
					'required'		=>	TRUE,
					'default'			=>	'sample.out',
					'description'	=>	'File to use (just an example).'				
				]
			),
			ParameterList::createWithAttributes(
				[
					'name'				=>	'colors',
					'flag'				=>	'c',
					'required'		=>	FALSE,
					'default'			=>	null,
					'description'	=>	'List of colors, for fun.'			
				]
			),
			ParameterInteger::createWithAttributes(
				[
					'name'				=>	'verbose',
					'flag'				=>	'v',
					'type'				=>	ARGH_TYPE_INT,
					'required'		=>	FALSE,
					'default'			=>	0,
					'description'	=>	'Level of verbosity to output.',
					'options'			=>	array(0, 1, 2, 3)			
				]
			)			
		]
	);
	
	$argh->parse($argv);
	
	echo "\n\n";
	
	if("help" == $argh->cmd )
	{
		echo $argh->usage() . "\n";
	}
	else if("joke" == $argh->cmd )
	{
		echo "Why did the chicken cross the road?\n";
	}
	else
	{
	
		echo "Command: " . $argh->command() . "\n";
		
		echo "Parameters: \n" . $argh->parameters()->toString() . "\n";
		
		if( $argh->parameters()->hasVariable() )
		{
			echo "Variables: \n";
			print_r($argh->variables());
			echo "\n";
		}
		
		// Show values for each parameter (exclude variables)
		foreach($argh->parameters()->all() as $p)
		{
			if(ARGH_TYPE_VARIABLE != $p->getParameterType())
			{
				echo '$argh->' . $p->getName() . ' = ';
				
				if( !is_array($argh->get($p->getName())) )
				{
					echo $argh->get($p->getName()) . "\n";
				}
				else
				{
					echo '[ ';
					foreach($argh->get($p->getName()) as $e)
					{
						echo $e . ' ';
					}
					echo ' ]';
					echo "\n";
				}
			} // END: if(ARGH_TYPE_VARIABLE != $p->type())
		}
	
	} // END: foreach($argh->parameters()->all() as $p)
	
}
catch(ArghException $e)
{
	echo 'Exception: ' . $e->getMessage() . "\n";
}

?>
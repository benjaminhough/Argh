<?php
passthru('clear');

$lines = exec('tput lines');
$cols = exec('tput cols');

$n=100;
$microsec = 100000;

for($i=0; $i<=$n; $i++)
{
	passthru('clear');

	echo "Console dimensions: ($cols, $lines)\n";
	echo "\n";

	for($j=0; $j<$i; $j++)
	{
		echo '=';
	}
	echo " (" . ($i/$n)*100 . "%)\n";

	usleep($microsec);
	
}


?>
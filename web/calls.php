<?php
	function getCell($cell) { 
		$cellStr = htmlspecialchars($cell);
		if (!$cellStr || strlen($cellStr) <= 0) {
			return '&nbsp;';
		}
		return $cellStr;
	}
	echo 'Channels:<br><br>';
	system('/usr/local/freeswitch/bin/fs_cli -x "show channels"');
	echo '<br><br>CDR<br><br>';
	echo "<html><body><table border=1>\n\n";
	$f = fopen('/usr/local/freeswitch/log/cdr-csv/Master.csv', 'r');
	while (($line = fgetcsv($f)) !== false) {
		echo '<tr>';
		foreach ($line as $cell) {
			echo '<td>' . getCell($cell) . '</td>';
		}
		echo '</tr>';
	}
	fclose($f);
	echo '</table></body></html>';
?>

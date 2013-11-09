<?php 
try {
$proj_path='G:/development/xampp/htdocs/CDS/';
$infile = $proj_path.'algorithms/data/input.txt';
$outfile = $proj_path.'algorithms/data/output48.txt';
$alg1_loc = $proj_path.'algorithms/CNM/community.exe';

$cmd = '"'.$alg1_loc . ' -i:' . $infile . ' -a:2 -o:' . $outfile.'"';
$cmd = 'G:\cygwin\bin\bash.exe --login -c '.$cmd;
//$cmd = escapeshellcmd($cmd);

$out = shell_exec($cmd);
//exec($cmd,$out,$returnval);
//`$cmd`;
echo "<br/>cmd<br/>";
print_r($cmd);
echo "<br/>out<br/>";
print_r($out);

echo "<br/>return<br/>";
print_r($returnval);

} catch (Exception $e) {
	echo "<br/>exception<br/>";
    echo $e->getMessage();
}
 ?>
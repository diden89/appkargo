<?php
$db = "merekdagang";
$datetime = date("Ymd");
$filename = "{$db}_".$datetime."_andy1t_all.sql";
// $filename_zip = "{$db}_".$datetime."_andy1t_all.7z";

// $pathtodelete = date('Y') - 1;
// if (realpath($pathtodelete) !== FALSE && is_dir($pathtodelete)) system("rmdir ".escapeshellarg($pathtodelete) . " /s /q");

// $path = date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d');

// $realpath = realpath($path);

// if ($realpath !== FALSE && is_dir($path))
// {
// 	echo 'folder already exist';
// }
// else
// {
// 	mkdir($path, 0777, TRUE);
// }

// chdir($path);

echo "Database: ".$db."\n";
echo "Filename: ".$filename."\n";

system("mysqldump --routines --skip-comments --skip-set-charset --skip-quote-names --skip-add-locks --skip-disable-keys -uroot -pkmzway87aa {$db} > {$filename}");
// system('"C:\Program Files\7-Zip\7z.exe" a '.$filename_zip.' '.$filename.' -mx9');
// system("del {$filename} /Q")
?>
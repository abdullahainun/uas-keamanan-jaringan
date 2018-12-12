<?php
        $code = $_POST['c'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        require_once('PHPOTP/code/rfc6238.php');
        $secretkey = 'GEZDGNBVGY3TQOJQGEZDGNBVGY3TQOJQ';
        $currentcode = $code;
        if (TokenAuth6238::verify($secretkey,$currentcode)) {
                if ($username=="aal"&&$password=="action") {
                        echo "Code is valid \n";
                }else{
			echo "username dan password invalid \n";
			$tanggal = date("M j H:i:s");
			$report = system("echo ".$tanggal." GAGAL ".$_SERVER['REMOTE_ADDR']);			
			file_put_contents('log/report', $report.PHP_EOL , FILE_APPEND | LOCK_EX);
		}
        }else{
                if ($username=="aal"&&$password=="action") {
			echo "invalid code \n";
			$tanggal = date("M j H:i:s");
                        $report = system("echo ".$tanggal." GAGAL ".$_SERVER['REMOTE_ADDR']);
                        file_put_contents('log/report', $report.PHP_EOL , FILE_APPEND | LOCK_EX);

                }else{
			echo "username dan password invalid \n";
                        $tanggal = date("M j H:i:s");
			$report = system("echo ".$tanggal." GAGAL ".$_SERVER['REMOTE_ADDR']);
			file_put_contents('log/report', $report.PHP_EOL , FILE_APPEND | LOCK_EX);	
		}
        }
        print sprintf('<img src="%s"/>', TokenAuth6238::getBarCodeUrl('ainun', 'abdullahainun.me', $secretkey,'Ainun%20TPA'));
?>

<?php
function request($url, $token = null, $data = null, $pin = null){
    
$header[] = "Host: api.gojekapi.com";
$header[] = "User-Agent: okhttp/3.12.1";
$header[] = "Accept: application/json";
$header[] = "Accept-Language: id-ID";
$header[] = "Content-Type: application/json; charset=UTF-8";
$header[] = "X-AppVersion: 3.37.2";
$header[] = "X-UniqueId: 9436f3bc7531d25a".mt_rand(1000,9999);
$header[] = "Connection: keep-alive";    
$header[] = "X-User-Locale: id_ID";
$header[] = "X-Location:-6.246265,106.690718";
$header[] = "X-Location-Accuracy: 3.0";
if ($pin):
$header[] = "pin: $pin";    
    endif;
if ($token):
$header[] = "Authorization: Bearer $token";
endif;
$c = curl_init("https://api.gojekapi.com".$url);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    if ($data):
    curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    curl_setopt($c, CURLOPT_POST, true);
    endif;
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    return $json;
}

function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}
function register($no)
	{
	$nama = nama();
	$email = str_replace(" ", "", $nama) . mt_rand(100, 999);
	$data = '{"name":"' . nama() . '","email":"' . $email . '@gmail.com","phone":"+' . $no . '","signed_up_country":"ID"}';
	$register = request("/v5/customers", "", $data);
	//print_r($register);
	if ($register['success'] == 1)
		{
		return $register['data']['otp_token'];
		}
	  else
		{
		return false;
		}
	}
function verif($otp, $token)
	{
	$data = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $token . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
	$verif = request("/v5/customers/phone/verify", "", $data);
	if ($verif['success'] == 1)
		{
		return $verif['data']['access_token'];
		}
	  else
		{
		return false;
		}
	}
	function login($no)
	{
	$nama = nama();
	$email = str_replace(" ", "", $nama) . mt_rand(100, 999);
	$data = '{"phone":"+'.$no.'"}';
	$register = request("/v4/customers/login_with_phone", "", $data);
	print_r($register);
	if ($register['success'] == 1)
		{
		return $register['data']['login_token'];
		}
	  else
		{
		return false;
		}
	}
function veriflogin($otp, $token)
	{
		
	$data = '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp.'","otp_token":"'.$token.'"},"grant_type":"otp","scopes":"gojek:customer:transaction gojek:customer:readonly"}';
	$verif = request("/v4/customers/login/verify", "", $data);
	if ($verif['success'] == 1)
		{
		return $verif['data']['access_token'];
		}
	  else
		{
		return false;
		}
	}
function goride($token)
	{
	$data = '{"promo_code":"COBAINGOJEK"}';
	$claim = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim['success'] == 1)
		{
		return $claim['data']['message'];
		}
	  else
		{
		return false;
		}
	}
function goride1($token)
	{
	$data = '{"promo_code":"AYOCOBAGOJEK"}';
	$claim = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim['success'] == 1)
		{
		return $claim['data']['message'];
		}
	  else
		{
		return false;
		}
	}
function gofood($token)
	{
	$data = '{"promo_code":"GOFOODSENANG12"}';
	$claim = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim['success'] == 1)
		{
		return $claim['data']['message'];
		}
	  else
		{
		return false;
		}
	}

echo "\n";
echo "\e[93m+====================================+\n";
echo "\e[93m|       بسم الله الرحمن الرحيم       |\n";
echo "\e[93m|     VOUCHER GORIDE + GOFOOD        |\n";
echo "\e[93m| http://github.com/dzulyusri/goride |\n";
echo "\e[93m|        WA : 082165550209           |\n";
echo "\e[93m+====================================+\n";
echo "\n";
ulang:
echo "\e[92m[] Masukan Nomer Hp :";
$nope = trim(fgets(STDIN));
$register = register($nope);
if ($register == false)
	{
	echo "\e[91m[x] Nomor Telah Terdaftar\n";
	sleep(1);
	echo "\e[92m[?] Masukan Nomer Baru\n";
	sleep(2);
	goto ulang;
	}
  else
	{
	echo "\e[92m[+] Masukan Kode OTP :";
	$otp = trim(fgets(STDIN));
	$verif = verif($otp, $register);
	if ($verif == true)
		{
		echo "\e[92m[+] Mohon Menunggu Redeem Voucher";
		sleep(1);
		echo "\e[92m.";
		sleep(1);
		echo "\e[92m.";
		sleep(1);
		echo "\e[92m.\n";
		sleep(2);
		goto redeem;
		}
	if ($verif == false)
		{
		echo "\e[91m[X] Kode OTP Salah\n";
		}
	  else
		{
		redeem:
		echo "\e[93m[1] Mencoba Redeem COBAINGOJEK :\n";
		sleep(2);
		$claim = goride($verif);
		if ($claim == false)
			{
			echo "\e[91m[X] Voucher Sudah Tidak Tersedia\n";
			sleep(3);
			echo "\e[93m[2] Mencoba Redeem AYOCOBAGOJEK:\n";
			sleep(2);
			goto goride1;
			}
		  else
			{
			echo "\e[92m[+] ".$claim."\n";
			sleep(3);
			echo "\e[93m[2] Mencoba Redeem AYOCOBAGOJEK:\n";
			sleep(2);
			goto goride1;
			}
			goride1:
            $claim = goride1($verif);
            if ($claim == false) {
                echo "\e[91m[X] Voucher Sudah Tidak Tersedia\n";
                sleep(3);
            }
		  else
			{
			echo "\e[92m[+] ".$claim."\n";
			echo "\e[93m[3] Mencoba Redeem GOFOODSENANG12:\n";
			sleep(2);
			goto gofood;
			}
			gofood:
            $claim = gofood($verif);
            if ($claim == false) {
                echo "\e[91m[X] Voucher Sudah Tidak Tersedia\n";
                sleep(3);
            }
		  else
			{
			echo "\e[92m[+] ".$claim."\n";
			goto thanks;
			}
		thanks:
		echo "\e[93m==========================================\n";
		echo "\e[93m|        Donasi BCA : 0222543485	     |\n";
		echo "\e[93m==========================================\n";
		}
	}
?>

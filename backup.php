<?php
//Tristan's cPanel backup.
//cpanel and ftp info
$auth = base64_encode(":"); //cpun and cppw ("un:pw")
$domain = ""; //cpanel domain + port
$theme = "paper_lantern"; //cpanel theme. Usually paper_lanter or x3
$ftp = true; 
$ftp_server = "";
$ftp_username = "";
$ftp_password = "";
$ftp_port = "21";
$ftp_directory = ""; //ftp dir. replace [website name] with website folders name
$email = ""; // Where the email notification will be sent

// Do not change below, talk to Tristan for help on this.
$url = $domain . "/frontend/" . $theme . "/backup/dofullbackup.html"; //sets the url for the exact directory to dofullbackup.html
$data = array(); //creating a data array for the ftp info
if ($ftp) { //will only create if $ftp = true
  $data["dest"] = "ftp";
  $data["server"] = $ftp_server;
  $data["user"] = $ftp_username;
  $data["pass"] = $ftp_password;
  $data["port"] = $ftp_port;
  $data["rdir"] = $ftp_directory;
  $data["email"] = $email;
}

$options = array(
  'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Basic $auth\r\n",
    'method'  => 'POST',
    'content' => http_build_query($data)
  ),
  'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
  )
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
  exit("Error backing up server. Failed with code: $result");
}

echo $result;
?>

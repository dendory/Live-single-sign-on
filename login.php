<html>
	<head>
		<title>Single Sign-on test</title>
	</head>
	<body>
		<h1>Login form</h1>
<?php
$ms_client_id       = 'xxxxxxxxxxxxxxxx';
$ms_client_secret   = 'xxxxxxxxxxxxxxxxxxxxx';
$ms_permissions     = 'wl.basic wl.signin wl.emails';
$ms_redirect_url    = 'http://yourdomain.com/login.php';

include_once("live_connect.inc.php");

$cnt_live = new MocrosoftLiveCnt(array(
    'client_id'     => $ms_client_id,
    'client_secret' => $ms_client_secret,
    'client_scope'  => $ms_permissions,
    'redirect_url'  => $ms_redirect_url
));

$user_info = $cnt_live->getUser();

if(!$user_info && isset($_GET["code"])) // redirect from Live Connect
{
    $access_token  = $cnt_live->getAccessToken($_GET["code"]);
    $cnt_live->setAccessToken($access_token);
    header('Location: ' . $cnt_live->GetRedirectUrl());
}
else if(!$user_info) // not logged in
{
    $loginUrl = $cnt_live->GetLoginUrl();
    echo "<center><a href='" . $loginUrl . "'><img src='win_live_login.png' border=0></a></center>";
}
else // logged in
{
	echo "<p>Name: " . $user_info->name . "</p>";
	echo "<p>ID: " . $user_info->id . "</p>";
	echo "<p>Email: " . $user_info->emails->preferred . "</p>";
	//
	// Place your logged in content here.
	//
}
?>
	</body>
</html>
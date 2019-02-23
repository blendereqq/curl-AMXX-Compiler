<?php
error_reporting(0);
if ($_POST['go'])

{

function createPostString($aPostFields) {

    foreach ($aPostFields as $key => $value) {

        $aPostFields[$key] = urlencode($key) . '=' . urlencode($value);

    }

    return implode('&', $aPostFields);

}

$postFields['fname'] = $_POST['fname'];

$postFields['scode'] = $_POST['scode'];

$postFields['go'] = 'send';

$ch = curl_init('http://amxmodx.org/webcompiler.cgi');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; pl; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3');

curl_setopt($ch, CURLOPT_POSTFIELDS, createPostString($postFields));

$tresc = curl_exec($ch);

if (curl_errno($ch))

    echo 'Blad #' . curl_errno($ch) . ': ' . curl_error($ch);

curl_close($ch);

if (strpos($tresc, "Your plugin successfully compiled!"))

{

	$tresc = substr($tresc, strpos($tresc, "http://www.amxmodx.org/webcompiler.cgi?"));

	$ile = strpos($tresc, "</a>");

	$link = substr($tresc, 0, $ile);

	$tresc = substr($tresc, strpos($tresc, "Welcome to the AMX Mod X"));

	$ile = strpos($tresc, "</pre>");

	$inf = substr($tresc, 0, $ile);

	$inf = str_replace("\r\n","<br/ >", $inf);

	echo '
	<!DOCTYPE html>
	<head>
		<title>AMXX / SourceMod Compiler</title>

	 	<link rel="stylesheet" href="styles.css">

		<div class="std">
		<br>
		<p>
			<h2 class="header">AMXX and SourceMod Compiler</h2>
		</p>
		</div>
		<hr width="800">
	</head>
<body>
<div class="std">
<h1>Compile Succesfull!</h1><br />
	<b>Compilator Console: </b>
	<pre>'.$inf.'</pre></pre>
	<a href="'.$link.'"><b>Download Plugin</b></a><br />
	<hr width="800">
<footer>
		Author: <address>BlendeR(<a href="http://blendereqq.000webhostapp.com">blendereqq.000webhostapp.com</a>)</address>
	</footer>
</div>
</body>

';

} else

{

	$ktory = strpos($tresc, "Your plugin failed to compile");

	$tresc = substr($tresc, $ktory + 63);

	$ile = strpos($tresc, "</pre>");

	$tresc = substr($tresc, 0, $ile);

	echo '<!DOCTYPE html>
	<head>
		<title>AMXX / SourceMod Compiler</title>
	 	<link rel="stylesheet" href="styles.css">
		<div class="std">
		<br>
		<p>
			<h2 class="header">AMXX and SourceMod Compiler</h2>
		</p>
		</div>
		<hr width="800">
	</head>
<body>
<div class="std">
<h1>Failed to compile plugin!</h1><br><b>Compilator Console:</b>
<pre>'.$tresc.'</pre></pre>
<hr width="800">
<footer>
		Author: <address>BlendeR(<a href="http://blendereqq.000webhostapp.com">blendereqq.000webhostapp.com</a>)</address>
	</footer>
</div>
</body>';

}

} else

{

echo '
<!DOCTYPE html>
	<head>
		<title>AMXX / SourceMod Compiler</title>
	 	<link rel="stylesheet" href="styles.css">
		<div class="std">
		<br>
		<p>
			<h2 class="header">AMXX and SourceMod Compiler</h2>
		</p>
		</div>
		<hr width="800">
	</head>
<body>
<div class="std">
<form action="" method="post" >
			<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
					Smart Tip: This Compiler Can Only Compile Without External Includes Libraries !
			</div>
<b>Plugin Name :</b> <input type="text" name="fname" size="15" value="My_Plugin"><br />


<br><b>Source Code:</b>



<br />

<center><textarea name="scode" rows="30" cols="100" placeholder="Put code Here!">#include <amxmodx>
#include <amxmisc>

#define PLUGIN "New Plug-In"
#define VERSION "1.0"
#define AUTHOR "author"


public plugin_init() {
	register_plugin(PLUGIN, VERSION, AUTHOR)
	
	// Add your code here...
}</textarea></center><br />


<input type="hidden" name="go" value="1">
<input class="butt" type="submit" value="Compile">
</br>
</form>
<hr width="800">
<footer>
		Author: <address>BlendeR(<a href="http://blendereqq.000webhostapp.com">blendereqq.000webhostapp.com</a>)</address>
	</footer>
</div>
</body>
';

}

?>
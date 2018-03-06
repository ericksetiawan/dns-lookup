<!DOCTYPE HTML>
<?php 
	require "functions/domain.php";
	require "functions/whois.php";

	$displayCAPTCHA = true;
	$secret = 'your-google-recapthca-secret-key';
	$sitekey = 'your-google-recapthca-site-key';

	if(isset($_POST['domain'])) {

		$displayCAPTCHA = false;

		$domainName = $_POST['domain'];
		
		$a = ARecord($domainName);
		$aaaa = AAAARecord($domainName);
		$mx = MXRecord($domainName);
		$ns = NSRecord($domainName);
		$soa = SOARecord($domainName);
		$txt = TXTRecord($domainName);
		$srv = SRVRecord($domainName);
		$cname = CNAMERecord($domainName);

		
		$domain = trim($domainName);
		if(substr(strtolower($domain), 0, 7) == "http://") $domain = substr($domain, 7);
		if(substr(strtolower($domain), 0, 4) == "www.") $domain = substr($domain, 4);
		if(ValidateIP($domain)) {
			$whoisResult = LookupIP($domain);
		}
		elseif(ValidateDomain($domain)) {
			$whoisResult = LookupDomain($domain);
		}
		else die("Invalid Input!");
	}

	if(isset($_POST['submit']))  {
		if(isset($_POST['g-recaptcha-response'])) {
	        
	        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	        $responseData = json_decode($verifyResponse,true);
	        if($responseData['success'] == 1) {
	        	if(isset($_POST['domain'])) {

	        		$displayCAPTCHA = false;

					$domainName = $_POST['domain'];
					
					$a = ARecord($domainName);
					$aaaa = AAAARecord($domainName);
					$mx = MXRecord($domainName);
					$ns = NSRecord($domainName);
					$soa = SOARecord($domainName);
					$txt = TXTRecord($domainName);
					$srv = SRVRecord($domainName);
					$cname = CNAMERecord($domainName);
					
					$domain = trim($domainName);
					if(substr(strtolower($domain), 0, 7) == "http://") $domain = substr($domain, 7);
					if(substr(strtolower($domain), 0, 4) == "www.") $domain = substr($domain, 4);
					if(ValidateIP($domain)) {
						$whoisResult = LookupIP($domain);
					}
					elseif(ValidateDomain($domain)) {
						$whoisResult = LookupDomain($domain);
					}
					else die("Invalid Input!");
				}
	        }
		}
	}
	
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width">		
		<meta name="description" content="norak.us free DNS Lookup tool">
		<meta name="keywords" content="DNS, Lookup, A, AAAA, ipv4, ipv6, mx, txt, srv, cname, ptr, whois, record, records">
		<meta name="author" content="erick">
		<title>DNS Lookup Tool :: norak.us</title>
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<style type="text/css">
            @media screen {
            @font-face {
            font-family: 'CC-ICONS';
            font-style: normal;
            font-weight: normal;
            src: url('http://mirrors.creativecommons.org/presskit/cc-icons.ttf') format('truetype');
            }

            span.cc {
            font-family: 'CC-ICONS';
            color: #FFF;
            }
            }
        </style>

        
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<h1>DNS Lookup Tool</h1>
						 <!-- <p><a href="http://norak.us/"><span class="cc">c b a</span>&nbsp;&nbsp;ER . 2016</a></p> -->
							<?php 
								echo " Your IP is : $_SERVER[REMOTE_ADDR]";
							?>
							<form method="POST"  />
								<div class="12u 12u$(xsmall)">
									<input type="text" name="domain" placeholder="<?php if(isset($domainName)) { echo $domainName;} else { echo 'example.com';} ?>" value="" required/>
								</div>
								&nbsp;
								<div class="12u 12u$(xsmall)">
									<?php 
										if($displayCAPTCHA == true){
											echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
											echo "<div align=center class=g-recaptcha data-sitekey=".$sitekey." data-callback=doSomething></div>";
										}
									?>								
								</div>
								&nbsp;
								<div class="12u 12u$(xsmall)">
									<input id="submit" type="submit" name="submit" value="Submit" class="button special small" />
								</div>

							</form>
						<?php 
							if(isset($domainName)) {
								echo "
								<p>Lookup results for : <a href=\"http://".$domainName."\" target=\"_blank\"><strong>".$domainName."</strong></a></p>
								";
							}
						?>
					</header>
				
				<!-- Nav -->
				<?php 
					if(isset($domainName)) {
						echo "
							<nav id=\"nav\">
								<ul >
									<li>
										<a href=\"http://mxtoolbox.com/SuperTool.aspx?action=blacklist%3a".$domainName."\" target=\"_blank\">Blacklist Check</a>
									</li>
									<li>
										<a href=\"#a\" class=\"active\">A</a>
									</li>
									<li>
										<a href=\"#mx\" >MX</a>
									</li>
									<li>
										<a href=\"#ns\" >NS</a>
									</li>
									<li>
										<a href=\"#soa\" >SOA</a>
									</li>
									<li>
										<a href=\"#txt\" >TXT</a>
									</li>
									<li>
										<a href=\"#srv\" >SRV</a>
									</li>
									<li>
										<a href=\"#cname\" >CNAME</a>
									</li>
									<li>
										<a href=\"#whois\" >WHOIS</a>
									</li>
								</ul>
							</nav>
						";
					}
				?>	

				<!-- Main -->
					<div id="main">
					<?php 
						if(isset($domainName)) {
							echo "
								
								<section id=\"a\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>IPv4 and IPv6 Records</h2>
											</header>
											<h3><strong>A</strong></h3>
											<p>".$a."</p>
											<h3><strong>AAAA</strong></h3>
											<p>".$aaaa."</p>
										</div>
									</div>
								</section>
								
								<section id=\"mx\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>MX Records</h2>
											</header>
											<p>".$mx."</p>
										</div>
									</div>
								</section>
								
								<section id=\"ns\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>NS Records</h2>
											</header>
											<p>".$ns."</p>
										</div>
									</div>
								</section>
								
								<section id=\"soa\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>SOA Records</h2>
											</header>
											<p>".$soa."</p>
										</div>
									</div>
								</section>
								
								<section id=\"txt\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>TXT Records</h2>
											</header>
											<p>".$txt."</p>
										</div>
									</div>
								</section>
								
								<section id=\"srv\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>SRV Records</h2>
											</header>
											<p>".$srv."</p>
										</div>
									</div>
								</section>
								
								<section id=\"cname\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>CNAME Records</h2>
											</header>
											<p>".$cname."</p>
										</div>
									</div>
								</section>
								
								<section id=\"whois\" class=\"main\">
									<div class=\"spotlight\">
										<div class=\"content\">
											<header class=\"major\">
												<h2>WHOIS</h2>
											</header>
											<p>".$whoisResult."</p>
										</div>
									</div>
								</section>
							";
						}
					?>

				</div>
				<!-- Footer -->
					<footer id="footer">
					<p><font face="Verdana" size="1">[c]2016, LucuBRB &amp; Erick Setiawan.<br>
					Partner : <a target="_blank" href="http://www.igodns.com/">igodns.com</a>. 
					Thanks to :
					<a target="_blank" href="http://www.jonathandavis.me.uk/2014/09/writing-a-dns-look-up-tool/">
					Jonathan Davis</a></font></p>
					</footer>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script>
				$(document).ready(function() {
					$('#submit').prop('disabled', true);
				});

				function doSomething() { $('#submit').prop('disabled', false); }
			</script>

	</body>
</html>

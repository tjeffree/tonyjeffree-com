<!DOCTYPE html>
<!--
This is the HTML source for my web page, thanks for looking! Source code does not get enough credit.
-->
<html lang="en">
<head>
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" />
<title>Tony Jeffree</title>
<link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/run.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="/favicon.ico" />
</head>
<body>
<?php

ini_set('display_errors',1);
error_reporting(-1);

include 'assets/WebDev.class.php';

$dev = new TonyJeffree;

?>

<div class="container-narrow">

<div class="jumbotron">
	<h1><?=TonyJeffree::NAME?></h1>
	<h2><a href="mailto:<?=TonyJeffree::EMAIL?>"><?=TonyJeffree::EMAIL?></a></h2>
	<h2>Twitter: <?=TonyJeffree::TWITTER?></h2>
	<h2>LinkedIn: <?=TonyJeffree::LINKEDIN?></h2>
	<h2>GitHub: <?=TonyJeffree::GITHUB?></h2>
</div>

<h2>Core Skills</h2>

<ul>
<?php
foreach ($dev->exp as $skill => $exp) {
	?><li><?=$skill?> - <?=$exp?> Years</li>
	<?php
}
?>
</ul>

<hr />

<h2>Skills</h2>

<ul>
<?php
foreach ($dev->skills as $skill) {
	?><li><?=$skill?></li>
	<?php
}
?>
</ul>

<hr />

<h2>Web Sites</h2>

<ul>
	<?php
	foreach ($dev->websites as $w) {
		?><li><a href="<?=$w[1]?>" target="_blank"><?=$w[0]?></a></li>
		<?php
	}
	?>
</ul>

<hr />

<h2>Employment</h2>

<ul>
<?php
foreach ($dev->employment as $emp) {
	?><li>
		<p>Company Name: <?=$emp->companyName?></p>
		<p>Job Title: <?=$emp->title?></p>
		<p><?=$emp->startDate->format('F Y')?> to <?=($emp->finishDate->format('m-Y')==date('m-Y') ? 'Current' : $emp->finishDate->format('F Y') )?></p>
		<h3>Responsibilities</h3>
		<ul>
			<?php
			foreach ($emp->responsibilities as $r) {
				?><li><?=$r?></li>
				<?php
			}
			?>
		</ul>

		<h3>Implemented</h3>
		<ul>
			<?php
			foreach ($emp->implemented as $r) {
				?><li><?=$r?></li>
				<?php
			}
			?>
		</ul>

		<hr />

	</li>
	<?php
}
?>
</ul>

</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php echo ClanCats::$config->charset; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $description; ?>">

	<!-- styling -->
	<?php echo CCAsset::code( 'css', 'vendor' ); ?>
	<?php echo CCAsset::code( 'css', 'theme' ); ?>
	<?php echo CCAsset::code( 'css' ); ?>

	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- header scripts -->
	<?php echo CCAsset::code( 'js', 'header' ); ?>
</head>
<body>

<div id="ccd-navigation-container">
	<div class="main-navigation">
		<a id="ccd-logo" href="<?php echo to('@admin'); ?>">
			<img alt="ClanCats Earth" src="<?php echo CCAsset::uri( 'img/logo.png', 'theme' ); ?>" />
		</a>
		<ul>
			<li><a href="#"><i class="glyphicon glyphicon-heart"></i></a></li>
		</ul>
	</div>
	<div class="sub-navigation">
		<div class="page-topic">
			<h1><?php echo $topic; ?></h1>
		</div>
	</div>
</div>

<div id="ccd-content-container">
	<?php echo $content; ?>
</div>



<!-- footer scripts -->
<?php echo CCAsset::code( 'js', 'vendor' ); ?>
<?php echo CCAsset::code( 'js', 'theme' ); ?>
<?php echo CCAsset::code( 'js' ); ?>
<?php echo $js; ?>
</body>

</html>
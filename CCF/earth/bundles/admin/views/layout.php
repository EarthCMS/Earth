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
		<ul class="ccd-icon-nav">
			
		<?php foreach( $admin_modules as $module ) : ?>
			<li class="<?php echo $module->active ? 'active' : ''; ?>"><a href="<?php echo $module->link(); ?>">
				<span class="icon-nav-label"><?php echo $module->title(); ?></span>
				<?php if ( $module->is_image() ) : ?>
				<img class="image-icon" alt="<?php echo $module->title(); ?>" src="<?php echo $module->icon(); ?>" />
				<?php else: ?>
				<i class="icon <?php echo $module->icon(); ?>"></i>
				<?php endif; ?>
			</a></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div class="sub-navigation">
		<!-- main module -->
		<div class="page-topic">
			<h1><?php echo $topic; ?></h1>
		</div>
		<?php echo $active_admin_submodule->sidebar(); ?>
		
		
		<?php if ( count( $active_admin_module->modules ) > 0 ) : ?>
		<div class="pdn10">
			<hr style="border-color: #333">
		</div>
		
		<!-- subnavi -->
		<div class="module-list">
			<a class="module-topic <?php echo $active_admin_module == $active_admin_submodule ? 'active' : ''; ?>" href="<?php echo $active_admin_module->link(); ?>">
				<h2><?php echo $active_admin_module->title(); ?></h2>
			</a>
			<?php foreach( $active_admin_module->modules as $submodule ) : ?>
			<a class="module-topic <?php echo $submodule->active ? 'active' : ''; ?>" href="<?php echo $submodule->link(); ?>">
				<h2><?php echo $submodule->title(); ?></h2>
			</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</div>

<div id="ccd-panel" class="panel-hidden">
	<div class="panel-container">
	</div>
</div>

<div id="ccd-content-container">
	<div class="clearfix">
		<div class="content-header content-header-fixed">
			<?php foreach( $content_header as $header ) : ?>
			<div class="header-item">
				<?php echo $header; ?>
			</div>
			<?php endforeach; ?>
			<div class="header-item pull-right page-topic">
				<h2><?php echo $content_topic; ?></h2>
			</div>
		</div>
	</div>
	<div class="clearfix">
		<?php echo $content; ?>
	</div>
</div>



<!-- footer scripts -->
<?php echo CCAsset::code( 'js', 'vendor' ); ?>
<?php echo CCAsset::code( 'js', 'admin.orbit' ); ?>
<?php echo CCAsset::code( 'js', 'theme' ); ?>
<?php echo CCAsset::code( 'js' ); ?>
<script>
CC.init(
{
	lang: '<?php echo CCLang::current(); ?>',
	
	// UI
	ui: {
		loading_img: '<?php echo CCAsset::uri( 'img/loading.gif', 'theme' ); ?>'	
	}
});
</script>
<?php echo $js; ?>
</body>

</html>
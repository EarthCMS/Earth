<div class="content-search">
	<form method="post">
		<i class="el-icon-search"></i>
		{{UI\Form::input( 'content-search', '', 'search' )
			->add_class('transparent')
			->placeholder( __(':action.search.placeholder') )}}
	</form>
</div>
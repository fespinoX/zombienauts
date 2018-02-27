<h1>Add Your Custom CSS Below</h1>
<style type="text/css">
	.customcss{ width: 100%; height: 200px;margin-bottom:10px; }
</style>
<form method="post">
	<?php $css_content = get_option('customcss');	
	 ?>
	<textarea name="customcss" class="customcss"><?php if(!empty($css_content)): echo $css_content; endif; ?></textarea>
	<input type="submit" value="Update CSS" name="updatecss" class="button-primary">
</form>
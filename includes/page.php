<?php
class Page
{
	public static function header($title, $pageId)
	{
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<title><?php echo $title ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/styles.css" />
	<script>
	(function()
	{
		var html = document.getElementsByTagName('html')[0];
		html.className = html.className.replace('no-js', 'js');
	})();
	</script>
</head>
<body id="<?php echo $pageId ?>">
<?php	
	}
	
	public static function footer($jsFunction = null)
	{
?>
	<script src="js/scripts.js"></script>
<?php
		if (!empty($jsFunction))
		{
			echo '
	<script>', $jsFunction, '();</script>';
		}
?>
</body>
</html>
<?php
	}
}
?>
<?php
class Page
{
	public static function header($title)
	{
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
	<meta charset="UTF-8" />
</head>
<body>
<?php	
	}
	
	public static function footer()
	{
?>
</body>
</html>
<?php
	}
}
?>
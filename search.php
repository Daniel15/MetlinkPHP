<?php
// TODO: Clean this page up! It is UGLY right now
require 'includes/core.php';

$search = new JourneyPlanner_Search();
$search->from = $_POST['from'];
$search->fromType = $_POST['from_type'];
$search->to = $_POST['to'];
$search->toType = $_POST['to_type'];
$search->time = strtotime($_POST['time']);
$search->timeType = $_POST['time_type'];
$results = $search->search();

if (!$results->from->valid || !$results->to->valid)
{
	Page::header('Invalid location');
	
	echo '
	<form action="search.php" method="post">
		<input type="hidden" name="from_type" value="', htmlspecialchars($_POST['from_type']), '" />
		<input type="hidden" name="to_type" value="', htmlspecialchars($_POST['to_type']), '" />
		<input type="hidden" name="time" value="', htmlspecialchars($_POST['time']), '" />
		<input type="hidden" name="time_type" value="', htmlspecialchars($_POST['time_type']), '" />
	';
	
	outputLocation('from', $results->from);
	outputLocation('to', $results->to);
	
	echo '
		<input type="submit" value="Search" />
	</form>';
	
	Page::footer();
	
	die();
}
	
Page::header('Search Results');

echo '
	<p>
		From: <strong>', $results->from->value, '</strong>,
		to: <strong>', $results->to->value, '</strong>
		at <strong>', date('Y-m-j g:i A', $search->time), '</strong>
	</p>
	<p>Available routes:</p>
	<ul>';
	
foreach($results->routes as $route)
{
	outputRoute($route);
}

	echo '
	</ul>';

//echo '<pre>', print_r($results, true), '</pre>';

Page::footer();

function outputRoute(Node_Route $route)
{
	echo '
		<li>
			Depart ', date('g:i A', $route->depart), ', arrive ', date('g:i A', $route->arrive), ' (', $route->totalTime, '). ';
	
	$transportTypes = array();
	foreach ($route->segments as $segment)
	{
		if ($segment->via->type != 'Walk')
			$transportTypes[] = $segment->via->type;
	}
		
	echo implode(' &rarr; ', $transportTypes);
	
	echo '
			<ul>';
			
	foreach ($route->segments as $segment)
	{
		outputSegment($segment);
	}
			
	echo '
			</ul>
		</li>';
}

function outputSegment(Node_Segment $segment)
{
	echo '
				<li>
					', $segment->via->route, ' ', $segment->via->type, '<br />
					<strong>From:</strong> ', $segment->from->name, ' (', date('g:i A', $segment->from->time), ')<br />
					<strong>To:</strong> ', $segment->to->name, ' (', date('g:i A', $segment->to->time), ')
				</li>';
}

function outputLocation($where, Node_Place $location)
{
	echo '
		<p>
			<strong>', ucfirst($where), ': </strong> ';
		
	if ($location->valid)
	{
		echo $location->value, '<br />
			<input type="hidden" name="', $where, '" value="', htmlspecialchars($location->value), '" />';
		return;
	}
	
	echo 'You entered "', htmlspecialchars($location->input), '". ';
	
	if (count($location->options) == 0)
	{
		echo ' No matches found!</p>';
		return;
	}
	
	echo 'Did you mean:
			<ul>';
		
	$i = 0;
	foreach ($location->options as $option)
	{
		$id = $where . '_' . ++$i;
		echo '
				<li><input type="radio" name="', $where, '" value="', $option, '" id="', $id, '" /> <label for="', $id,'">', $option, '</label></li>';
	}

	echo '
			</ul>
		</p>';
}
?>
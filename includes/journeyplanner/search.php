<?php
class JourneyPlanner_Search
{
	const SEARCH_URL = 'http://jp.metlinkmelbourne.com.au/metlink/XML_TRIP_REQUEST2';
	// TODO: Use setters instead of public properties
	public $from = null;
	public $to = null;
	public $time;
	public $fromType = 'address';
	public $toType = 'address';
	
	public function search()
	{
		$this->fromType = $this->getSearchType($this->fromType);
		$this->toType = $this->getSearchType($this->toType);
		$url = self::SEARCH_URL . '?' . http_build_query(self::getParams(), null, '&');	
		
		$xml = simplexml_load_file($url);
		$data = new Result_Search;
		$data->from = new Node_Place($xml->itdTripRequest->itdOdv[0]->itdOdvName);
		$data->to = new Node_Place($xml->itdTripRequest->itdOdv[1]->itdOdvName);
		
		// If it's not valid, just quit now!
		if (!$data->from->valid || !$data->to->valid)
			return $data;
		
		foreach ($xml->itdTripRequest->itdItinerary->itdRouteList->itdRoute as $routeData)
		{			
			$route = $data->routes[] = new Node_Route;
			$route->totalTime = (string)$routeData['publicDuration'];
			
			foreach ($routeData->itdPartialRouteList->itdPartialRoute as $segmentData)
			{				
				$segment = $route->segments[] = new Node_Segment;
				$segment->from = new Node_Point($segmentData->itdPoint[0]);
				$segment->to = new Node_Point($segmentData->itdPoint[1]);
				$segment->minutes = (int) $segmentData['timeMinute'];
				$segment->via = new Node_TransportMethod($segmentData->itdMeansOfTransport);
			}
			
			// Fill in departure and arrival times
			$route->depart = $route->segments[0]->from->time;
			$route->arrive = $segment->to->time;
		}
		
		return $data;
	}
	
	protected function getParams()
	{
		// TODO: Check if all of these are actually needed
		return array(
			'sessionID' => '0',
			'language' => 'en',
			'requestID' => '0',
			'ptOptionsActive' => '1',
			'itOptionsActive' => '1',
			'useProxFootSearch' => '1',
			'anySigWhenPerfectNoOtherMatches' => '1',
			'place_origin' => '',
			'place_destination' => '',
			'nameState_origin' => 'empty',
			'execIdentifiedLoc_origin' => '1',
			'execStopList_origin' => '0',
			'nameState_destination' => 'empty',
			'execIdentifiedLoc_destination' => '1',
			'execStopList_destination' => '0',
			'type_destination' => 'any',
			'type_origin' => 'any',
			
			'anyObjFilter_origin' => $this->fromType,
			'anyObjFilter_destination' => $this->toType,
			
			'name_origin' => $this->from,
			'name_destination' => $this->to,
			'itdTripDateTimeDepArr' => $this->timeType,
			'itdDateDay' => date('j', $this->time),
			'itdDateYearMonth' => date('Ym', $this->time),
			'itdTimeHour' => date('g', $this->time),
			'itdTimeMinute' => date('i', $this->time),
			'itdTimeAMPM' => date('a', $this->time),
		);
	}
	
	protected function getSearchType($type)
	{
		switch ($type)
		{
			case 'address':
				return '29';
			case 'stop':
				return '2';
			case 'landmark':
				return '32';
			default:
				return $type;
		}
	}
}
?>
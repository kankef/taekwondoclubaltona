<?php
require_once __DIR__ . '/../vendor/autoload.php';

$client = new Google_Client();
$client -> setApplicationName("Taekwondo_Events");

// Warn if the API key isn't set.
if (!$apiKey = getApiKey()) {
  echo missingApiKeyWarning();
  return;
}

$client -> setDeveloperKey($apiKey);
$service = new Google_Service_Calendar($client);

$calendarId = 'llvl5ln5c8mq2ugkhk01jnpd90@group.calendar.google.com';
$optParams = array(
    'maxResults' => 3,
    'orderBy' => 'startTime',
    'singleEvents' => TRUE,
);
$events = $service->events->listEvents($calendarId, $optParams);
$eventArray = array();

foreach ($events->getItems() as $event) 
{
    $start = $event->start->dateTime;
    if (empty($start)) {
        $start = $event->start->date;
    }
    $startTime = new DateTime($start);
    $theDate = date_format($startTime, "M j");

    array_push($eventArray, new EventItem(true, $theDate, $event->getSummary(), 
                $event->getDescription(), $event->getHtmlLink()));
}

//if less than 3 events create empty objects with isEvent set to false
//so that event.js can hide this element
while (count($eventArray) < 3) {
    array_push($eventArray, new EventItem(false, null, null, null, null));
}

echo json_encode($eventArray);

function getApiKey()
{
  $file = __DIR__ . '/../.apiKey';
  if (file_exists($file)) {
    return file_get_contents($file);
  }
}

function missingApiKeyWarning()
{
  $ret = "
    <h3 class='warn'>
      Warning: You need to set a Simple API Access key from the
      <a href='http://developers.google.com/console'>Google API console</a>
    </h3>";

  return $ret;
}
?>

<?php
class EventItem {
    public $isEvent;
    public $date;
    public $name;
    public $desc;
    public $link;

    public function __construct($isEvent, $date, $name, $desc, $link)
    {
        $this -> isEvent = $isEvent;
        $this -> date = $date;
        $this -> name = $name;
        $this -> desc = $desc;
        $this -> link = $link;
    }
}
?>
// Events Scripts

$(document).ready(function() {
  $.ajax( { 
    url  : '././events/events.php',
    type : 'GET',
    data : { },
    success: function ( data ) {
      setEvents(data);
    },
    error: function ( xhr ) {
      alert( "error" );
    }
  });
});

function setEvents(data) {
  var response = JSON.parse(data);

  $("#eventItems").children().each(function (index) {
    if (response[index].isEvent){
      var event = response[index];

      $(this).find(".event-date").html(event.date);
      $(this).find(".event-name").html(event.name);
      $(this).find(".event-desc").html(event.desc);
      $(this).find("a").attr("href", event.link);
    }
    else{
      $(this).hide();
    }
  });
}
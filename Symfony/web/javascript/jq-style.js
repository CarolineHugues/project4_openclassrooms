// Présentation des informations pratiques sous forme d'onglets
$( function() {
    $( "#tabs" ).tabs();
} );

//Afficher seulement "Billet demi-journée" si le jour même est sélectionné, une fois midi passé
$( function() {
    var today = new Date();
    var todayText = today.toLocaleDateString();;
    $('#booking_visitDay').change(function() 
    {
      var selectedDate = $("#booking_visitDay_0_date").val();
      if ((selectedDate == todayText) && (today.getHours() > 12))
      {
        $("#booking_ticketType_0").next('label').hide();
        $("#booking_ticketType_0").hide();
      }
      else
      { 
        $("#booking_ticketType_0").next('label').show();
        $("#booking_ticketType_0").show();
      }
    });
} );

// Pouvoir ajouter et supprimer des tickets dans le formulaire de réservation selon le nombre indiqué
$( function() {
    var $container = $('div#booking_tickets');

    var index = $container.find(':input').length;

    $('#booking_numberOfTickets').change(function(e) 
    {
    	var numberTickets = $("#booking_numberOfTickets").val(); 
    	
      if (numberTickets < 0)
      {
        numberTickets.replace(/\D/g,'');
      }
      else if (index < numberTickets)
    	{
    		while(index < numberTickets)
    		{
    			addTicket($container);
    		}
   		}
   		else
    	{
    		while(index > numberTickets)
   			{
    			deleteTicket();
    		}
   		}
   	});


    function addTicket($container) {

      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Ticket n°' + (index+1))
        .replace(/__name__/g,        index)
      ;

      var $prototype = $(template);

      $container.append($prototype);

      index++;
    }

    function deleteTicket() {
	
      var $ticketToDelete = $("#booking_tickets_" + (index-1)).parent();

      $ticketToDelete.remove();

      index--;
    }  	
});

// Pouvoir sélectionner un jour de visite
$( function() {
    var $container = $('div#booking_visitDay');

    var index = $container.find(':input').length;

    if (index == 0)
    {
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Date')
        .replace(/__name__/g,        index)
      ;

      var $prototype = $(template);

      $container.append($prototype);
    }
});

function noTuesdayOrHolidaysOrTooLate(date) {
  var today = new Date();
  if (date.getDay() == 2 || (date.getDate() == 1 && date.getMonth() == 4) 
  || (date.getDate() == 1 && date.getMonth() ==  10) || (date.getDate() == 25 && date.getMonth() == 11) || 
  (date.getDate() == today.getDate() && date.getMonth() == today.getMonth() && 
    date.getFullYear() == today.getFullYear() && today.getHours() > 18))
  { 
    return [false, ''];    
  } 
  else 
  {
    return [true, ''];
  }
}

$( function() {
    $.datepicker.setDefaults($.datepicker.regional["fr"]);
    $(".js-datepicker").datepicker({
      minDate : 0,
      beforeShowDay : noTuesdayOrHolidaysOrTooLate
    })
});
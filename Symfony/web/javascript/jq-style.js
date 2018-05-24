// Présentation des informations pratiques sous forme d'onglets
$( function() {
  if (window.matchMedia("(min-width: 640px)").matches) 
  {
    $( "#tabs" ).tabs();
  }
  else
  {
    $( "#accordion" ).accordion();
  }

// Pouvoir sélectionner un jour de visite
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

  $.datepicker.setDefaults($.datepicker.regional["fr"]);
  $(".js-datepicker").datepicker({
    minDate : 0,
    beforeShowDay : noTuesdayOrHolidaysOrTooLate
  })

//Afficher les champs du formulaire au fur et à mesure
	$("#booking_ticketType").parent().hide();
	$("#booking_mail").parent().hide();
	$("#booking_numberOfTickets").parent().hide();
	$("#booking_tickets").parent().hide();
	$("#booking_save").parent().hide();

	$('#booking_visitDay').change(function() 
	{
		$("#booking_ticketType").parent().show();
	})

	$('#booking_ticketType').change(function() 
	{
		$("#booking_mail").parent().show();
		$("#booking_numberOfTickets").parent().show();
	})

	$('#booking_numberOfTickets').change(function() 
	{
		$("#booking_tickets").parent().show();
		$("#booking_save").parent().show();
	})

//Afficher seulement "Billet demi-journée" si le jour même est sélectionné, une fois midi passé
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

// Pouvoir ajouter et supprimer des tickets dans le formulaire de réservation selon le nombre indiqué
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
  })

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
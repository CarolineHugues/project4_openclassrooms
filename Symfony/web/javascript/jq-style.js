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


$.getJSON('http://localhost/Symfony/web/app_dev.php/visitDays', function( data ) {
  function getY(visitDaysDate)
  {
    return visitDaysDate[0] + visitDaysDate[1] + visitDaysDate[2] + visitDaysDate[3];
  }

  function getM(visitDaysDate)
  {
    if (visitDaysDate[5] == "0")
    {
      return visitDaysDate[6] - 1;
    }
    else
    {
      return (visitDaysDate[5] + visitDaysDate[6]) - 1;
    }
  }

  function getD(visitDaysDate)
  {
    if (visitDaysDate[8] == "0")
    {
      return visitDaysDate[9];
    }
    else
    {
      return visitDaysDate[8] + visitDaysDate[9];
    }
  }

  function isAvailable(date, i) {
    var visitDays = data;
    var visitDaysDate = visitDays[i].date.date;
    if  (date.getFullYear() == getY(visitDaysDate) && date.getMonth() == getM(visitDaysDate) && date.getDate() == getD(visitDaysDate) && visitDays[i].gauge >= "1000")
    { 
      return false;
    } 
    else 
    {
      return true;
    }
  }

  function noTuesdayOrHolidaysOrTooLate(date) {
    var today = new Date();
    var visitDays = data;
    for (var i = 0; i < visitDays.length; i++) {
      var isAvailableDate = isAvailable(date, i);
      if (isAvailableDate == false)
      {
        break;
      }
    }
    if (date.getDay() == 2 || (date.getDate() == 1 && date.getMonth() == 4) 
    || (date.getDate() == 1 && date.getMonth() ==  10) || (date.getDate() == 25 && date.getMonth() == 11) || 
    (date.getDate() == today.getDate() && date.getMonth() == today.getMonth() && 
    date.getFullYear() == today.getFullYear() && today.getHours() >= 18) || isAvailableDate == false)
    { 
      return [false, ''];    
    } 
    else 
    {
      return [true, ''];
    }
  }

  $('.js-datepicker').prop('readonly', true);
  $.datepicker.setDefaults($.datepicker.regional["fr"]);
  $(".js-datepicker").datepicker({
    minDate : 0,
    beforeShowDay : noTuesdayOrHolidaysOrTooLate
  })
});

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
    if ($('#booking_numberOfTickets').val() <= 0)
    {
      $("#booking_tickets").parent().hide();
      $("#booking_save").parent().hide();
    }
    else if ($('#booking_numberOfTickets').val() < 15)
    { 
      if($('#totalprice').length == 0 && $('#grouprate').length == 0)
      {
		    $("#booking_tickets").parent().show();
		    $("#booking_save").parent().show();
        $('#booking_save').before('<div><p id="totalprice">Prix total à régler : 0€</p></div>');
      }
      else
      {
        $("#booking_tickets").parent().show();
        $("#booking_save").parent().show();
        $('#grouprate').remove();
      }
    }
    else if ($('#grouprate').length == 0)
    {
      $("#booking_tickets").parent().hide();
      $("#booking_save").parent().hide();
      $('#booking_numberOfTickets').after('<div id="grouprate"><p>Il n\'est <strong>pas possible de réserver sur ce site au-delà de 14 tickets</strong>.</p><p>Veuillez <strong>contacter l\'équipe du musée</strong> pour réserver et avoir des renseignements à propos de <strong>notre tarif groupe</strong>.</p></div>');
    }
	})

//Afficher seulement "Billet demi-journée" si le jour même est sélectionné, une fois midi passé
  var today = new Date();
  function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('-');
  }

  var todayDate = formatDate(today);
  
  $('#booking_visitDay').change(function() 
  {
    var selectedDate = $("#booking_visitDay_date").val();
    if ((selectedDate == todayDate) && (today.getHours() >= 12))
    {
      $("#booking_ticketType .radio:nth-child(1)").hide();
    }
    else
    { 
      $("#booking_ticketType .radio:nth-child(1)").show();
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

// Calcul du prix total
  function computeAge(i) 
  {
    var todaysDate = new Date();
    var birthD = $("#booking_tickets_"+ i +"_birthdate_day").val();
    var birthM = $("#booking_tickets_"+ i +"_birthdate_month").val();
    var birthY = $("#booking_tickets_"+ i +"_birthdate_year").val();

    if((birthM < todaysDate.getMonth()) || ((birthM == todaysDate.getMonth()) && (birthD <= todaysDate.getDate())))
    {
      var age = todaysDate.getFullYear() - birthY;
    }
    else
    {
      var age = todaysDate.getFullYear() - birthY - 1;
    } 

    return age;
  }

  function computePrice(i)
  {
   var age = computeAge(i);

    if ($('#booking_tickets_'+ i +'_reducedRate').is(':checked'))
    {
      price = 10;
    }
    else
    {
      if(age >= 60)
      {
        var price = 12;
      }
      else if(age >= 12)
      {
        var price = 16;
      }
      else if(age >= 4)
      {
        var price = 8;
      }
      else if(age > 0 && age < 4)
      {
        var price = 0;
      }
    }

    return price;
  }

  function computeTotalPrice()
  {
    var numberOfTickets = $('#booking_numberOfTickets').val();
    var totalPrice = 0;
    for (i = 0; i < numberOfTickets; i++)
    {
      var price = computePrice(i);
      totalPrice += price;
    }
    return totalPrice;
  }

  $('#booking_tickets').click(function() 
  {
    var totalPrice =  computeTotalPrice();
    $('#totalprice').text('Prix total à régler : ' + totalPrice + '€');
  })
});
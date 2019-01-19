
$(document).ready(function() {
	$('.openBox').on('click', function() {
		$('.windows-box').show();
	})

    $('a[data-removeAdvisore]').on('click', function() { 
        var idAdvisor = $(this).attr('data-removeAdvisore');
        $('form').attr('action', '/advisor/delete/'+idAdvisor);               
    });

    $('a[data-removeCustomer]').on('click', function() { 
        var idCustomer = $(this).attr('data-removeCustomer');
        $('form').attr('action', '/customer/delete/'+idCustomer);               
    });

    $('a[data-removeUser]').on('click', function() { 
        var idUser = $(this).attr('data-removeUser');
        $('form').attr('action', '/user/delete/'+idUser);               
    });
});


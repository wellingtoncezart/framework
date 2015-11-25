$(document).ready(function(){
	$('.statusSelect').each(function(index, el) {
		if($('option:selected',this).hasClass('active'))
			$(this).removeClass('inactive').addClass('active');
		else
			$(this).removeClass('active').addClass('inactive');
	});
	$('.statusSelect').change(function(event) {
		if($('option:selected',this).hasClass('active'))
			$(this).removeClass('inactive').addClass('active');
		else
			$(this).removeClass('active').addClass('inactive');
	});
    


    $(window).load(function() {
        $('#loadTable').hide();
        $('.dataTable').fadeIn();
    });
    if($(this).width() <= '765')
        responsiveTable();
    $(window).resize(function() {
        //console.log($(this).width())
        if($(this).width() <= '765')
            responsiveTable();
        else
            responsiveTableRemove()
    });


    function responsiveTable(){
        var th = Array();
        $('.rwd-table thead th').each(function(){
            th.push($(this).html())
        });

        //console.log(th);
        var i = 0;
        $('.rwd-table tbody td').each(function(a,b){
            if(!$('div',$(this)).hasClass('dataTables-th')){
                $(this).prepend('<div class="dataTables-th">'+th[i]+'</div>');
                i++;
                if(i == th.length)
                    i=0;
            }
        });
    }
    function responsiveTableRemove(){
        $('.rwd-table tbody td .dataTables-th').remove()
    }
});

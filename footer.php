<!-- jQuery -->
<script src="js/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ mode : "specific_textareas", editor_selector : "mceEditor" });</script>
<script>
var base_url = "http://srv.tiepvb.com/";
$(document).ready(function(){
    $("#addnew").click(function(){
    	console.log(1);
        $("#addnewep").clone().insertAfter("#addnewep");
    });

    $("#delete_video").click(function () {
	    $("#addnewep").closest("#addnewep").remove();
	});

    $("#dvdname").autocomplete({
		source: base_url+"ajaxnotes.php",
		focus: function(event, ui) {
			event.preventDefault();
			console.log(ui);
			$(this).val(ui.item.label);
		},
		select: function(event, ui) {
			event.preventDefault();
			$(this).val(ui.item.label);
			$("#dvd").val(ui.item.value);
		}
	});

    $(".deleted_ep").click(function(){
    	var id = $(this).attr("data-id");
    	if (confirm("You wanna delete?")){
	    	$.ajax({
	            url: base_url+"ajaxnotes.php",
	            type: "POST",
	            data: {
	                epdelete: id
	            }
	        }).done(function(t) {
	        	if(t){
	        		location.reload();
	        	}else{
	        		alert('Sr, Cant delete episode.')
	        	}
	            
	        }).fail(function(t) {
	            alert("Error, pls click again!")
	        })
	    }
    });

	$(".deleted_player").click(function(){
    	var id = $(this).attr("data-id");
    	if (confirm("You wanna delete?")){
	    	$.ajax({
	            url: base_url+"ajaxnotes.php",
	            type: "POST",
	            data: {
	                playerdelete: id
	            }
	        }).done(function(t) {
	        	if(t){
	        		location.reload();
	        	}else{
	        		alert('Sr, Cant delete player.')
	        	}
	            
	        }).fail(function(t) {
	            alert("Error, pls click again!")
	        })
	    }
    });

    $(".deleted_slider").click(function(){
    	var id = $(this).attr("data-id");
    	if (confirm("You wanna delete?")){
	    	$.ajax({
	            url: base_url+"ajaxnotes.php",
	            type: "POST",
	            data: {
	                sdelete: id
	            }
	        }).done(function(t) {
	        	if(t){
	        		location.reload();
	        	}else{
	        		alert('Sr, Cant delete player.')
	        	}
	            
	        }).fail(function(t) {
	            alert("Error, pls click again!")
	        })
	    }
    });

    $('.submitag').click(function(){
		if($('#tagdvd').val() == ''){alert('Please add tags');}
		else{
			$.ajax({
	    		type: "POST",
	    		url: base_url+"ajaxnotes.php",
	    		cache: false,
	    		data: { tagdvd: $('#tagdvd').val()},
	    		success: function(data){
	    			data = jQuery.parseJSON(data);
	    			if(data['success'] == false){
		    			alert(data['msg']);
	    			}else{
	    				$('#tagselect').append(data['msg']);
	    			}
	    		}
	    	})
		}
	});

	$('.submitactor').click(function(){
		if($('#actor').val() == ''){alert('Please add actor');}
		else{
			$.ajax({
	    		type: "POST",
	    		url: base_url+"ajaxnotes.php",
	    		cache: false,
	    		data: { actor: $('#actor').val()},
	    		success: function(data){
	    			data = jQuery.parseJSON(data);
	    			if(data['success'] == false){
		    			alert(data['msg']);
	    			}else{
	    				$('#actorselect').append(data['msg']);
	    			}
	    		}
	    	})
		}
	});
});
</script>
</body>

</html>
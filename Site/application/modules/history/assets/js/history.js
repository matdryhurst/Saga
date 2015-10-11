
                    $('#createdon').datetimepicker({dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});
                    $('#modifiedon').datetimepicker({dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});
                    //editedembed modal dialog box
                    var initiatedURL;
                    $(document).ready(function(){
                    	$( ".editrecord" ).click(function() {
                    	  event.preventDefault();
                    	  initiatedURL= $(this).attr('href');
                    	  $("#myModal").modal('show');
						  //alert( "Handler for .click() called." );

						});
						$('#modalsave').click(function(){
							window.location.href = initiatedURL;
						});
						// 
					});

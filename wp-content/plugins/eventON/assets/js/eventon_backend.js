/*
	eventON backend scripts
*/
jQuery(document).ready(function($){
	
	
	//yes no buttons in event edit page
	$('#evcal_settings').on('click','.evcal_yn_btn',function(){
		// yes
		if($(this).hasClass('btn_at_no')){
			$(this).removeClass('btn_at_no');
			$(this).siblings('input').val('yes');
			
			$('#'+$(this).attr('afterstatement')).show();
			
		}else{//no
			$(this).addClass('btn_at_no');
			$(this).siblings('input').val('no');
			
			$('#'+$(this).attr('afterstatement')).hide();
		}
		
	});
	
	
	// language tab
	$('.eventon_cl_input').focus(function(){
		$(this).parent().addClass('onfocus');
	});
	$('.eventon_cl_input').blur(function(){
		$(this).parent().removeClass('onfocus');
	});
	
	// change language
	$('#evo_lang_selection').change(function(){
		var val = $(this).val();
		var url = $(this).attr('url');
		window.location.replace(url+'?page=eventon&tab=evcal_2&lang='+val);
	});
	
	// toggeling
	$('.evo_settings_toghead').on('click',function(){
		$(this).next('.evo_settings_togbox').toggle();
		$(this).toggleClass('open');
	});

	// export language
		$('body').on('click','#evo_lang_export', function(){
			string = {};
			var tmpArr = [];
  			var tmpStr = '';
			var csvData = [];

			$('#evcal_2').find('input').each(function(){
				csvData.push( $(this).attr('name')+','+ $(this).val());
			});

			var output = csvData.join('\n');
		  	var uri = 'data:application/csv;charset=UTF-8,' + encodeURIComponent(output);
		  	//window.open(uri);
		  	$(this).attr({
		  		'download':'evo_lang_'+$('#evo_lang_selection').val()+'.csv',
		  		'href':uri,
		  		'target':'_blank'
		  	});
		});

	// import language
		$('body').on('click','#evo_lang_import',function(){
			$('#import_box').fadeIn();

			var form = document.getElementById('file-form');
			var fileSelect = document.getElementById('file-select');
			var uploadButton = document.getElementById('upload-button');
			var box = $('#import_box');
			msg = box.find('.msg');
			msg.hide();

			$('#file-form').submit(function(event) {
				  	event.preventDefault();
				  	// Update button text.
				  	
				  	msg.html('Processing.').slideDown();

				  	var data = null;
				  	var files = fileSelect.files;
				  	var file = fileSelect.files[0];

				  	//console.log(file);
				  	if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
				      	alert('The File APIs are not fully supported in this browser.');
				      	return;
				    }

				  	if(file.type!='application/vnd.ms-excel'){
				  		msg.html('Incorrect file format.');
				  	}else{
				  		var reader = new FileReader();
					  	reader.readAsText(file);
			            reader.onload = function(event) {
			                var csvData = event.target.result;

			                var allTextLines = csvData.split(/\r\n|\n/);
			                //console.log(allTextLines[0]);
			                for (var i=0; i<allTextLines.length; i++) {
			                	var data = allTextLines[i].split(',');
			                	// update new values
			                	$('#evcal_2').find("input[name='"+data[0]+"']").val(data[1]);
			                	//console.log(data[0]+'='+data[1]);
			                	msg.html('Updating language values.');   
				        	}

				        	msg.html('Language fields updated. Please save changes.');   
			            };
			            reader.onerror = function() {
			            	msg.html('Unable to read file.');
			            };
				  	}
			});
		});
		$('body').on('click','#import_box #close',function(){
			$('#import_box').fadeOut();
		});
		

		function processData(allText) {
		    var allTextLines = allText.split(/\r\n|\n/);
		    var headers = allTextLines[0].split(',');
		    var lines = [];

		    for (var i=1; i<allTextLines.length; i++) {
		        var data = allTextLines[i].split(',');
		        if (data.length == headers.length) {

		            var tarr = [];
		            for (var j=0; j<headers.length; j++) {
		                tarr.push(headers[j]+":"+data[j]);
		            }
		            lines.push(tarr);
		        }
		    }
		    console.log(lines);
		}

});
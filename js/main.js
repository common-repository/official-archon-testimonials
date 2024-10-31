$=jQuery.noConflict(); //allows me to use the $ instead of having to say jQuery in this file
$(document).ready(function(){
	$('#testimonial_dropdown').change(function(){
		//Change values based on the user clicking on the dropdown under the edit testimonials section 
		var idNumber = $('#testimonial_dropdown').val();
		var content = $('div[data-id="' + idNumber + '"]').find('span[data-type="content"]').text();
		var author = $('div[data-id="' + idNumber + '"]').find('span[data-type="author"]').text();
		$('input[name="testimonial_id"]').val(idNumber); //change the hidden input for the form submission
		$('#testimonial_content_edit').val(content);
		$('#testimonial_author_edit').val(author);
	});
});
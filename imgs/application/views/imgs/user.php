<style type="text/css">
.section-header-title, .left-side{
display: none;
}
</style>


<form accept-charset="utf-8" method="POST" id="img_user_empresa" enctype="multipart/form-data" >

<input type="file" name="imagen"/>
<input type='hidden' name='q' value='usuarios'>
	<br><br>
	<button type="submit">ENVIAR</button>
</form>

<hr>
<div id="mensaje"></div>
<hr>



<script>
$("#img_user_empresa").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("img_user_empresa"));
	url =  now + "index.php/api/archivo/imgs";
	$.ajax({

			url: url,
			type: "POST",
			dataType: "HTML",
			data: formData,
			cache: false,
			contentType: false,
			processData: false

	}).done(function(data){


		alert(data);
		$("#mensaje").html(data);

	}).fail(function(){
		alert("Error ");
	});
});
</script>





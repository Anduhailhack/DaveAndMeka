// JavaScript Document

$(function(){
	var file = null;
	var formData = new FormData();
	
	function co(dat){
		console.log(dat);
	}
	
	$("#add-img-btn").click(()=>{$("#post-file").click()});
	$("#post-btn").click(postBtn);
	
	var image = $("#add-img");
	var post_file = $("#post-file");
	post_file.change(postFile);
	
	function postBtn(){
		var username = $("#username").val();
		var captionTxt = $("#create-post-caption").val();
		formData.append("posted_by", username);
		formData.append("caption", captionTxt);
		if (file == null)
		{
			alert("You must select a picture");
		}
		$.ajax({
			url: "post_memories.php",
			type: "post",
			data: formData,
			processData: false,
			contentType: false,
			before: ()=>{
				alert("hi");
			},
			success: (response)=>{
				if (response != 0){
					if (response == "error")
						alert("Error happend, your post has never been uploaded!");
					else {
						image.attr("src", "");
						$("#create-post-caption").val("");
						window.location.reload();
					}		
				}else{
					alert("Error happend, your post has never been uploaded!");	
				}
			}
		});
	}
	
	function postFile(event){
		file = event.currentTarget.files[0];
		
		if (file)
		{
			formData.append("file", file);
			let reader = new FileReader();
			reader.onload = (event)=>{
				image.attr("src", event.target.result);
			}
				
			reader.readAsDataURL(file);
		}
	}
});
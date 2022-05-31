// JavaScript Document
$(document).ready(()=>{
	/*POST CONTAINER AND POST ELEMENTS SELECTED */
	var main_wrapper = $(".main-wrapper");
	//var post = $(".posts");
	
	/*NECESSARY VARIABLES*/
	var post_data = null; //json data returned from ajax call
	const LIMIT = 2;
	
	$(function() {
		$( "#Tabs" ).tabs({
//			show : {
//				effect: "fadeIn", duration:800
//			},
			activate : (ev, ui)=>{
				if (ui.newTab.context.id == 'home-btn'){
					window.location.reload();
				}
			}
		}); 
	});
	
	$(function() {
		$( "#menu-wrapper" ).tabs({
			activate : (ev, ui)=>{
				if (ui.newTab.context.id == 'previous-post-tab-btn'){	
				}
			}
		}); 
	});
	
	$.ajax({
		type: "GET",
		url: "memories.php",
		dataType: "json",
		data: null,
		success:(data)=>{
			setTimeout(()=>{
				if (typeof data.error !== 'undefined')
				{
					document.getElementsByClassName("load-more")[0].innerText = "No memory was created!";
				}
				post_data = data;
				populatePosts();
				loadMore(populatePosts);
			}, 1000);
		}
	});
	
	var username = $("#username").val();
		
	$.ajax({
		type: "GET",
		url: "previous_memories.php",
		dataType: "json",
		data: {username: username},
		success:(data)=>{
			setTimeout(()=>{
				if (typeof data.error !== 'undefined')
				{
					document.getElementsByClassName("load-more")[1].innerText = "No memory was created!";
				}
				var previous_data = data;
				populatePreviousPosts(previous_data);
				loadMorePreviousPosts(populatePreviousPosts, previous_data);
			}, 1000);
		}
	});
	
	function createPostElements(post_object)
	{
//		if(typeof post_object === 'undefined')
//			return;
		var post_txt = (typeof post_object.caption !== 'undefined') ? post_object.caption : "" ;
		var post_image = (typeof post_object.photo !== 'undefined') ? post_object.photo : "" ;
		var post_id = (typeof post_object.id !== 'undefined') ? post_object.id : "" ;
		var posted_by = (typeof post_object.posted_by !== 'undefined') ? post_object.posted_by : "" ;
		
		var post = $("<div class='posts'></div>");
		var post_caption = $("<div class='post-caption'>" + post_txt + "</div>");
		
		var img_container = $("<div></div>");
		var post_img = $("<img class='post-img' src='" + post_image + "'>");
		img_container.append(post_img);
		
//		var post_like_btn = $("<button id='like' class='post-action-btn'><li class='material-icons'>favorite</li></button>");
//		var post_comment_btn = $("<button id='comment' class='post-action-btn'><li class='material-icons'>comment</li></button>");
//		var post_share_btn = $("<button id='share' class='post-action-btn'><li class='material-icons'>share</li></button>");
//		var post_actions = $("<div class='post-actions'></div>")
//		post_actions.append(post_like_btn, post_comment_btn, post_share_btn);
//		
		post.append(post_caption, img_container);
		return post;
	}
	
	function c(da)
	{
		console.log(da);
	}
	
	function populatePosts()
	{
		var post_data_counter = 1;
		
		if (post_data.length == 0){
			document.getElementsByClassName("load-more")[0].style = "visibility: hidden;";
		}
		
		for (var i = 0; i < post_data.length; i++)
		{
			if (post_data_counter >= LIMIT){ loadMore(populatePosts); return;}
			if (post_data != null)
			{
				var post_object = post_data.pop();
				var post = createPostElements(post_object);
				main_wrapper.append(post);
			}
			
			post_data_counter++;
		}
	}
	
	function populatePreviousPosts(previous_data)
	{
		var post_data_counter = 0;
		var previous_post_container = $(".previous-post-container");
		if (typeof previous_data === 'undefined' || previous_data.length == 0){
			document.getElementsByClassName("load-more")[1].style = "visibility: hidden;";
		}
		
		if (previous_data != null){
			for (var i = 0; i < previous_data.length; i++)
			{
				if (post_data_counter >= LIMIT){ loadMorePreviousPosts(populatePreviousPosts, previous_data); return;}
				var post_object = previous_data.pop();
				
				var post_txt = (typeof post_object.caption !== 'undefined') ? post_object.caption : "" ;
				var post_image = (typeof post_object.photo !== 'undefined') ? post_object.photo : null ;
				var post_id = (typeof post_object.id !== 'undefined') ? post_object.id : null ;
				var posted_by  = (typeof post_object.posted_by !== 'undefined') ? post_object.posted_by : null ;
				
				if (post_image == null || post_id == null || posted_by == null)
					return;
				
				var post = $("<div id='post_id-" + post_id + "' class='posts'></div>");
				var post_caption = $("<div id='post_id-" + post_id + "-caption' class='post-caption'>" + post_txt + "</div>");

				var img_container = $("<div></div>");
				var post_img = $("<img class='post-img' src='" + post_image + "'>");
				
				var post_actions = $("<div class='post-actions'></div>");
				var edit_btn = $("<button post_id='" + post_id + "' posted_by='" + posted_by + "' class='btn'>Edit Post</button>");
				edit_btn.click(postAction);
				var delete_btn = $("<button post_id='" + post_id + "' posted_by='" + posted_by + "' class='btn'>Delete Post</button>");  
				delete_btn.click(postAction);
				post_actions.append(edit_btn, delete_btn);
				
				
				img_container.append(post_img);
				post.append(post_caption, img_container, post_actions);
				previous_post_container.append(post);
				post_data_counter++;
			}
		}
			
	}
	
	function postAction(event)
	{
		$(".dialog").dialog().remove();

		if (event.target != null)
		{
			if (event.target.innerHTML.indexOf("Edit") === 0){
				var post = $("#post_id-" + event.target.getAttribute("post_id") + "-caption");
				var dialog = $("<div class='dialog'></div>");
				var cap = $("<div id='edited-post_id-" + event.target.getAttribute("post_id") + "' contenteditable='true' id='dialog-cap'>" + post.text() + "</div>");
				var postEdited = $("<button class='btn'>Submit</button>");

				postEdited.click(()=>{
					var editedTxt = $("#edited-post_id-" + event.target.getAttribute("post_id"));
					if (editedTxt.text() == post.text())
					{
						$(".dialog").dialog().remove();
					}else{
						var postForm = new FormData();
						postForm.append("posted_by", event.target.getAttribute("posted_by"));
						postForm.append("post_id", event.target.getAttribute("post_id"));
						postForm.append("caption", editedTxt.text());
						$.ajax({
							type: "post",
							url: "update_memories.php",
							processData: false,
							contentType: false,
							data: postForm,
							success: (response)=>{
								$(".dialog").dialog().remove();
								window.location.reload();
							}
						});
					}
				});

				dialog.append(cap, postEdited);
				dialog.dialog();
			}else if (event.target.innerHTML.indexOf("Delete") === 0){
				var dialog = $("<div class='dialog'></div>");
				var cap = $("<div>Are you sure, you want to delete this memorie? </div>");
				var deletePost = $("<button class='btn'>Yes</button>");
				var deleteForm = new FormData();
				deleteForm.append("posted_by", event.target.getAttribute("posted_by"));
				deleteForm.append("post_id", event.target.getAttribute("post_id"));
				deletePost.click(()=>{
					$.ajax({
						type: "post",
						url: "delete_memories.php",
						data: deleteForm,
						processData: false,
						contentType: false,
						success: (response)=>{
							$(".dialog").dialog().remove();
							window.location.reload();
						}
					});
				});

				dialog.append(cap, deletePost);
				dialog.dialog();
			}
		}
	}
	
	function loadMore(callMe)
	{
		var observer = new IntersectionObserver((entries)=>{
		if (entries[0].isIntersecting === true)
			callMe();
		}, {threshold: [1]});

		observer.observe(document.getElementsByClassName("load-more")[0]);
	}
	
	function loadMorePreviousPosts(callMe, previous_data)
	{
		var observer = new IntersectionObserver((entries)=>{
		if (entries[0].isIntersecting === true)
			callMe(previous_data);
		}, {threshold: [1]});

		observer.observe(document.getElementsByClassName("load-more")[1]);
	}
	
});


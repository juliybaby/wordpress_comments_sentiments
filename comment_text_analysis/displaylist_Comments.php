<?php 

global $wpdb;
$tablename = $wpdb->prefix."comment_sentiments_analytics";



?>



<style>
.comments_2021_css{
background:#1974D2;
color:white;
padding:4px;
text-align:center;
border-radius:20%;
cursor:pointer;
width:100%;
border:none

}
.comments_2021_css:hover{
background:orange;
color:black;
}



.comments2021_css{
background: red;
color:white;
padding:4px;
text-align:center;
border-radius:20%;
cursor:pointer;
width:100%;
border:none;
}


.comments2021_css:hover{
background:orange;
color:black;

}

</style>

<div class="delete_text_typingdna2020_css">
<center><h1>Comments Sentimental Text Analysis for Wordpress Users<br><br>Powered by Expert.AI</h1></center>



<?php

// load bootstrap files for modal pop up display
$plugin_url_t = plugin_dir_url( __FILE__ );
$b_js_file ='bootstrap.min.js';
$b_css_file ='bootstrap.min.css';
$b_jq_file ='jquery.min.js';
$comments_file ='comments_analyzed.php';

$wp_home =home_url();


$url_bjs_file= $plugin_url_t.$b_js_file;
$url_bcss_file= $plugin_url_t.$b_css_file;
$url_jq_file= $plugin_url_t.$b_jq_file;

$image_url1 ='img/loader.gif';
$plugin_image_url1= $plugin_url_t.$image_url1;

$url_comments_file= $plugin_url_t.$comments_file;

?>
<link rel="stylesheet" href="<?php echo $url_bcss_file; ?>">
<script src="<?php echo $url_bjs_file; ?>" type="text/javascript"></script>
<script src="<?php echo $url_jq_file; ?>" type="text/javascript"></script>


<table width='100%' border='1' style='border-collapse: collapse;'>
	<tr>
		<th>S.no</th>
		<th>Name</th>
		<th>Email</th>
		<th>Comments</th>
                <th>Date</th>
                <th>Degree of <br>Sentiments<br>Positivity</th>
		<th>Degree of <br>Sentiments<br>Negativity</th>
                <th>Overall<br>Sentiments</th>
                <th>Comments Sentiments</th>
<th>Comments Emotions</th>
<th>Actions</th>
<th>View Posts</th>
	</tr>
	<?php
	// Select records
	$rec_List = $wpdb->get_results("SELECT * FROM ".$tablename." order by id desc");
	if(count($rec_List) > 0){
		$count = 1;
		foreach($rec_List as $entry){
		    $id = $entry->id;
		    $author_name = $entry->author_name;
		    $author_email = $entry->author_email;
		    $comment_content = $entry->comment_content;
                    $comment_date  = $entry->comment_date ;
                    $timing = $entry->timing;
$positivity = $entry->positivity;
$negativity = $entry->negativity;
$overall = $entry->overall;
$emotion_img = $entry->emotion_img;
$emotion = $entry->emotion;
if($emotion =='Positive'){
$emotion_style ="<div style='background:green;color:white;padding:6px;border:none;;border-radius:10%;'>Positive Comments</div>";
}
if($emotion =='Negative'){
$emotion_style ="<div style='background:purple;color:white;padding:6px;border:none;border-radius:10%;'>Negative Comments</div>";
}

if($emotion =='Neutral'){
$emotion_style ="<div style='background:orange;color:black;padding:6px;border:none;;border-radius:10%;'>Neutral Comments</div>";
}

$pic='.png';
$comment_post_ID = $entry->comment_post_ID;
		    echo "<tr>
		    	<td>".$count."</td>
		    	<td>".$author_name."</td>
		    	<td>".$author_email."</td>
		    	<td>".$comment_content."</td>
                        <td>".$comment_date ."</td>
                        <td>".$positivity." %</td>
<td>".$negativity." %</td>
<td>".$overall." %</td>
<td>".$emotion_style." </td>
<td>".$emotion_img." <br><img src=$plugin_url_t/emotion_img/".$emotion_img."".$pic."></td>
		    	<td><p>

<p>
<button data-toggle='modal' data-target='#myModal_action_sentiments' title='Run Full Details Comments Sentimental Text-Analysis' data-id='".$id."' data-comments='".$comment_content."' class='btn_action_comments comments_analysis_btn comments_2021_css'><span style='font-size:20px;color:black;' class='fa fa-plus-globe'></span>Run Full Details Comments Sentimental Text-Analysis</button></p></td>
</p>

<td><a href=$wp_home/wp-admin/post.php?post=".$comment_post_ID."&action=edit>View Posts</a></td>
 


		    </tr>
		    ";
		    $count++;
		}
	}else{
		echo "<tr><td colspan='5'  class='comments2021_css'>No Comments is available for SentimentalText-Analytics..</td></tr>";
	}
	

	?>
</table>
</div>











<!-- sentiments Modal starts here-->

<div class="container_action">

  <div class="modal fade " id="myModal_action_sentiments" role="dialog">
    <div class="modal-dialog modal-lg modal-appear-center1 modal_mobile_resize modaling_sizing">
      <div class="modal-content">
        <div class="modal-header" style='color:black;background:#ddd;'}}>
 <button type="button" class="pull-right btn btn-default modal_close_btn" data-dismiss="modal">Close</button>

          <h4 class="modal-title">Comments Full Details Sentimental Analysis</h4>
        </div>
        <div class="modal-body">
     




<script>


// clear Modal div content on modal closef closed
$(document).ready(function(){
$('.modal_close_btn').click(function(){
//alert('Modal Closed');
   $('.myform_sentiments').empty();  
 console.log("modal closed and content cleared");
//alert('closed');
 });
});




$(document).ready(function(){
$('#sentiment_btn').click(function(){
		
var comments = $('.comments1').val();
var wp_plugin_url= '<?php echo $plugin_url_t; ?>';
//alert(comments);

//hide marquee
$('.hide_marquee').hide();

//alert(feedback);

if(comments==""){
alert('There is a Problem with comments being Analyzed..Reload the Page and Try Again.');

}


else{

$('#loader_sentiment').fadeIn(400).html('<br><div style="color:white;background:#3b5998;padding:10px;"><img src="<?php echo $plugin_image_url1; ?>">&nbsp;Please Wait,Comments is being Analyzed Sentimentally in details...</div>');
var datasend = {comments:comments, wp_plugin_url:wp_plugin_url};	
		$.ajax({
			
			type:'POST',
			url:'<?php echo $url_comments_file; ?>',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_sentiment').hide();
				//$('#result_sentiment').fadeIn('slow').prepend(msg);
$('#result_sentiment').html(msg);

			
			}
			
		});
		
		}
		
	})
					
});




</script>



<!-- form starts  -->



<h4>Comments Id:  (<span id="comment_id"></span>)</h4>
<b>Users Comments: </b> <span id="comments"></span>



<!-- s start-->

<div style='background:#f1f1f1; padding:16px;color:black'>

<input type="hidden" name="comments1" id="comments1" class="comments1" value="">

            </div>

<style>

.mystyle_css{
background:purple;color:white;padding:10px;border:none
}


.mystyle_css:hover{
background:#800000;color:white;
}

</style>



<div class="form-group">
<div id="loader_sentiment"></div>

<div id="result_sentiment" class="myform_sentiments"></div>
<br />

<marquee><span class='hide_marquee' style='color:black;font-family:comic sans ms'>Click button below to Run Full Users Commments Statistical Sentimental Analysis </span></marquee><br><br>
                    
<button type="button" id="sentiment_btn" class="mystyle_css" title='Run Full Comments Sentimental Analysis'>Run Full Comments Sentimental Analysis</button>
</div>



</div>



<!-- s ends  -->







<!-- form ends  -->





<br /><br />
<br /><br />
<br /><br />
</div>



        </div>
        <div class="modal-footer modal_footer_color" style='color:black;background:#ddd'>
          <button type="button" class="btn btn-default modal_close_btn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



<!-- sentiments Modal ends here  -->


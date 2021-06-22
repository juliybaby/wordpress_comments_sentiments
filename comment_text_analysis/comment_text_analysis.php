<?php
 /*
 
   Plugin Name: Comments Text Analytics Plugin
   Plugin URI: http://qbtut.com
   description: Comments Sentimental Text Analytics for Wordpress
   Version: 1.0.0
   Author: Esedo Fredrick Chijioke
   Author URI: https://qbtutu.com/
 */


//https://developer.wordpress.org/reference/functions/wp_insert_comment/
//https://developer.wordpress.org/reference/hooks/wp_insert_comment/
//https://developer.wordpress.org/reference/hooks/preprocess_comment/


// Create a new table
function comment_analytics_table(){


	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	$tablename = $wpdb->prefix."comment_sentiments_analytics";
	$sql = "CREATE TABLE $tablename (
	  id mediumint(11) NOT NULL AUTO_INCREMENT,
	  author_name varchar(80) NOT NULL,
	  author_email varchar(80) NOT NULL,
	  comment_content text,
          comment_parent text,
          comment_date  varchar(80) NOT NULL,
          comment_post_ID  varchar(80) NOT NULL, 
          comment_author_url text,
          timing varchar(80) NOT NULL,
          overall varchar(80) NOT NULL,
          positivity varchar(80) NOT NULL,
          negativity varchar(80) NOT NULL,
          emotion_img varchar(80) NOT NULL,
          emotion varchar(80) NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
        dbDelta( $sql1 );
}
register_activation_hook( __FILE__, 'comment_analytics_table' );

// Add menu
function comment_analytics_menu() {

    add_menu_page("Comments Sentimental Analytics Plugin", "Comments Sentimental Analytics Plugin","manage_options", "myplugin", "displayList_Comments",plugins_url('/comment_text_analysis/img/icon.png'));
    add_submenu_page("myplugin","View Users Comments Sentiments", "View Users Comments Sentiments","manage_options", "allentries", "displayList_Comments");
   	
}

add_action("admin_menu", "comment_analytics_menu");


add_filter( 'preprocess_comment' , 'preprocess_comment_sentiments' );
 

function preprocess_comment_sentiments( $commentdata ) {
   // Always remove the URL from the comment author's comment
   //unset( $commentdata['comment_author_url'] );
 

global $wpdb;
    $data = wp_unslash( $commentdata );
    $comment_author       = ! isset( $data['comment_author'] ) ? '' : $data['comment_author'];
    $comment_author_email = ! isset( $data['comment_author_email'] ) ? '' : $data['comment_author_email'];
    $comment_author_url   = ! isset( $data['comment_author_url'] ) ? '' : $data['comment_author_url'];
    $comment_author_IP    = ! isset( $data['comment_author_IP'] ) ? '' : $data['comment_author_IP'];
 
    $comment_date     = ! isset( $data['comment_date'] ) ? current_time( 'mysql' ) : $data['comment_date'];
    $comment_date_gmt = ! isset( $data['comment_date_gmt'] ) ? get_gmt_from_date( $comment_date ) : $data['comment_date_gmt'];
 
    $comment_post_ID  = ! isset( $data['comment_post_ID'] ) ? 0 : $data['comment_post_ID'];
    $comment_content  = ! isset( $data['comment_content'] ) ? '' : $data['comment_content'];
    $comment_karma    = ! isset( $data['comment_karma'] ) ? 0 : $data['comment_karma'];
    $comment_approved = ! isset( $data['comment_approved'] ) ? 1 : $data['comment_approved'];
    $comment_agent    = ! isset( $data['comment_agent'] ) ? '' : $data['comment_agent'];
    $comment_type     = empty( $data['comment_type'] ) ? 'comment' : $data['comment_type'];
    $comment_parent   = ! isset( $data['comment_parent'] ) ? 0 : $data['comment_parent'];
 
$timing = time();

// Make API Call to ExpertAI Sentimental Analysis

$url = 'https://developer.expert.ai/oauth2/token';
$ch = curl_init($url);


$uname ="Your-api-email goes here";
$upass  ="api password goes here";
$data = array(
    'username' => $uname,
    'password' => $upass
);
$payload = json_encode(array($data));
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$access_token = $result;

//$text_post='Michael Jordan was one of the best basketball players of all time. Scoring was Jordan stand-out skill,but he still holds a defensive NBA record, with eight steals in a half';
//$text_post= 'Hello Site Admin, I am happy with the product that I purchased being delayed in delivery. I need it asap.';

$text_post= $comment_content;

$url1 = 'https://nlapi.expert.ai/v2/analyze/standard/en/sentiment';
$ch1 = curl_init($url1);
$data1 = array(
    'text' => $text_post
);
$payload1 = json_encode(array("document" => $data1));
curl_setopt($ch1, CURLOPT_POSTFIELDS, $payload1);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array("Authorization: Bearer $access_token", 'Content-Type:application/json'));
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch1);
$http_status = curl_getinfo($ch1, CURLINFO_HTTP_CODE);

// catch error message before closing
if (curl_errno($ch1)) {
   // echo $error_msg = curl_error($ch1);
}

curl_close($ch1);

if($http_status==200){

//echo 21;
echo "<div style='background:green;color:white;padding:10px;border:none;'>Comment Successfully Analyzed..</div>";
}
else {
echo "<div style='background:red;color:white;padding:10px;border:none;'>There is a Problem connecting to ExpertAI API. Please Ensure there is internet Conections</div>";
//echo 22;
exit();

}   


$json = json_decode($output, true);

$resArr = [];
$keys = ['lemma', 'sentiment', 'overall', 'negativity', 'positivity'];



array_walk_recursive($json, function($value, $key) use(&$keys, &$resArr) {
    
    if(in_array($key, $keys)){
        $resArr[$key][] = $value;
    }
    
});




$overall = implode(", ", $resArr['overall']);
$negativity = implode(", ", $resArr['negativity']);
$positivity = implode(", ", $resArr['positivity']);

if($positivity == 0){

$img_emotion ='sad.png';
$emotion1= 'sad';
$emotion2= 'Negative';
}else{
$img_emotion ='happy.png';
$emotion1= 'happy';
$emotion2= 'Positive';
}



$user_id = ! isset( $data['user_id'] ) ? 0 : $data['user_id'];
 

//table name
$tablename = $wpdb->prefix."comment_sentiments_analytics";


//insert data using Wordpress Prepared Statement to protect data against SQL Injection 
$sql = $wpdb->prepare("INSERT INTO `$tablename` (`author_name`,`author_email`,`comment_content`,`comment_parent`,`comment_date`,`comment_post_ID`,`comment_author_url`,`timing`,`overall`,`positivity`,`negativity`,`emotion_img`,`emotion`) values (%s, %s, %s,%s, %s, %s,%s, %s, %s,%s, %s, %s, %s)", $comment_author, $comment_author_email, $comment_content, $comment_author_parent,$comment_date,$comment_post_ID,$comment_author_url,$timing,$overall,$positivity,$negativity,$emotion1,$emotion2);
$sql_res2 = $wpdb->query($sql);

 // get last inserted id for comments
$id = (int) $wpdb->insert_id;

//echo "this userid: $user_id . This is commentid: $id";


   return $commentdata;
}





function displayList_Comments(){
	include "displaylist_Comments.php";
}



// Initialize your wordpress ajax
add_action( 'admin_footer', 'my_action_javascript_comments_sentiments' );
function my_action_javascript_comments_sentiments() { ?>


<?php
$plugin_url1 = plugin_dir_url( __FILE__ );
$img_url1 ='img/loader.gif';
$plugin_img_url1= $plugin_url1.$img_url1;


?>




<style>
.loader_css{

background: purple;
color:white;
padding:10px;
text-align:center;
border-radius:20%;
width:30%;


}


.loader_css_delete{

background: purple;
color:white;
padding:6px;
text-align:center;
border-radius:20%;
max-width:80%;


}



</style>





	<script type="text/javascript" >
	jQuery(document).ready(function($) {




//start comments action call

//$(document).on( 'click', '.btn_action_comments', function(){ 

$('.btn_action_comments').click(function(){
var comment_id = $(this).data('id');
var comments = $(this).data('comments');

$('#comment_id').html(comment_id);
$('#comments').html(comments);


$('#comment_id1').val(comment_id).value;
$('#comments1').val(comments).value;


//alert(comment_id);
//alert(comments);
	
	
	});
//end comments action call




// start Ajax Call for Analyzing Comments sentimentally

$(".comments_analysis_btn").click(function () {
var del_id = $(this).data('id');
		var data = {
			'action': 'my_action_comment_process',
			'nounce': 12345678,
                        'del_id': del_id
                     
               
		};

$('.loader-typingdna2020-delete-settings').fadeIn(400).html('<br><div style="background:orange;color:white;padding:10px;width:40%;"><img src="<?php echo $plugin_img_url1; ?>"> &nbsp;Please Wait, Settings is being deleted..</div>');

 $.ajax({
        type: 'POST',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        data: data, 
        success: function (result) {

           //alert(result);

//settings successfully Deleted
if(result == '1'){

          $('.loader-typingdna2020-delete-settings').hide();
$('.result-typingdna2020-delete-settings').html("<div style='background:green;color:white;padding:10px;width:30%;'>Settings Successfully Deleted</div>");
setTimeout(function(){ $('.result-typingdna2020-delete-settings').html(''); }, 5000);
}else{

//settings cannot be Deleted
   $('.loader-typingdna2020-delete-settings').hide();
$('.result-typingdna2020-delete-settings').html("<div style='background:red;color:white;padding:10px;width:30%;'>Settings Cannot be Deleted</div>");
setTimeout(function(){ $('.result-typingdna2020-delete-settings').html(''); }, 5000);
       

}


        },
        error: function () {
            alert("error");
        }
    });




});


// ends Ajax Call for Analyzing Comments sentimentally








	});
	</script> 
<?php
}









// Delete Typing DNA User  starts Here

add_action( 'wp_ajax_my_action_comment_process', 'my_action_comment_process' );
function my_action_comment_process() {

/*
$delid = intval( $_POST['del_id'] );
$user_id = strip_tags( $_POST['user_id'] );


$base_url = 'https://api.typingdna.com/%s/%s?type=%s&textid=%s&device=%s';




global $wpdb; // this is how you get access to the database


//check if Admin has inserted API Keys and Secret
$tablename_settings = $wpdb->prefix."typingdnakey";

       $res_ds = $wpdb->get_results( $wpdb->prepare(
            "SELECT  FROM `$tablename_settings` "
        ));

$db_apiKey = $res_ds[0]->apikey;
$db_apiSecret = $res_ds[0]->apisecret;

//print_r($res_ds); 

        if(count($res_ds) == 0){
	        echo 9;
// echo API KEY not inserted by Admin
wp_die(); //  wordpress die to terminate immediately and display a Response
*/

}











<?php

class Instafeeds {

	
 public function __construct() 
	{
		add_action('wp_enqueue_scripts', array($this,'inpic_instagram_head'));
		add_shortcode( 'InastaPic', array($this,'inpic_instagram_func'));
	}

public function  inpic_instagram_head() {
        wp_enqueue_style( 'pl_instagram_css', plugins_url( 'instagram/css/styles.css',  dirname(__FILE__) ) );
	wp_enqueue_script( 'pl_instagram_date_js', plugins_url( 'instagram/js/date-format.js',  dirname(__FILE__) ) ); 
}



	public function GetUserID($username, $access_token) {

	
		 $urlnew = "https://api.instagram.com/v1/users/search?q=" . $username . "&access_token=" . $access_token;

		if($resultnew = json_decode($this->fetchData($urlnew), true)) {


			return $resultnew['data'][0]['id'];

		}

	}

	public function fetchData($url){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}



public function inpic_instagram_func($atts){
	
	
	extract( shortcode_atts( array(
	'feed' => '',
	'hashtag' => ''
	   ), $atts ) );
			
		


ob_start();
$feed;
$hashtag;



 $accessToken = get_option('user_acc_token');
	
if($feed && $accessToken)
	{

		$username=$feed;
		
		$instagram_id= $this->GetUserID($username, $accessToken);
	
				
		$insta_url = 'https://api.instagram.com/v1/users/'.$instagram_id.'/media/recent/?access_token='.$accessToken;
		$insta_data = json_decode(file_get_contents($insta_url));
	
		
		?>
		<div class="fts-instagram">
		<?php 	
		$set_zero = 0;
		foreach($insta_data->data as $insta_d) {
		
		
		$instagram_date =  date('F j, Y',$insta_d->created_time);
		$instagram_link = $insta_d->link;
		$instagram_thumb_url = $insta_d->images->thumbnail->url;
		$instagram_likes = $insta_d->likes->count;
		$instagram_comments = $insta_d->comments->count;
		?>
		<div class='instagram-placeholder'><a class='fts-backg' target='_blank' href='<?php print $instagram_link ?>'></a>
		  <div class='date'><?php print $instagram_date ?></div>
		  <a class='instaG-backg-link' target='_blank' href='<?php print $instagram_link ?>'>
		    <div class='instagram-image' style='background:rgba(204, 204, 204, 0.8) url(<?php print $instagram_thumb_url ?>)'></div>
		    <div class='instaG-photoshadow'></div>
		  </a>
		  <ul class='heart-comments-wrap'>
		    <li class='instagram-image-likes'><?php print $instagram_likes ?></li>
		    <li class='instagram-image-comments'><?php print $instagram_comments ?></li>
		  </ul>
		</div>
		<?php 
			 $set_zero++;
			 }	
		?>
		<div class="clear"></div>
		</div>
		
		<?php
		
	}	
		
	if($hashtag && $accessToken)
	{


	$insta_url = $this->fetchData("https://api.instagram.com/v1/tags/{$hashtag}/media/recent/?access_token={$accessToken}");
		$insta_data = json_decode($insta_url);

		?><div class="fts-instagram">
		<?php 
		$set_zero = 0;
		foreach($insta_data->data as $insta_d) {
		
		
		
			$instagram_date =  date('F j, Y',$insta_d->created_time);
			$instagram_link = $insta_d->link;
			$instagram_thumb_url = $insta_d->images->thumbnail->url;
			$instagram_likes = $insta_d->likes->count;
			$instagram_comments = $insta_d->comments->count;
			?>
				<div class='instagram-placeholder'><a class='fts-backg' target='_blank' href='<?php print $instagram_link ?>'></a>
				  <div class='date'><?php print $instagram_date ?></div>
				  <a class='instaG-backg-link' target='_blank' href='<?php print $instagram_link ?>'>
				    <div class='instagram-image' style='background:rgba(204, 204, 204, 0.8) url(<?php print $instagram_thumb_url ?>)'></div>
				    <div class='instaG-photoshadow'></div>
				  </a>
				  <ul class='heart-comments-wrap'>
				    <li class='instagram-image-likes'><?php print $instagram_likes ?></li>
				    <li class='instagram-image-comments'><?php print $instagram_comments ?></li>
				  </ul>
				</div>
				<?php 
					 $set_zero++;
					 }	
				?>
				<div class="clear"></div>
				</div>
				<?php 
	}

	
return ob_get_clean(); 	
}
}

$aobj1=new Instafeeds;
?>

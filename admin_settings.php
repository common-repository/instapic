
<h2>Instagram Authentication</h2>

<?php


$instagram = new Instagram(array(
  'apiKey'      => get_option('user_client_id'),
  'apiSecret'   => get_option('user_client_sc'),
  'apiCallback' => admin_url( 'admin.php?page=instapic/instapic.php')
));

$loginUrl = $instagram->getLoginUrl();



$user_id = get_current_user_id();
if(isset($_REQUEST['insta_admin_submit']))
{
	$incl_id=$_REQUEST['insta_client_id'];
	$incl_sc=$_REQUEST['insta_client_sc'];

	update_option('user_client_id', $incl_id);
	update_option('user_client_sc', $incl_sc);

		echo '<div id="setting-error-settings_updated" class="updated settings-error"> 
<p><strong>Settings saved.</strong></p></div>';
}
if(isset($_REQUEST['reauth']))
{
	delete_option( 'user_client_id' );
	delete_option( 'user_client_sc' );
	delete_option( 'user_acc_token' );
	$location=admin_url( 'admin.php?page=instapic/instapic.php');
	 ?>
	   <script type="text/javascript">
	    window.location= '<?php echo $location; ?>'
	    </script>
<?php
}
?>
<?php





// receive OAuth code parameter
 $code = $_GET['code'];

// check whether the user has granted access
if (isset($code) && $user_id>0) {


  // receive OAuth token object
  $data = $instagram->getOAuthToken($code);
	$data->access_token;
	update_option('user_acc_token', $data->access_token);

  // store user access token
  $instagram->setAccessToken($data);


} else {

  // check whether an error occurred
  if (isset($_GET['error'])) {
    echo 'An error occurred: ' . $_GET['error_description'];
  }

}





?>



    

<form name="fins" id="fins" action="" method="POST">
<table border="0"  class="widefat inst-auth">
	<thead>
		<tr>
		  <th class="inst-th"><strong>Instagram Settings</strong></th>
		  <th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>

		<tr>
		   <td>Client ID:</td>
		   <td><input type="text" name="insta_client_id" id="insta_client_id" value="<?php echo get_option('user_client_id');?>"></td>
		</tr>
		<tr>
		  <td>Client Secret:</td>
		  <td><input type="text" name="insta_client_sc" id="insta_client_sc" value="<?php echo get_option('user_client_sc');?>"></td>
		</tr>
		<tr><td></td><td>
			<?php 
			if(get_option('user_acc_token')){ ?>
			<a href="admin.php?page=instapic/instapic.php&reauth=1"><input type="button" Value="Reset" class="button button-primary"></a>	
			<?php } elseif(get_option('user_client_id') && get_option('user_client_sc')){ ?>
			<a href="<?php echo $loginUrl;?>"><input type="button" Value="Authenticate" class="button button-primary"></a>	
			<a href="admin.php?page=instapic/instapic.php&reauth=1"><input type="button" Value="Reset" class="button button-primary"></a>				
			<?php } else {?>
			<input type="submit" name="insta_admin_submit" Value="Submit" class="button button-primary">
			<?php } ?>	
		</td></tr>





	</tbody>
</table>
</form>



<div class="space-tab"></div>
<table border="0">
	<thead>
		<tr><td>&nbsp;</td>
		  <td><strong>How to get instagram client id and client secret:</strong></td>
		  
		</tr>
	</thead>
	<tbody>

		<tr><td>1.</td>
		   <td>Go at http://instagram.com/developer/ or <a href="http://instagram.com/developer/" target="_blank">click here</a></td>
		</tr>
		<tr><td>2.</td>
		   <td>click on "Register Your Application" button and follow step by step process.</td>
		</tr>
		<tr><td>3.</td>
		   <td>Put your api callback url as <?php echo get_option('siteurl');?>/wp-admin/admin.php?page=instapic/instapic.php</td>
		</tr>

	</tbody>
</table>



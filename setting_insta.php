<?php 
require_once 'instagram.class.php';
$cont_choice = $_REQUEST['pl_cont_choice'];
$username = $_REQUEST['pl_username'];
$hashtag = $_REQUEST['pl_hashtag'];


if($_REQUEST['hidf'])
{

	update_option('pl_cont_choice', $cont_choice);
	update_option('pl_username', $username);
	update_option('pl_hashtag', $hashtag);
	echo '<div class="updated settings-error">
        <p>'.__("Options Saved Successfully.").'</p>
        </div>';
}


?>

<?php 

$pl_cont_choice =get_option('pl_cont_choice');
$pl_username =get_option('pl_username');
$pl_hashtag =get_option('pl_hashtag');
?>

<div class="wrap">
<?php include_once('admin_settings.php');?>
     




<div class="space-tab"></div>


<form name="inf1" id="inf1" method="post" action="">
                            
                            <input type="hidden" name="hidf" id="hidf" value='1'>
                            <table class="widefat">
				<thead>
					<tr>
					  <th class="inst-th"><strong>Display Options</strong></th>
					  <th>&nbsp;</th>
					</tr>
				</thead>
					
                                <tbody>
                                    <tr valign="top">
                                        <th scope="row"><label for="choose-content">Content</label></th>
                                        <td>
                                      <input type="radio" id="pl_cont_choice" name="pl_cont_choice" value="myfeed" <?php if($pl_cont_choice=="myfeed") echo 'checked="checked"'; ?>>  My Feed&nbsp;&nbsp;
                                      <input type="radio" id="pl_cont_choice" name="pl_cont_choice" value="hashtag" <?php if($pl_cont_choice=="hashtag") echo 'checked="checked"'; ?>>  Hashtag&nbsp;&nbsp;
									  <input type="radio" id="pl_cont_choice" name="pl_cont_choice" value="both" <?php if($pl_cont_choice=="both") echo 'checked="checked"'; ?>>	Both	                                        
                                     
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="username">Username</label></th>
                                        <td><input name="pl_username" type="text" id="pl_username" value="<?php echo $pl_username;?>" class="regular-text" >&nbsp;{Your Instagram Username from which you want feed display.}</td>
                                    </tr>

                                   

                                    <tr valign="top">
                                        <th scope="row"><label for="hashtag">Hashtag</label></th>
                                        <td><input name="pl_hashtag" type="text" id="pl_hashtag" value="<?php echo $pl_hashtag;?>" class="regular-text">&nbsp;{Your Instagram Hashtag from which you want feed display.}</td>
                                    </tr>

                                      <tr valign="top">
                                        <th scope="row"><label for="sub">&nbsp;</label></th>
                                        <td><input type="submit" name="pl_submit" id="pl_submit" class="button-primary" value="Save"></td>
                                    </tr>
			
			<?php 
			//create Shortcode
			
				 if($pl_cont_choice=="myfeed")
				 {
					$makeshort_strat = "[InastaPic ";
					$makeshort_end = "]";
				 	$makeshort .="feed = ".$pl_username;
				 }
				 elseif($pl_cont_choice=="hashtag")
				 {
					$makeshort_strat = "[InastaPic ";
					$makeshort_end = "]";
				 	$makeshort .="hashtag = ".$pl_hashtag;
				 }
				 elseif($pl_cont_choice=="both")
				 {
					$makeshort_strat = "[InastaPic ";
					$makeshort_end = "]";
				 	$makeshort .="feed = ".$pl_username." hashtag = ".$pl_hashtag;
				 }	
				 else
				{	
					$makeshort_end="Please Select Some Options";
				}
			
			?>
				  <tr valign="top">
                                        <th scope="row"><label for="short">Shortcode</label></th>
                                        <td><strong><?php echo $makeshort_strat.$makeshort.$makeshort_end;?></strong></td>
                                    </tr>
			
			
                                    
                                </tbody>
                            </table>
                           </form>





</div>

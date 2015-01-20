<?php
/*
Template Name: Page - Contact
*/
?>
<?php
// Contact form processing

$name_error = '';
$email_error = '';
$subject_error = '';
$message_error = '';
if (!isset($_REQUEST['c_submitted'])) 
{
//If not isset -> set with dumy value 
$_REQUEST['c_submitted'] = ""; 
$_REQUEST['c_name'] = "";
$_REQUEST['c_email'] = "";
$_REQUEST['c_message'] = "";
}

if($_REQUEST['c_submitted']){

	//check name
	if(trim($_REQUEST['c_name'] == "")){
		//it's empty
		
		$name_error = __('You forgot to fill in your name', 'framework');
		$error = true;
	}else{
		//its ok
		$c_name = trim($_REQUEST['c_name']);
	}

	//check email
	if(trim($_REQUEST['c_email'] === "")){
		//it's empty
		$email_error = __('Your forgot to fill in your email address', 'framework');
		$error = true;
	}else if(!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_REQUEST['c_email']))){
		//it's wrong format
		$email_error = __('Wrong email format', 'framework');
		$error = true;
	}else{
		//it's ok
		$c_email = trim($_REQUEST['c_email']);
	}


	//check name
	if(trim($_REQUEST['c_message'] === "")){
		//it's empty
		$message_error = __('You forgot to fill in your message', 'framework');
		$error = true;
	}else{
		//it's ok
		$c_message = trim($_REQUEST['c_message']);
	}

	//if no errors occured
	if($error != true) {

		$email_to = of_get_option('of_mail_address');
		if (!isset($email_to) || ($email_to == '') ){
			$email_to = get_option('admin_email');
		}
		$c_subject = __('Contact from your site', 'framework');
		$message_body = "Name: $c_name \n\nEmail: $c_email \n\nComments: $c_message";
		$headers = 'From: '.get_bloginfo('name').' <'.$c_email.'>';

		wp_mail($email_to, $c_subject, $message_body, $headers);

		$email_sent = true;
	}

}

?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="container clearfix titlecontainer">
  
    <!-- Page Title
    ================================================== -->
    <div class="pagetitlewrap">
        <h3 class="pagetitle">
            <?php wp_title("",true);
            if(!wp_title("",false)) { echo bloginfo( 'title');} ?>
        </h3>
        <div class="mobileclear"></div>
        <span class="description">
          <?php if ($tagline_text = get_post_meta($post->ID, 'ag_page_desc', $single = true)) { echo '<p>' . $tagline_text . '</p>'; } ?>
        </span>
    </div>
    <div class="clear"></div>

    <!-- Page Content
      ================================================== -->
    <div class="maincontent page">
    <?php if(isset($email_sent) && $email_sent == true){ ?>
            <div class="emailsuccess">
                <h4><?php if ($sentheading = of_get_option('of_sent_heading')) { echo $sentheading; } ?></h4>
                <p><?php if ($sentdescription = of_get_option('of_sent_description')) { echo $sentdescription; } ?></p>
            </div>
        
        <?php } else { ?>
            <?php the_content(); ?>
        <?php } ?>

        <?php endwhile; else :?>
        <!-- Else nothing found -->
        <h2><?php _e('Error 404 - Not found.', 'framework'); ?></h2>
        <p><?php _e("Sorry, but you are looking for something that isn't here.", 'framework'); ?></p>
       <!--BEGIN .navigation .page-navigation -->
        <?php endif; ?>
            
     <div class="contactcontent">
        <div id="contact-form">
            <form action="<?php the_permalink(); ?>" id="contactform" method="post" class="contactsubmit">
                <div class="formrow">
                    <div class="one_half">
                        <label for="c_name">
                            <?php _e('Name', 'framework'); ?>
                        </label>
                        <input type="text" name="c_name" id="c_name" size="22" tabindex="1" class="required" />
                        <?php if($name_error != '') { ?>
                        <p><?php echo $name_error;?></p>
                        <?php } ?>
                    </div>
                    <div class="one_half column-last">
                        <label for="c_email">
                            <?php _e('Email', 'framework');?>
                        </label>
                        <input type="text" name="c_email" id="c_email" size="22" tabindex="1" class="required email" />
                        <?php if($email_error != '') { ?>
                        <p><?php echo $email_error;?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="messagerow">
                    <label for="c_message">
                        <?php _e('Message', 'framework'); ?>
                    </label>
                    <textarea name="c_message" id="c_message" cols="100%" rows="8" tabindex="3" class="required"></textarea>
                    <?php if($message_error != '') { ?>
                    <p><?php echo $message_error;?></p>
                    <?php } ?>
                </div>
                <p>
                    <label for="c_submit"></label>
                    <input type="submit" name="c_submit" id="c_submit" class="button dark" value="<?php _e('Send Message', 'framework'); ?>"/>
                </p>
                <input type="hidden" name="c_submitted" id="c_submitted" value="true" />
            </form>
            </div>
            <div class="clear"></div>
        </div>

                <div class="clear"></div>
    </div>          

    <!-- Sidebar
      ================================================== -->      
    <div class="sidebar">
        <?php  /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Contact Sidebar') ) ?>
    </div>

    <div class="clear"></div>

</div>
<?php get_footer(); ?>
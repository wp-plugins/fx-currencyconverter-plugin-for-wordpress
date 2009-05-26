<div class="wrap">
	<h2><?php echo $zplugin_info['name']; ?></h2>
    
    <div id="poststuff">
  	
    <!--Admin Page Right Column //start-->
    <div class="inner-sidebar" id="side-infomation">
		<div style="position: relative;" id="side-sortables" class="meta-box-sortables ui-sortable">
        
        <!--Information Box //start-->
        <div id="sm_pnres" class="postbox">
			<h3 class="hndle"><span>Information:</span></h3>
			<div class="inside">
                <ul>
                	<li><strong>Version:&nbsp;</strong><?php echo $zplugin_info['version']; ?></li>
                    <li><strong>Release Date:&nbsp;</strong><?php echo $zplugin_info['date']; ?></li>
                    <li><a href="<?php echo $zplugin_info['pluginhome']; ?>" target="_blank">Plugin Homepage</a></li>
                    <li><a href="<?php echo $zplugin_info['rateplugin']; ?>" target="_blank">Rate this plugin</a></li>
                    <li><a href="<?php echo $zplugin_info['support']; ?>">Support and Help</a></li>
                    <li><a href="<?php echo $zplugin_info['authorhome']; ?>" target="_blank">Author Homepage</a></li>
                    <li><a href="<?php echo $zplugin_info['more']; ?>" target="_blank">More WordPress Plugins</a></li>
                </ul>
			</div>
        </div>        
        <!--Information Box //end-->
       
        <!--Follow me on Box //start-->
        <div id="sm_pnres" class="postbox">
			<h3 class="hndle"><span>Follow me on:</span></h3>
			<div class="inside">
                <ul class="zdinfo">
                    <li class="fb"><a href="http://www.facebook.com/people/Proloy-Chakroborty/1424058392" title="Follow me on Facebook" target="_blank">Facebook</a></li>
                    <li class="ms"><a href="http://www.myspace.com/proloy" title="Follow me on MySpace" target="_blank">MySpace</a></li>
                    <li class="tw"><a href="http://twitter.com/proloyc" title="Follow me on Twitter" target="_blank">Twitter</a></li>
                    <li class="lin"><a href="http://www.linkedin.com/in/proloy" title="Follow me on LinkedIn" target="_blank">LinkedIn</a></li>
                    <li class="plx"><a href="http://proloy.myplaxo.com/" title="Follow me on Plaxo" target="_blank">Plaxo</a></li>
                </ul>
			</div>
        </div>
        <!--Follow me on Box //end-->
        
        <!--Donate Box //start-->
		<div id="sm_pnres" class="postbox">
			<h3 class="hndle"><span>Advance Services:</span></h3>
			<div class="inside">
                <ul>
                  <li><a href="http://www.proloy.me/services/wordpress/wordpress-themes/" title="Get Custom Wordpress Themes" target="_blank">Get a Custom Wordpress Theme</a></li>
                </ul>
		  </div>
        </div>
        <!--Donate Box //end-->
        
        <!--Donate Box //start-->
		<div id="sm_pnres" class="postbox">
			<h3 class="hndle"><span>Donate:</span></h3>
			<div class="inside">
                <p>Please support me by donating as such as you can, so that I get motivation to develop this plugin and more plugins.</p>
                <p align="center"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5675100" target="_blank"><img src="<?php echo $imgpath ?>paypal.gif" alt="Donate to Support Me" /></a></p>
			</div>
        </div>
        <!--Donate Box //end-->
      </div>
    </div>    
    <!--Admin Page Right Column //end-->
    
    <!--Admin Page Left Column //start-->    
	<div class="has-sidebar sm-padded">
		<div id="post-body-content" class="has-sidebar-content">
			<div class="meta-box-sortabless">
          		<form action="<?php echo $action_url ?>" method="post" name="ZDGlobalCurrencyConverter" id="ZDGlobalCurrencyConverter">
				<input type="hidden" name="submitted" value="1" />
				<?php wp_nonce_field('zdgcc-nonce'); ?>
				<!--Widget Options //start-->
				<div id="sm_rebuild" class="postbox">
					<h3 class="hndle"><span>Options:</span></h3>
              		<div class="inside">
						<p><strong>Set default Options for the Currency Converter</strong></p>
                        <ul>
                        	<li><label for="zplayer">Landing Page Option:&nbsp;
                            <select id="landingpageoption" name="landingpageoption">
                            	<?php if($options['landingpageoption'] == "link") { ?>
                            	<option value="link" selected="selected">With a link to Foreign Exchange</option>
                                <?php } else { ?>
                                <option value="link">With a link to Foreign Exchange</option>
                                <?php } ?>
                                
                                <?php if($options['landingpageoption'] == "branded") { ?>
                                <option value="branded" selected="selected">Branded with a capture details</option>
                                <?php } else { ?>
                                <option value="branded">Branded with a capture details</option>
                                <?php } ?>
                            </select>
                            </label></li>
                            <li><label for="ztheme">Referral Code:&nbsp;
                            <input type="text" name="referralcode" id="referralcode" style="width:100px;" value="<?php echo $options['referralcode']; ?>" />
                            </label></li>
                        </ul>
                        <p class="submit">
        					<input type="button" name="updtlst" id="updtlst" value="Sign-up for referral code" onclick="window.open('<?php echo $options['referralurl']; ?>', '_blank');" />
      					</p>
              		</div>
            	</div>
            	<!--Widget Options //end-->
				
                <!--Widget CSS //start-->
                <div id="sm_rebuild" class="postbox">
					<h3 class="hndle"><span>Widget CSS:</span></h3>
              		<div class="inside">
						<p><strong>Widget CSS for both Sidegar and Shortcode</strong></p>
                        <textarea id="widgetcss" name="widgetcss" cols="5" rows="5" style="width:100%; height:250px"><?php echo $options['widgetcss']; ?></textarea>
              		</div>
            	</div>
                <!--Widget CSS //emd-->
                
      			<div class="submit">
        			<input type="submit" name="Submit" value="Update Options" />
      			</div>
    			</form>
                
                <p>&nbsp;</p>
                <h5>WordPress plugin by: <a href="http://www.proloy.me/" target="_blank">Proloy Chakroborty</a></h5>
          	</div>
        	</div>
		</div>
    <!--Admin Page Left Column //end-->
  </div>
</div>
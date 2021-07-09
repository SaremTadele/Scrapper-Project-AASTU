<?php
   function Scrappers_project_AASTU_logs()
   {
       global $wp_filesystem;
       if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
           include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
           wp_filesystem($creds);
       }
       if(isset($_POST['Scrappers_project_AASTU_delete']))
       {
           if($wp_filesystem->exists(WP_CONTENT_DIR . '/Scrappers_project_AASTU_info.log'))
           {
               $wp_filesystem->delete(WP_CONTENT_DIR . '/Scrappers_project_AASTU_info.log');
           }
       }
       if(isset($_POST['Scrappers_project_AASTU_delete_rules']))
       {
           $running = array();
           update_option('Scrappers_project_AASTU_running_list', $running);
       }
       if(isset($_POST['Scrappers_project_AASTU_restore_defaults']))
       {
           Scrappers_project_AASTU_activation_callback(true);
       }
       if(isset($_POST['Scrappers_project_AASTU_delete_all']))
       {
           Scrappers_project_AASTU_delete_all_posts();
       }
       if(isset($_POST['Scrappers_project_AASTU_refresh_categories']))
       {
           Scrappers_project_AASTU_update_categories();
       }
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <div>
         <h3>
            <?php echo esc_html__("System Info", 'Scrappers_project_AASTU-news-post-generator');?>: 
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("Some general system information.", 'Scrappers_project_AASTU-news-post-generator');
                     ?>
               </div>
            </div>
         </h3>
         <hr/>
         <table class="cr_server_stat">
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("User Agent:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo esc_html($_SERVER['HTTP_USER_AGENT']); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("Web Server:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo esc_html($_SERVER['SERVER_SOFTWARE']); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Version:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo esc_html(phpversion()); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Max POST Size:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo esc_html(ini_get('post_max_size')); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Max Upload Size:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo esc_html(ini_get('upload_max_filesize')); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Memory Limit:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo esc_html(ini_get('memory_limit')); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP DateTime Class:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo (class_exists('DateTime') && class_exists('DateTimeZone')) ? '<span class="cdr-green">' . esc_html__('Available', 'Scrappers_project_AASTU-news-post-generator') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'Scrappers_project_AASTU-news-post-generator') . '</span> | <a href="http://php.net/manual/en/datetime.installation.php" target="_blank">more info&raquo;</a>'; ?> </td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Curl:", 'Scrappers_project_AASTU-news-post-generator');?></td>
               <td class="cdr-dw-td-value"><?php echo (function_exists('curl_version')) ? '<span class="cdr-green">' . esc_html__('Available', 'Scrappers_project_AASTU-news-post-generator') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'Scrappers_project_AASTU-news-post-generator') . '</span>'; ?> </td>
            </tr>
            <?php do_action('AASTU_Students_dashboard_widget_server') ?>
         </table>
      </div>
      <div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__("Rules Currently Running", 'Scrappers_project_AASTU-news-post-generator');?>:
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("These rules are currently running on your server.", 'Scrappers_project_AASTU-news-post-generator');
                        ?>
                  </div>
               </div>
            </h3>
            <div>
               <?php
                  if (!get_option('Scrappers_project_AASTU_running_list')) {
                      $running = array();
                  } else {
                      $running = get_option('Scrappers_project_AASTU_running_list');
                  }
                  if (!empty($running)) {
                      echo '<ul>';
                      foreach($running as $key => $thread)
                      {
                          foreach($thread as $param => $type)
                          {
                              echo '<li><b>' . esc_html($type) . '</b> - ID' . esc_html($param) . '</li>';
                          }
                      }
                      echo '</ul>';        
                  }
                  else
                  {
                      echo esc_html__('No rules are running right now', 'Scrappers_project_AASTU-news-post-generator');
                  }
                  ?>
            </div>
            <hr/>
            <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to clear the running list?', 'Scrappers_project_AASTU-news-post-generator');?>');">
               <input name="Scrappers_project_AASTU_delete_rules" type="submit" title="<?php echo esc_html__('Caution! This is for debugging purpose only!', 'Scrappers_project_AASTU-news-post-generator');?>" value="<?php echo esc_html__('Clear Running Rules List', 'Scrappers_project_AASTU-news-post-generator');?>">
            </form>
         </div>
         <div>
            <br/>
            <hr class="cr_special_hr"/>
            <div>
               <h3>
                  <?php echo esc_html__("Restore Plugin Default Settings", 'Scrappers_project_AASTU-news-post-generator');?>: 
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__('Hit this button and the plugin settings will be restored to their default values. Warning! All settings will be lost!', 'Scrappers_project_AASTU-news-post-generator');
                           ?>
                     </div>
                  </div>
               </h3>
               <hr/>
               <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to restore the default plugin settings?', 'Scrappers_project_AASTU-news-post-generator');?>');"><input name="Scrappers_project_AASTU_restore_defaults" type="submit" value="<?php echo esc_html__('Restore Plugin Default Settings', 'Scrappers_project_AASTU-news-post-generator');?>"></form>
            </div>
            <br/>
            <hr class="cr_special_hr"/>
            <div>
               <h3>
                  <?php echo esc_html__("Delete All Posts Generated by this Plugin", 'Scrappers_project_AASTU-news-post-generator');?>: 
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__('Hit this button and all posts generated by this plugin will be deleted!', 'Scrappers_project_AASTU-news-post-generator');
                           ?>
                     </div>
                  </div>
               </h3>
               <hr/>
               <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all generated posts? This can take a while, please wait until it finishes.', 'Scrappers_project_AASTU-news-post-generator');?>');"><input name="Scrappers_project_AASTU_delete_all" type="submit" value="<?php echo esc_html__('Delete All Generated Posts', 'Scrappers_project_AASTU-news-post-generator');?>"></form>
            </div>
            <br/>
            <hr class="cr_special_hr"/>
            <div>
               <h3>
                  <?php echo esc_html__("Refresh Plugin News Sources", 'Scrappers_project_AASTU-news-post-generator');?>: 
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Hit this button you will get the latest news sources published by Scrappers_project_AASTUAPI.", 'Scrappers_project_AASTU-news-post-generator');
                           ?>
                     </div>
                  </div>
               </h3>
               <hr/>
               <form method="post" onsubmit="return confirm('Are you sure you want to refresh news sources? This will call the API and get the updated news source list from it.');"><input name="Scrappers_project_AASTU_refresh_categories" type="submit" value="Refresh News Sources"></form>
            </div>
            <br/>
            <hr class="cr_special_hr"/>
            <h3>
               <?php echo esc_html__("Activity Log", 'Scrappers_project_AASTU-news-post-generator');?>:
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__('This is the main log of your plugin. Here will be listed every single instance of the rules you run or are automatically run by schedule jobs (if you enable logging, in the plugin configuration).', 'Scrappers_project_AASTU-news-post-generator');
                        ?>
                  </div>
               </div>
            </h3>
            <div>
               <?php
                  if($wp_filesystem->exists(WP_CONTENT_DIR . '/Scrappers_project_AASTU_info.log'))
                  {
                      $log = $wp_filesystem->get_contents(WP_CONTENT_DIR . '/Scrappers_project_AASTU_info.log');
                      $log = esc_html($log);$log = str_replace('&lt;br/&gt;', '<br/>', $log);echo $log;
                  }
                  else
                  {
                      echo esc_html__("Log empty", 'Scrappers_project_AASTU-news-post-generator');
                  }
                  ?>
            </div>
         </div>
         <hr/>
         <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all logs?', 'Scrappers_project_AASTU-news-post-generator');?>');">
            <input name="Scrappers_project_AASTU_delete" type="submit" value="<?php echo esc_html__('Delete Logs', 'Scrappers_project_AASTU-news-post-generator');?>">
         </form>
      </div>
   </div>
</div>
<?php
   }
   ?>
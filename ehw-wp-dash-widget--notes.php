<?php
/**
 * 
 * Plugin Name:     EHW Dashboard Widget: Site Notes 
 * Description:     Display editable textarea dashboard widget with iframe support
 * Version:         00.02.00
 * Date Created:    01/20/2025
 * Date Modified:   02/03/2025
 * Author:          Eric L. Hepperle
 * Author URI:      erichepperle.com
 * 
 * Inspired by WP Learn Dashboard Widgets: https://www.youtube.com/watch?v=sgC9ISgPpNQ
 * 
 * Tags: Textarea, Notes, Dashboard Widget
 */

 /**
  * Hepperle - 2025-02-03 -- Testing suggested edits by ChatGPT: https://chatgpt.com/c/67a12d21-0900-8009-be88-6439f59d6653
  */


  
  define('EHW_NOTES_FILE', plugin_dir_path(__FILE__) . 'stored-notes.php');
  
  // Register dashboard widget
  function ehw_dash_widget_notes() {
      if (current_user_can('manage_options')) {
          $notes = get_option('ehw_site_notes', '');
  
          if (empty($notes) && file_exists(EHW_NOTES_FILE)) {
              $notes = file_get_contents(EHW_NOTES_FILE);
          }
  
          echo '<style>
                  #ehw_notes { width: 100%; height: 150px; }
                  #ehw_notes_iframe { width: 100%; height: 200px; border: 1px solid #ccc; margin-top: 10px; }
                  #save_notes { margin-top: 10px; padding: 5px 10px; cursor: pointer; }
                </style>';
  
          echo '<textarea id="ehw_notes">' . esc_textarea($notes) . '</textarea>';
          echo '<button id="save_notes">Save Notes</button>';
          echo '<iframe id="ehw_notes_iframe" src="' . plugin_dir_url(__FILE__) . 'stored-notes.php"></iframe>';
  
          echo '<script>
                  jQuery(document).ready(function($) {
                      $("#save_notes").click(function() {
                          var notes = $("#ehw_notes").val();
                          $.post(ajaxurl, {
                              action: "save_ehw_notes",
                              notes: notes
                          }, function(response) {
                              alert(response);
                              $("#ehw_notes_iframe").attr("src", "' . plugin_dir_url(__FILE__) . 'stored-notes.php?" + new Date().getTime());
                          });
                      });
                  });
                </script>';
      }
  }
  add_action('wp_dashboard_setup', function() {
      wp_add_dashboard_widget('ehw_notes_widget', 'Site Notes', 'ehw_dash_widget_notes');
  });
  
  // Handle AJAX save
  add_action('wp_ajax_save_ehw_notes', function() {
      if (!current_user_can('manage_options')) {
          wp_die(__('Unauthorized user', 'ehw'));
      }
  
      $notes = isset($_POST['notes']) ? wp_kses_post($_POST['notes']) : '';
      update_option('ehw_site_notes', $notes);
      file_put_contents(EHW_NOTES_FILE, $notes);
      echo 'Notes saved successfully!';
      wp_die();
  });
  
  // Ensure stored-notes.php exists
  if (!file_exists(EHW_NOTES_FILE)) {
      file_put_contents(EHW_NOTES_FILE, '');
  }
  ?>
  
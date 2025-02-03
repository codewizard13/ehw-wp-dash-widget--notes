<?php
/**
 * 
 * Plugin Name:     EHW Textarea Dashboard Widget 
 * Description:     Display editable textarea dashboard widget
 * Version:         00.01.01
 * Date Created:    01/20/2025
 * Date Modified:   02/03/2025
 * Author:          Eric L. Hepperle
 * Author URI:      erichepperle.com
 * 
 * Inspired by WP Learn Dashboard Widgets: https://www.youtube.com/watch?v=sgC9ISgPpNQ
 * 
 * Tags: Textarea, Notes, Dashboard Widget
 */


function ehw_textarea_dashboard_widget()
{

  if (current_user_can('manage_options')) {

    wp_add_dashboard_widget(
      'ehw_textarea_dashboard_widget',
      'EHW: Textarea Dashboard Widget',
      'ehw_textarea_dashboard_widget_callback',
      'ehw_textarea_dashboard_widget_control',
      ['description' => 'This is a description'],
      'column3',
      'high'
    );

  }
}
add_action('wp_dashboard_setup', 'ehw_textarea_dashboard_widget');


if (!function_exists('ehw_textarea_dashboard_widget_callback')) {

  function ehw_textarea_dashboard_widget_callback($screen, $widget_args)
  {
    ?>
      <style>
        .ehw-post-title {
          margin-left: .6rem !important;
        }
  
        .ehw-dash-row a {
          display: inline-flex;
          justify-content: space-evenly;
          flex-wrap: wrap;
          align-items: stretch;
        }
      </style>
  
      <b>Description: </b><?php echo $widget_args['args']['description'] ?><br>
  
      <?php
  
      $textcontent = get_option('ehw_textarea_dashboard_widget_textcontent', 'Default dummy textcontent');
      echo '<textarea id="results" name="ehw_textarea_dashboard_widget_textcontent" readonly>' . $textcontent . '</textarea>';
  
  }

}



function ehw_textarea_dashboard_widget_control()
{
  if (isset($_POST['ehw_textarea_dashboard_widget_textcontent'])) {
    $numberposts = sanitize_text_field($_POST['ehw_textarea_dashboard_widget_textcontent']);
    update_option('ehw_textarea_dashboard_widget_textcontent', $textcontent);
  }

  $numberposts = get_option('ehw_textarea_dashboard_widget_textcontent', 5);
  echo '<label>Enter some text:</label>';
  echo '<textarea id="textcontent" name="ehw_textarea_dashboard_widget_textcontent" name="textcontent" rows="5" cols="33" >';
  echo 'Starter Text' . '</textarea>';

}
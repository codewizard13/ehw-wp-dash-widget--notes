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


// Registger widget
function ehw_dash_widget_notes()
{

  if (current_user_can('manage_options')) {

    wp_add_dashboard_widget(
      'ehw_dash_widget_notes',
      'EHW: Textarea Dashboard Widget',
      'ehw_dash_widget_notes_callback',
      'ehw_dash_widget_notes_control',
      ['description' => 'This is a description'],
      'column3',
      'high'
    );

  }
}
add_action('wp_dashboard_setup', 'ehw_dash_widget_notes');


// Display widget

if (!function_exists('ehw_dash_widget_notes_callback')) {

  function ehw_dash_widget_notes_callback($screen, $widget_args)
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
      .notes-descr {
        margin-bottom: .8rem !important;
      }
      #results {
        width: 100%;
      }
    </style>

    <div class="notes-descr"><b>Description: </b><?php echo $widget_args['args']['description'] ?></div>

    <!-- START FORM -->
    <form action="options.php" method="post">

      <!-- Nonce for form security -->
      <?php wp_nonce_field('update-options'); ?>


      <?php $textcontent = get_option('ehw_dash_widget_notes_textcontent', 'Default dummy textcontent'); ?>

      <textarea id="results" name="ehw_dash_widget_notes_textcontent" readonly><?php echo get_option( 'ehw_dash_widget_notes_textcontent') ?></textarea>

    </form><!-- END FORM -->

    <?php






  }

}


// Setup widget controls
function ehw_dash_widget_notes_control()
{
  if (isset($_POST['ehw_dash_widget_notes_textcontent'])) {
    $numberposts = sanitize_text_field($_POST['ehw_dash_widget_notes_textcontent']);
    update_option('ehw_dash_widget_notes_textcontent', $textcontent);
  }

  $numberposts = get_option('ehw_dash_widget_notes_textcontent', 5);
  echo '<label>Enter some text:</label>';
  echo '<textarea id="textcontent" name="ehw_dash_widget_notes_textcontent" name="textcontent" rows="5" cols="33" >';
  echo 'Starter Text' . '</textarea>';

}
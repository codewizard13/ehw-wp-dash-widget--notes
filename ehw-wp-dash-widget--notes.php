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
      null,
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


      <textarea id="results"
        name="ehw_dash_widget_notes_text"><?php echo get_option('ehw_dash_widget_notes_text') ?></textarea>


      <fieldset>

        <div>
          <input type="checkbox" id="is-read-only" name="is-read-only" <?php echo get_option('is-read-only') ?> />
          <label for="is-read-only">Read-only?</label>
        </div>

      </fieldset>

      <!-- hidden fields pass values -->

      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="ehw_dash_widget_notes_text, is-read-only" />


      <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>">
      </p>

    </form><!-- END FORM -->

    <?php

  }

}
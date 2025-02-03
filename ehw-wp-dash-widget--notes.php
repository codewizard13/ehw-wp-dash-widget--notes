<?php
/**
 * 
 * Plugin Name:     EHW Dashboard Widget: Site Notes 
 * Description:     Display editable textarea dashboard widget
 * Version:         00.01.02
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
  * Hepperle - 2025-02-03 -- Testing suggested edits by Perplexity: https://www.perplexity.ai/search/i-created-this-wordpress-dashb-_K873rm0QoWXod.RF_JFjg
  */

// Register widget (B)
function ehw_dash_widget_notes()
{
  if (current_user_can('manage_options')) {

    // Setup variables
    $description = <<< DESCR
    Add notes about the site (HTML is not allowed).<br>
    
    <ul>
       <li><b>NOTE:</b> Have to save changes after toggling the readonly checkbox for it to take effect.</li>
       <li><b>NOTE:</b> There's no way to put code snippets here yet due to html entities sanitizing.</li>
    </ul>
    DESCR;

    $widgetTitle = "EHW Dashboard Widget: Site Notes";

    wp_add_dashboard_widget(
      'ehw_dash_widget_notes',
      $widgetTitle,
      'ehw_dash_widget_notes_callback',
      null,
      ['description' => $description],
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
    // Check if form is submitted
    if (isset($_POST['ehw_dash_widget_notes_submit'])) {
      // Update textarea content
      update_option('ehw_dash_widget_notes_text', sanitize_textarea_field($_POST['ehw_dash_widget_notes_text']));

      // Update checkbox state
      $is_read_only = isset($_POST['is_read_only']) ? 'checked' : '';
      update_option('ehw_dash_widget_notes_readonly', $is_read_only);
    }

    // Get current values
    $textarea_content = get_option('ehw_dash_widget_notes_text', '');
    $is_read_only = get_option('ehw_dash_widget_notes_readonly', '');

    ?>
    <style>
      :root {
        --margin-med: .5rem; /* medium margin */
      }

      .ehw-dash-row a {
        display: inline-flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
        align-items: stretch;
      }

      .notes-descr {
        margin-bottom: calc( var(--margin-med) * 1.4);
        
      }

      #results {
        width: 100%;
        margin-bottom: var(--margin-med);
        min-height: 200px;

      }
      fieldset {
        margin-bottom: calc( var(--margin-med) * 1.2);
      }
    </style>

    <div class="notes-descr"><b>Description: </b><?php echo $widget_args['args']['description'] ?></div>

    <!-- START FORM -->
    <form method="post">
      <?php wp_nonce_field('ehw_dash_widget_notes_action', 'ehw_dash_widget_notes_nonce'); ?>

      <textarea id="results" name="ehw_dash_widget_notes_text" <?php echo $is_read_only == 'checked' ? 'readonly' : '' ?>><?php echo esc_textarea($textarea_content); ?></textarea>

      <fieldset>
        <div>
          <input type="checkbox" id="is_read_only" name="is_read_only" <?php checked($is_read_only, 'checked'); ?> />
          <label for="is_read_only">Read-only?</label>
        </div>
      </fieldset>

      <p class="submit">
        <input type="submit" name="ehw_dash_widget_notes_submit" class="button-primary" value="<?php _e('Save Changes') ?>">
      </p>
    </form><!-- END FORM -->
    <?php
  }
}
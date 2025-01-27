<?php
/**
 * 
 * Plugin Name:     EHW Textarea Dashboard Widget 
 * Description:     Display editable textarea dashboard widget
 * Version:         01.00.00
 * Date Created:    01/20/27
 * Author:          Eric L. Hepperle
 * Author URI:      erichepperle.com
 * Developer:       Eric Hepperle
 * 
 * Inspired by WP Learn Dashboard Widgets
 */

add_action('wp_dashboard_setup', 'ehw_textarea_dashboard_widget');

function ehw_textarea_dashboard_widget()
{
  wp_add_dashboard_widget(
    'ehw_textarea_dashboard_widget',
    'EHW: Textarea Dashboard Widget',
    'ehw_textarea_dashboard_widget_callback',
    'ehw_textarea_dashboard_widget_control'
  );
}

function ehw_textarea_dashboard_widget_callback()
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
<?php

  $numberposts = get_option('ehw_textarea_dashboard_widget_numberposts', 5);

  $args = [
    'posts_per_page' => $numberposts,
    'post_status' => 'publish',
    'post_type' => ['event']
  ];

  $recent_posts = wp_get_recent_posts($args);


  echo '<ul>';

  foreach ($recent_posts as $recent_post) {
    $postId = $recent_post['ID'];

    if ( has_post_thumbnail( $postId ) ) {
      $postThumb = get_the_post_thumbnail($postId, [40,40]);
    }

    $postTitle = function_exists('elsm_trunc_text') ? elsm_trunc_text($recent_post['post_title'], 64) : $recent_post['post_title'];

    $post_row = '<li class="ehw-dash-row"><a href="' . get_permalink($postId) . '">';
    $post_row .= $postThumb ? $postThumb : '';
    $post_row .= '<span class="ehw-post-title">' . $postTitle . '</span>';
    $post_row .= '</a></li>';
    echo $post_row;

  }

  echo '</ul>';



}



function ehw_textarea_dashboard_widget_control()
{
  if (isset($_POST['ehw_textarea_dashboard_widget_numberposts'])) {
    $numberposts = sanitize_text_field($_POST['ehw_textarea_dashboard_widget_numberposts']);
    update_option('ehw_textarea_dashboard_widget_numberposts', $numberposts);
  }

  $numberposts = get_option('ehw_textarea_dashboard_widget_numberposts', 5);
  echo '<label>Enter the number of posts to display</label>';
  echo '<input type="text" name="ehw_textarea_dashboard_widget_numberposts" value="' . $numberposts . '" />';
}
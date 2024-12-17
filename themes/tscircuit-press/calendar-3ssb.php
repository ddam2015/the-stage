<?php
/**
 * Template Name: Event Calendar 3SSB
 * Author: Daradona Dam
 * Version: 1.0
 */
get_header();
$calendar_data = g365_fn(['fn_name'=>'g365_remote_api', 'arguments'=>['calendar-api', ['target_url'=>'https://dev.jr3ssb.com']]]);
print_r(get_site_url());
?>
<div class="grid-container">
  <section id="content" class="grid-x site-main xlarge-padding-bottom" role="main">
    <?php if(!empty($calendar_data->event_calendar)): ?>
    <div class="cell small-12">
      <header class="entry-header"><h1 class="entry-title">Calendar</h1>	</header><!-- .entry-header -->
      <div class="entry-content">
        <div class="grid-x grid-margin-x">
          <div class="cell small-12">
            <table class="calendar">
              <thead>
                <tr>
                  <th class="text-center">EVENT</th>
                  <th class="text-center">DATE</th>
                  <th class="text-center">NAME</th>
                  <th class="text-center">LOCATION</th>
                </tr>
              </thead>
              <tbody class="table-stripe">
                <?php foreach($calendar_data->event_calendar as $event_calandar): ?>
                <tr class="event-line" data-event_link="<?php echo $event_calandar->link; ?>">
                  <td class="text-center">
                    <img class="event-logo" src="<?php echo $event_calandar->logo_img; ?>" alt="<?php echo $event_calandar->name; ?>"/>
                  </td>
                  <td class="text-center"><?php echo $event_calandar->dates; ?></td>
                  <td class="text-center">
                    <a href="<?php echo $event_calandar->link; ?>" target="_blank" title="<?php echo $event_calandar->name; ?>"><?php echo $event_calandar->name; ?></a>
                  </td>
                  <td class="text-center"><?php echo $event_calandar->locations; ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php else: echo ('<h3>'. $calendar_data->nv_message . '</h3>'); endif; ?>
  </section>
</div>
<?php get_footer(); ?>
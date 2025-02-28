<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 23, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of events
 *
 * @developer duongca
 */

if (!class_exists('Inwave_Events')) {

    class Inwave_Events {

        function __construct() {

            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_events', array($this, 'inwave_events_shortcode'));
        }

        function heading_init() {
			
			if(!class_exists('EventOn')){return;}
            // Add banner addon
            vc_map(array(
                'name' => 'Events',
                'description' => __('Display a list of events', 'gmswebdesign'),
                'base' => 'inwave_events',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "gmswebdesign"),
                        "value" => "Up Coming Event",
                        "param_name" => "title",
                        "description" => __('Title of events block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sup Title", "gmswebdesign"),
                        "param_name" => "sub_title",
                        "description" => __('Sub Title of events block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Description", "gmswebdesign"),
                        "param_name" => "description",
                        "description" => __('Description of events block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Number of month", "gmswebdesign"),
                        "value" => "5",
                        "param_name" => "months",
                        "description" => __('Number of month to get events.', "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of events", "gmswebdesign"),
                        "param_name" => "events",
                        "value" => "2",
                        "description" => __('Number of events to display on every month.', "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Month increment", "gmswebdesign"),
                        "param_name" => "month_increment",
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Fixed month", "gmswebdesign"),
                        "param_name" => "fixed_month",
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Fixed year", "gmswebdesign"),
                        "param_name" => "fixed_year",
                        "value" => "",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Event order", "gmswebdesign"),
                        "param_name" => "event_order",
                        "value" => array(
                            'ASC' => 'ASC',
                            'DESC' => 'DESC',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("First day of week", "gmswebdesign"),
                        "param_name" => "first_day_of_week",
                        "value" => array(
                            'Sunday' => 'sunday',
                            'Monday' => 'monday',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Hide Past Events", "gmswebdesign"),
                        "param_name" => "hide_past",
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show only featured events", "gmswebdesign"),
                        "param_name" => "show_feature_event_only",
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "gmswebdesign"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "gmswebdesign")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => __("Style", "gmswebdesign"),
                        "param_name" => "style",
                        "value" => array(
                            'Style 1 - Carousel' => 'style1',
                            'Style 2 - Flat list' => 'style2',
                            'Style 3 - Timetable' => 'style3'
                        ),
                    )
                )
            ));
        }

        // Shortcode handler function for list Icon
        function inwave_events_shortcode($atts, $content = null) {
            $output = $answer = $question = $class = '';
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'description' => '',
                'months' => 2,
                'events' => 5,
                'month_increment' => 0,
                'first_day_of_week' => 'sunday',
                'fixed_month' => 0,
                'fixed_year' => 0,
                'event_order' => 'ASC',
                'hide_past' => 'yes',
                'show_feature_event_only' => 'no',
                'class' => '',
                'style' => 'style1'
                            ), $atts));
            return $this->htmlBoxEventRender(
                            $title, $sub_title, $description, $months, $events, $month_increment, $fixed_month, $fixed_year, $event_order, $hide_past, $show_feature_event_only, $class, $style, $first_day_of_week
            );
        }

        function htmlBoxEventRender(
        $title, $sub_title, $description, $months, $events, $month_increment, $fixed_month, $fixed_year, $event_order, $hide_past, $show_feature_event_only, $class, $style, $first_day_of_week) {
            global $eventon;
			if(!class_exists('EventOn')){return;}
            $cal = $eventon->evo_generator;
            $get_new_monthyear = array('month' => $fixed_month ? $fixed_month : date('n'), 'year' => $fixed_year ? $fixed_year : date('Y'));
            $focus_start_date_range = mktime(0, 0, 0, $get_new_monthyear['month'], 1, $get_new_monthyear['year']);

            if (!$fixed_month) {
                if ($month_increment > 0) {
                    $month_increment = '+' . $month_increment;
                }
                $focus_start_date_range = strtotime($month_increment . ' months', $focus_start_date_range);
            }

            $focus_end_date_range = strtotime('+' . $months . ' months', $focus_start_date_range);
            // generate events within the focused date range
            $eve_args = array(
                'focus_start_date_range' => $focus_start_date_range,
                'focus_end_date_range' => $focus_end_date_range,
                'sort_by' => 'sort_date', // by default sort events by start date
                'event_order' => $event_order,
            );

            $ecv = $cal->process_arguments($eve_args);
            $cal->reused();

            // GET events list array
            $event_list_array = $cal->evo_get_wp_events_array('', $ecv);

            // MOVE: featured events to top if set
            if ($show_feature_event_only == 'yes') {
                $f_events = array();
                foreach ($event_list_array as $event) {
                    if ($event['event_pmv']['_featured'][0] == 'yes') {
                        array_push($f_events, $event);
                    }
                }
                $event_list_array = $f_events;
            }
            if ($hide_past == 'yes') {
                $h_events = array();
                foreach ($event_list_array as $event) {
                    if ($event['event_start_unix'] >= time()) {
                        array_push($h_events, $event);
                    }
                }
                $event_list_array = $h_events;
            }

            if ($style == 'style1') {
                $html = $this->loadCarouselStyleHtml($event_list_array, $class, $title, $events);
            } else if ($style == 'style2') {
                $html = $this->loadFlatListStyleHtml($event_list_array, $events, $class, $title, $sub_title, $description);
            } else if ($style == 'style3') {
                $html = $this->loadTimetableStyleHtml($event_list_array, $events, $class, $title, $sub_title, $description, $months, $first_day_of_week);
            } else {
                $html = 'No style';
            }
            return $html;
        }

        public function groupEvents($event_list_array, $num_events) {
            $arrDay = array();
            foreach ($event_list_array as $event) {
                $day = date('d', $event['event_start_unix']);
                if (isset($arrDay[$day]) && $arrDay[$day]) {
                    if (count($arrDay) <= $num_events) {
                        $arrDay[$day][] = $event;
                    }
                } else {
                    $arrDay[$day] = array();
                    $arrDay[$day][] = $event;
                }
            }
            return $arrDay;
        }

        public function loadCarouselStyleHtml($event_list_array, $class, $title, $event_count) {
            $eventGroup = $this->groupEvents($event_list_array, $event_count);
            ob_start();
            ?>
            <div class="iw-events <?php echo $class; ?>">
                <div class="owl-carousel" data-nav="t-nav-" data-plugin-options='{"navigation":false,"autoPlay":false}'>
                    <?php
                    if ($eventGroup):
                        foreach ($eventGroup as $key => $value):
                            ?>
                            <div class="boxing-main">
                                <div class="boxing-content">						
                                    <div class="col-left sidebar">		
                                        <div class="event-month">
                                            <div class="table-cell">
                                                <div class="title">
                                                    <span><?php echo $key; ?></span>
                                                    <p><?php echo date('F', $value[0]['event_start_unix']); ?></p>																																																																
                                                </div>
                                                <div class="next">
                                                    <button class="circle icon-wrap t-nav-prev">
                                                        <i class="fa fa-chevron-left"></i>
                                                    </button>
                                                    <button class="circle icon-wrap t-nav-next">
                                                        <i class="fa fa-chevron-right"></i>
                                                    </button>
                                                </div>
                                            </div>										
                                        </div>	
                                        <div class="sidebar-bottom">
                                            <div class="up-coming col-md-12 col-sm-12 col-xs-12">
                                                <h2><?php echo $title ? $title : ''; ?></h2>
                                                <div class="product-bottom"></div>
                                            </div>
                                            <?php
                                            foreach ($value as $event):
                                                ?>
                                                <div class="sidebar-bottom-1 col-md-12 col-sm-12 col-xs-12">										
                                                    <div class="match-img col-md-12 col-sm-6 col-xs-12">
                                                        <?php $img = wp_get_attachment_image_src(get_post_thumbnail_id($event['event_id']), 'single-post-thumbnail'); ?>
                                                        <img alt="" src="<?php echo $img[0]; ?>">
                                                    </div>
                                                    <div class="title-match col-md-12 col-sm-6 col-xs-12">
                                                        <h3><a href="<?php echo get_permalink($event['event_id']); ?>" alt=""><?php echo $event['event_title'] ?></a></h3>
                                                        <?php
                                                        $sday = date('d', $event['event_start_unix']);
                                                        $eday = date('d', $event['event_end_unix']);
                                                        if ($sday == $eday) {
                                                            $s_day = date('g.iA', $event['event_start_unix']);
                                                            $e_day = date('g.iA', $event['event_end_unix']);
                                                        } else {
                                                            $s_day = date('M d', $event['event_start_unix']);
                                                            $e_day = date('M d', $event['event_end_unix']);
                                                        }
                                                        ?>
                                                        <p><?php echo $s_day . ' - ' . $e_day; ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        public function loadFlatListStyleHtml($eventList, $events, $class, $title, $sub_title, $description) {
            ob_start();
            ?>
            <div class="iw-events <?php echo $class; ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="news-cont">
                                <div class="title-page">
                                    <h4><?php echo $sub_title; ?></h4>
                                    <h3><?php echo $title; ?></h3>								
                                </div>
                                <p class="news-text"><?php echo $description; ?></p>
                                <div class="news-content">
                                    <ul>
                                        <?php for ($i = 0; $i < $events; $i++): ?>
                                            <?php
                                            if ($eventList[$i]):
                                                $event = $eventList[$i];
                                                $day = date('d', $event['event_start_unix']);
                                                $month = date('M', $event['event_start_unix']);
                                                $link = get_permalink($event['event_id']);
                                                $event_title = $event['event_title'];
                                                $sday = date('d', $event['event_start_unix']);
                                                $eday = date('d', $event['event_end_unix']);
                                                if ($sday == $eday) {
                                                    $s_day = date('g.iA', $event['event_start_unix']);
                                                    $e_day = date('g.iA', $event['event_end_unix']);
                                                } else {
                                                    $s_day = date('M d', $event['event_start_unix']);
                                                    $e_day = date('M d', $event['event_end_unix']);
                                                }
                                                ?>
                                                <li class="latest-news-item">
                                                    <div class="news-item-inner">
                                                        <div class="news-date">
                                                            <div class="news-day"><?php echo $day; ?></div>
                                                            <div class="news-month"><?php echo $month; ?></div>
                                                        </div>
                                                        <div class="news-info">
                                                            <div class="news-title">
                                                                <a href="<?php echo $link; ?>"><?php echo $event_title; ?></a>
                                                            </div>
                                                            <div class="news-time">
                                                                <p><?php echo $s_day . ' - ' . $e_day; ?></p>				
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            endif;
                                        endfor;
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        public function loadTimetableStyleHtml($eventList, $events, $class, $title, $sub_title, $description, $num_month, $first_day_of_week) {
            $weekEvents = $this->weekEvents($eventList, $num_month, $first_day_of_week);
            ob_start();
            ?>
            <div class="iw-events timetable <?php echo $class; ?>">
                <div class="container">
                    <div class="row">
                        <div class="timetable-top">
                            <div class="col-md-12">
                                <div class="title-page title-time">
                                    <h3><?php echo $title; ?></h3>
                                    <p><?php echo $description; ?></p>
                                </div>
                            </div>
                            <div class="timetable-content col-md-12">
                                <div class="owl-carousel" data-nav="t-nav-" data-plugin-options='{"autoPlay":false,"navigation":false,"singleItem":true,"autoHeight":true}'>
                                    <?php
                                    if ($weekEvents):
                                        foreach ($weekEvents as $weekEvent):
                                            $dateFirst = $weekEvent[0];
                                            $active = '';
                                            if (date('W', strtotime($dateFirst['date'])) == date('W')) {
                                                $active = 'active';
                                            }
                                            ?>
                                            <div class="time-table-main <?php echo $active ?>">	
                                                <div class="octember col-md-3 col-sm-6 col-xs-12">
                                                    <div class="month">
                                                        <div class="timetable-title">
                                                            <span><?php echo date('Y', strtotime($dateFirst['date'])); ?></span>
                                                            <p><?php echo date('F', strtotime($dateFirst['date'])); ?></p>											
                                                        </div>
                                                        <div class="next">
                                                            <button class="circle icon-wrap t-nav-prev">
                                                                <i class="fa fa-angle-left"></i>
                                                            </button>
                                                            <button class="circle icon-wrap t-nav-next">
                                                                <i class="fa fa-angle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                foreach ($weekEvent as $days):
                                                    $day = date('j', strtotime($days['date']));
                                                    $month = date('F', strtotime($days['date']));
                                                    $dayOfWeek = date('l', strtotime($days['date']));
                                                    $event = $days['event'];
                                                    $isDisable = $days['isDisable'];
                                                    ?>
                                                    <div class="monday day col-md-3 col-sm-6 col-xs-12">
                                                        <div class="timetable-cont">
                                                            <div class="time-table-title">
                                                                <span><?php echo $month . ', ' . $day; ?></span>
                                                                <p><?php echo $dayOfWeek; ?></p>
                                                            </div>
                                                            <?php
                                                            if ($event):
                                                                $img = wp_get_attachment_image_src(get_post_thumbnail_id($event['event_id']), 'single-post-thumbnail');
                                                                $link = get_permalink($event['event_id']);
                                                                $event_title = $event['event_title'];
                                                                $sday = date('d', $event['event_start_unix']);
                                                                $eday = date('d', $event['event_end_unix']);
                                                                $post_event = get_post($event['event_id']);
                                                                $desc = AthleteHelper::substrword($post_event->post_content,10,true);
                                                                if ($sday == $eday) {
                                                                    $s_day = date('g.iA', $event['event_start_unix']);
                                                                    $e_day = date('g.iA', $event['event_end_unix']);
                                                                } else {
                                                                    $s_day = date('M d', $event['event_start_unix']);
                                                                    $e_day = date('M d', $event['event_end_unix']);
                                                                }
                                                                ?>
                                                                <img alt="" class="event-img" src="<?php echo $img[0]; ?>"/>										
                                                                <div class="box-content">
                                                                    <div class="table">
                                                                        <div class="box-cell">
                                                                            <div class="timetable-info">
                                                                                <div class="title-content">
                                                                                    <span><a href="<?php echo $link; ?>"><?php echo $event_title; ?></a></span>
                                                                                    <div class="border-bottom"></div>
                                                                                    <p><?php echo $s_day . ' - ' . $e_day; ?></p>
                                                                                </div>
                                                                                <p><?php echo $desc; ?></p>
                                                                                <div class="timetable_details">
                                                                                    <a href="<?php echo $link; ?>"><?php _e('Read more', 'gmswebdesign'); ?></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>	
                                                                </div>
                                                                <?php
                                                            else:
                                                                ?>
                                                                <img alt="" src="<?php echo get_template_directory_uri(); ?>/images/img-1x1.png"/>										
                                                                <div class="box-content">
                                                                    <div class="table">
                                                                        <?php if (!$isDisable): ?>
                                                                            <div class="box-cell">
                                                                                <div class="timetable-info">
                                                                                    <span><?php _e('No event', 'gmswebdesign'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>	
                                                                </div>

                                                            <?php
                                                            endif;
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </div>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        public function weekEvents($eventList, $num_month, $first_day_of_week) {
            $numberEvents = count($eventList);
            $listWeeks = array();
            if ($numberEvents > 0) {
                $sdate = strtotime(date('Y-m-01'));
                $edate = strtotime('+' . $num_month . ' months', $sdate);
                $edate = strtotime('-1 days', $edate);
                if ($first_day_of_week == 'sunday') {
                    $sDayOfWeek = intval(date('w', $sdate));
                    $eDayOfWeek = intval(date('w', $edate));
                    $newStartDate = strtotime('-' . $sDayOfWeek . ' days', $sdate);
                    $newEndDate = strtotime('+' . (7 - $eDayOfWeek) . ' days', $edate);
                } else {
                    $sDayOfWeek = intval(date('N', $sdate));
                    $eDayOfWeek = intval(date('N', $edate));
                    $newStartDate = strtotime('-' . $sDayOfWeek + 1 . ' days', $sdate);
                    $newEndDate = strtotime('+' . (8 - $eDayOfWeek) . ' days', $edate);
                }


                $days = ($newEndDate - $newStartDate) / (60 * 60 * 24);

                for ($i = 0; $i < $days; $i++) {
                    $isDisable = false;
                    $date = date('Y-m-d', strtotime('+' . $i . ' days', $newStartDate));
                    if (strtotime('+' . $i . ' days', $newStartDate) < $sdate || strtotime('+' . $i . ' days', $newStartDate) > $edate) {
                        $isDisable = true;
                    }
                    foreach ($eventList as $event) {
                        if (date('Y-m-d', $event['event_start_unix']) == $date) {
                            $listWeeks[$i] = array('date' => $date, 'isDisable' => $isDisable, 'event' => $event);
                            break;
                        } else {
                            $listWeeks[$i] = array('date' => $date, 'isDisable' => $isDisable, 'event' => null);
                        }
                    }
                }
            }
            return array_chunk($listWeeks, 7);
        }

    }

}

new Inwave_Events();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Events extends WPBakeryShortCode {
        
    }

}
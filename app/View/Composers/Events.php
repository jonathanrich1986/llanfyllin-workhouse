<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Events extends Composer
{
    protected static $views = [
        'partials.flexible.events',
        'archive-event',
    ];

    public function with()
    {

        return [
            'title' => get_sub_field('title') ?? '',
            'titleSize' => get_sub_field('title_size') ?? 'medium',
            'subtitle' => get_sub_field('subtitle') ?? '',
            'content' => get_sub_field('content') ?? '',
            'card_template' => get_sub_field('card_template') ?: 'default',
            'events' => $this->getEvents(),
            'archive_url' => get_post_type_archive_link('event'),
        ];
    }

    /**
     * Get events and their dates.
     *
     * @return array
     */
    protected function getEvents(): array
    {

        $output = [
            'date_order' => [],
            'events' => [],
        ];

        $events = get_posts([
            'post_type' => 'event',
            'posts_per_page' => -1,
        ]);

        foreach ($events as $event) {

            $has_passed = true;
            $dates = [];

            foreach (get_field('dates', $event->ID) as $date) {
                $this_date = wr_datetime_from_format('Y-m-d',$date['date']);

                if ($this_date >= wr_datetime()) {
                    $has_passed = false;

                    $dates[$this_date->getTimestamp()] = [
                        'date' => $this_date,
                        'start_time' => $date['start_time'],
                        'end_time' => $date['end_time'],
                        'time_text' => $date['time_text'],
                    ];

                }
            }

            if (empty($dates) || $has_passed) {
                continue;
            }

            $category = get_the_terms($event, 'event_category')[0] ?? null;

            $this_event = [
                'title' => get_the_title($event),
                'content' => get_the_excerpt($event),
                'url' => get_permalink($event),
                'is_featured' => get_field('is_featured', $event->ID),
                'dates' => $dates,
                'date_text' => $this->formatDateRange(wp_list_pluck($dates, 'date')), 
                'entry_price' => get_field('entry_price', $event->ID),
                'car_parking_price' => get_field('car_parking_price', $event->ID),
                'booking_information' => get_field('booking_information', $event->ID),
                'booking_link' => get_field('booking_link', $event->ID),
                'poster' => get_field('poster', $event->ID),
                'gallery' => get_field('gallery', $event->ID),
                'featured_image' => acf_get_attachment(get_post_thumbnail_id($event->ID)),
                'category_name' => $category ? $category->name : null,
                'category_colour' => $category ? get_field('category_colour', $category) : null,
                'category_url' => $category ? get_term_link($category) : null,
            ];

            $first_date = reset($dates);
            $output['events'][$first_date['date']->getTimestamp() . '-' . $event->ID] = $this_event;
                
            foreach ($dates as $timestamp => $date) {
                $output['date_order'][$timestamp] = [
                    'event' => $this_event,
                    'date' => $date,
                ];
            }
        }

        // Sort events by date.
        ksort($output['date_order']);
        ksort($output['events']);

        return $output;
    }

    /**
     * Format a range of dates into a human-readable string.
     *
     * @param array $dates Array of DateTime objects.
     * @return string Formatted date range.
     */
    protected function formatDateRange(array $dates): string {
        if (empty($dates)) {
            return '';
        }

        // Ensure we are working with a sorted list if not already
        usort($dates, fn($a, $b) => $a <=> $b);

        $first = $dates[0];
        $last = $first;

        // Iterate to find the end of the consecutive sequence
        for ($i = 1; $i < count($dates); $i++) {
            // Check if the current date is exactly 1 day after the previous "last" date
            if ($dates[$i]->diff($last)->days === 1 && $dates[$i] > $last) {
                $last = $dates[$i];
            } else {
                // Sequence broken; ignore the rest as per requirements
                break;
            }
        }

        // If there is only one date or the sequence didn't move
        if ($first == $last) {
            return '<span class="date-range">' . $first->format('jS') . '</span> ' . $first->format('F');
        }

        $sameMonth = $first->format('n') === $last->format('n');
        $sameYear = $first->format('Y') === $last->format('Y');

        if ($sameMonth && $sameYear) {
            // Example: 11th-13th January 2026
            return '<span class="date-range">' . $first->format('jS') . '-' . $last->format('jS') . '</span> ' . $first->format('F');
        } elseif ($sameYear) {
            // Example: 30th January-1st February 2026
            return $first->format('jS M') . '-' . $last->format('jS M');
        } else {
            // Example: 30th December 2025-2nd January 2026
            return $first->format('jS M Y') . '-' . $last->format('jS M Y');
        }
    }

}
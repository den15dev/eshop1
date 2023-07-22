<?php


namespace App\Services\Admin;

use Illuminate\View\View;

class LogService
{
    /**
     * Reads log files prefixed with "events-" into an array.
     *
     * @param bool $today - if set, only last day will be output.
     * @return array
     */
    public function getEventsLog(bool $today = false): array
    {
        $logs = [];
        $log_dir = storage_path() . '/logs';
        $log_files_arr = array_diff(scandir($log_dir), array('..', '.'));

        $log_files_arr = array_filter($log_files_arr, function ($elem) {
            return preg_match('/^events-.+\.log$/', $elem);
        });

        if ($today) {
            $log_files_arr = array_slice($log_files_arr, count($log_files_arr) - 1);
        }

        foreach ($log_files_arr as $file) {
            $day_arr = [substr($file, 7, -4)];
            $content_arr = explode("\n", file_get_contents($log_dir . '/' . $file));
            $event_arr = [];
            $event = [];

            foreach ($content_arr as $line) {
                $line_arr = explode('local.INFO:', $line);
                if (count($line_arr) > 1) {
                    if (count($event)) {
                        array_push($event_arr, $event);
                    }

                    $date_full = trim(trim($line_arr[0]), '[]');
                    $date_arr = explode(' ', $date_full);
                    $text = trim($line_arr[1]);
                    $event = [$date_arr[1], $text];
                } elseif (count($event)) {
                    $event[1] = $event[1] . '<br>' . trim($line);
                }

            }

            if (count($event)) {
                array_push($event_arr, $event);
            }

            array_push($day_arr, array_reverse($event_arr));
            array_push($logs, $day_arr);
        }

        return array_reverse($logs);
    }


    public function getTodaysLogView(): View
    {
        $day_log = $this->getEventsLog(true)[0];

        return view('admin.includes.log-day-block', compact('day_log'));
    }
}

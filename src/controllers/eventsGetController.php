<?php
function group_by($key, array $ary): array
{
    $result = [];

    foreach ($ary as $row) {
        if (array_key_exists($key, $row)) {
            $result[$row[$key]][] = $row;
        } else {
            $result[""][] = $row[$key];
        }
    }

    return $result;
}
$events_stmt = $db->query('select id,name,start_at,end_at from events order by start_at asc;');
$events = $events_stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

$attendance_stmt = $db->query('select event_id,user_id,attendance_status from event_user_attendance order by attendance_status;');
$attendances = $attendance_stmt->fetchAll();
$event_user_attendances_grouped_by_event_id = group_by('event_id', $attendances);
foreach ($event_user_attendances_grouped_by_event_id as $event_id => $users) {
    $users_grouped_by_attendance_status=group_by('attendance_status',$users);
    $events[$event_id]=$events[$event_id]+array('attendance_status'=>$users_grouped_by_attendance_status);
};
print_r('<pre>');
var_dump($events);
// var_dump($grouped_by_attendances);
// var_dump($events);
print_r('</pre>');

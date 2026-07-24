<?php
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function getAllFutureActivities($conn)
{
    $sql = "SELECT * FROM activities WHERE activity_date >= CURDATE() ORDER BY activity_date, start_time";
    return mysqli_query($conn, $sql);
}

function getNextActivities($conn, $limit = 4)
{
    $limit = max(1, (int) $limit);
    $sql = "SELECT * FROM activities WHERE activity_date >= CURDATE() ORDER BY activity_date, start_time LIMIT $limit";
    return mysqli_query($conn, $sql);
}

function getActivityById($conn, $id)
{
    $stmt = mysqli_prepare($conn, "SELECT * FROM activities WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result) ?: null;
}

function validUniversityId($id)
{

    return (bool) preg_match('/^[A-Za-z0-9]{8,12}$/', $id);
}

function validSaudiMobile($number)
{
    return (bool) preg_match('/^(05\d{8}|(?:\+?966)5\d{8})$/', $number);
}

function countRegistrations($conn, $activityId)
{
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM participants WHERE activity_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $activityId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return (int) $row['total'];
}

function availablePlaces($conn, $activity)
{
    return max(0, (int) $activity['capacity'] - countRegistrations($conn, (int) $activity['id']));
}

function duplicateRegistration($conn, $universityId, $activityId)
{
    $stmt = mysqli_prepare($conn, "SELECT id FROM participants WHERE university_id = ? AND activity_id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'si', $universityId, $activityId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

function formatDate($date)
{
    return date('j F Y', strtotime($date));
}

function formatTime($time)
{
    return date('g:i A', strtotime($time));
}

<?php

$servername = "localhost";
$username = "root";
$password = "35883677";

try {
    $conn = new PDO("mysql:host=$servername;dbname=ArayeshgahReservation", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function getFreeStylists()
{
    global $conn;
    $query = $conn->prepare('SELECT name,id FROM stylists WHERE is_free = 1');
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $res = $query->fetchAll();
    $freeStylists = [];
    foreach ($res as $stylist) {
        array_push($freeStylists, $stylist);
    }
    return $freeStylists;
}

function getStylistByName($name)
{
    $freeStylists = getFreeStylists();
    foreach ($freeStylists as $stylist) {
        if ($stylist['name'] == $name) {
            return $stylist;
        }
    }
}

function getFreeDays($stylistId)
{
    global $conn;
    $query = $conn->prepare('SELECT * FROM weekdays WHERE is_free = 1 AND stylist_id = ?');
    $query->bindValue(1, $stylistId);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $res = $query->fetchAll();
    $freeDays = [];
    foreach ($res as $day) {
        array_push($freeDays, $day);
    }
    return $freeDays;
}

function getDayByName($name, $stylistId)
{
    $freeDays = getFreeDays($stylistId);
    foreach ($freeDays as $day) {
        if ($day['day'] == $name) {
            return $day;
        }
    }
}



function getFreeTimes($dayId)
{
    global $conn;
    $query = $conn->prepare('SELECT * FROM times WHERE is_free = 1 AND day_id = ?');
    $query->bindValue(1, $dayId);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $res = $query->fetchAll();
    $freeTimes = [];
    foreach ($res as $time) {
        array_push($freeTimes, $time);
    }
    return $freeTimes;
}
function getTimeByName($name, $dayId)
{
    $freeTimes = getFreeTimes($dayId);
    foreach ($freeTimes as $time) {
        if ($time['time'] == $name) {
            return $time;
        }
    }
}
function store($id, $data)
{
    global $conn;
    $query = $conn->prepare("INSERT INTO reserves (user_id , day , time , stylist , phone_number  ) VALUES (?,?,?,?,?)");
    $query->bindValue(1, $id);
    $query->bindValue(2, $data['day']);
    $query->bindValue(3, $data['time']);
    $query->bindValue(4, $data['stylist']);
    $query->bindValue(5, $data['phoneNumber']);
    $res =  $query->execute();
    return $res;
}

function setTimeToUnfree($id,$dayId)
{
    global $conn;
    $query = $conn->prepare("UPDATE times SET is_free = ? WHERE id = ? AND day_id = ?");
    $query->bindValue(1, 0);
    $query->bindValue(2, $id);
    $query->bindValue(3, $dayId);
    $res =  $query->execute();
    return $res;
}

function checkFreeTimesOfDay($dayId)
{
    global $conn;
    $query = $conn->prepare("SELECT  is_free FROM times WHERE day_id = ?");
    $query->bindValue(1,$dayId);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $res = $query->fetchAll();
    foreach ($res as $item){
        if ($item['is_free']){
            return true;
        }
    }
    return false;

}
function setDayToUnfree($id,$stylistId)
{
    global $conn;
    $query = $conn->prepare("UPDATE weekdays SET is_free = ? WHERE id = ? AND stylist_id = ?");
    $query->bindValue(1, 0);
    $query->bindValue(2, $id);
    $query->bindValue(3, $stylistId);
    $res =  $query->execute();
    return $res;
}

function checkDaysOfStylist($stylistId)
{
    global $conn;
    $query = $conn->prepare("SELECT  is_free FROM weekdays WHERE stylist_id = ?");
    $query->bindValue(1,$stylistId);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $res = $query->fetchAll();
    foreach ($res as $item){
        if ($item['is_free']){
            return true;
        }
    }
    return false;

}
function setStylistToUnfree($id)
{
    global $conn;
    $query = $conn->prepare("UPDATE stylists SET is_free = ? WHERE id = ?");
    $query->bindValue(1, 0);
    $query->bindValue(2, $id);
    $res =  $query->execute();
    return $res;
}

function getReserves()
{
    global $conn;
    $query = $conn->prepare("SELECT  * FROM reserves");
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $res = $query->fetchAll();
    return $res;
}

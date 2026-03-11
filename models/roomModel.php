<?php
require_once "./../config/database.php";
class roomModel extends database
{

    protected $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    protected function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
    public function getAll()
    {
        $sql = "
            SELECT 
    id,
    room_name,
    building,
    capacity,
    CASE 
        WHEN type = 'theory' THEN 'Phòng lý thuyết'
        WHEN type = 'lab' THEN 'Phòng máy'
        WHEN type = 'exam' THEN 'Phòng thi'
    END AS loai_phong
    FROM rooms";
        return $this->__query($sql);
    }

    public function addRoom($room_name,$building,$capacity,$type) {
        $sql = "
            INSERT INTO rooms(room_name, building, capacity, type)
            VALUES ('$room_name', '$building', '$capacity', '$type')";
        return $this->__query($sql);
    }


    public function editPhongHoc($id,$room_name,$building,$capacity,$type)
    {

        $sql = "
            UPDATE rooms
        SET 
            room_name = '$room_name',
            building = '$building',
            capacity = '$capacity',
            type = '$type'
        WHERE id = '$id'
        ";
        return $this->__query($sql);
    }
    public function checkName($room_name,$building)
    {

        $sql = "
        SELECT 1
        FROM rooms
        WHERE room_name = '$room_name'
        AND building = '$building'
    ";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }
    public function checkNameId($id,$room_name,$building)
    {

        $sql = "
        SELECT 1
        FROM rooms
        WHERE room_name = '$room_name'
        AND building = '$building'
        AND id != '$id'
    ";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }

    public function deleteRoom($id)
    {
        $sql = "delete from rooms where id= '$id'";
        return $this->__query($sql);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM rooms WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
}

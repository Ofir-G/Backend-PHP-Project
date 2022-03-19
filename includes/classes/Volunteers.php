<?php
require_once('database.php');

class Volunteers
{
    private $user_email;
    private $volunteer_num;
    private $date;

    public static function find_volunteering($email)
    {
        global $database;
        $result = $database->query("select * from volunteers where user_email='" . $email . "'");
        $volunteers = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $volunteering = new Volunteers();
                    $volunteering->instantation($row);
                    $volunteers[$i] = $volunteering;
                    $i += 1;
                }
            }
        }
        return $volunteers;
    }

    public static function fetch_volunteering()
    {
        global $database;
        $result = $database->query("select * from volunteers");
        $volunteers = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $volunteer = new Volunteers();
                    $volunteer->instantation($row);
                    $volunteers[$i] = $volunteer;
                    $i += 1;
                }
            }
        }
        return $volunteers;
    }

    public static function check_interest($volunteering)
    {
        return $volunteering[count($volunteering)-1]->volunteer_num;
    }

    public static function check_exist($email,$volunteer_num)
    {
        global $database;
        $result = $database->query("select * from volunteers where email='{$email}' and volunteer_num={$volunteer_num}");
        $error = 1;
        if ($result) {
            return $error;
        }
        return $error;
    }

    public static function add_user($email,$volunteer_num)
    {
        global $database;
        $today_date = date("Y-m-d");
        $error = null;
        $sql = "INSERT INTO volunteers(user_email, volunteer_num, date) VALUES ('{$email}','{$volunteer_num}','{$today_date}')";

        $result = $database->query($sql);
        if (!$result)
            $error = 'Can not add Volunteering.  Error is:' . $database->get_connection()->error;
        return $error;
    }

    private function has_attribute($attribute)
    {
        $object_properties = get_object_vars($this);
        return array_key_exists($attribute, $object_properties);
    }

    private function instantation($volunteers_array)
    {
        foreach ($volunteers_array as $attribute => $value) {
            if ($this->has_attribute($attribute))
                $this->$attribute = $value;
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

}
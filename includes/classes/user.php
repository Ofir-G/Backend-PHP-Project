<?php

require_once('database.php');

class User
{
    private $email;
    private $firstname;
    private $lastname;
    private $password;
    private $image;
    private $city;
    private $phone;
    private $birthdate;

    public function init($email, $firstname, $lastname, $phone, $city, $password, $image, $birthdate)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = md5($password);
        $this->city = $city;
        $this->phone = $phone;
        $this->birthdate = $birthdate;
        if ($image != null) {
            $this->image = $image;
        }
    }

    public static function fetch_users_age()
    {
        global $database;
        $result = $database->query("select * from users");
        $age_array = array(0, 0, 0, 0, 0);
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $age = date_diff(date_create($row["birthdate"]), date_create('now'))->y;
                    if ($age >= 10 && $age < 20) {
                        $age_array[0] += 1;
                    } elseif ($age >= 20 && $age < 30) {
                        $age_array[1] += 1;
                    } elseif ($age >= 30 && $age < 40) {
                        $age_array[2] += 1;
                    } elseif ($age >= 40 && $age < 50) {
                        $age_array[3] += 1;
                    } elseif ($age >= 50) {
                        $age_array[4] += 1;
                    }
                }
            }
        }
        return $age_array;
    }

    public static function fetch_users()
    {
        global $database;
        $result = $database->query("select * from users");
        $users = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $user = new User();
                    $user->instantation($row);
                    $users[$i] = $user;
                    $i += 1;
                }
            }
        }
        return $users;
    }

    private function has_attribute($attribute)
    {
        $object_properties = get_object_vars($this);
        return array_key_exists($attribute, $object_properties);
    }

    private function instantation($user_array)
    {
        foreach ($user_array as $attribute => $value) {
            if ($this->has_attribute($attribute))
                $this->$attribute = $value;
        }
    }

    public function find_user_by_email($email)
    {
        global $database;
        $error = null;
        $result = $database->query("select * from users where email='" . $email . "'");

        if (!$result)
            $error = 'Can not find the user.  Error is:' . $database->get_connection()->error;
        elseif ($result->num_rows > 0) {
            $found_user = $result->fetch_assoc();
            $this->instantation($found_user);
        } else
            $error = "Can not find user by this id";

        return $error;
    }

    public function login_cred_user($email, $password)
    {
        $password = md5($password);
        global $database;
        $error = '';
        $result = $database->query("select * from users where email='" . $email . "' and password='" . $password . "'");

        if (!$result)
            $error .= "<li> Something went wrong. Please try again. </li>";

        elseif ($result->num_rows > 0) {
            $found_user = $result->fetch_assoc();
            $this->instantation($found_user);
        } else
            $error .= "<li> Wrong user or password. Please try again. </li>";

        return $error;
    }

    public static function add_user($user)
    {
        global $database;
        $error = '';

        $sql = "INSERT INTO users(email ,firstname ,lastname ,phone ,city, password, image, birthdate) VALUES ('{$user->email}','{$user->firstname}','{$user->lastname}',{$user->phone},'{$user->city}','{$user->password}','{$user->image}','{$user->birthdate}')";

        $result = $database->query($sql);
        if (!$result) {
            $error .= "<li> Email is already registered. <li>";
        }
        return $error;
    }

    public static function count_cities()
    {
        global $database;
        $cities_count = array();
        $result = $database->query("select * from users  where city = 'Tel Aviv'");
        if ($result) {
            array_push($cities_count, $result->num_rows);
        }
        $result = $database->query("select * from users  where city = 'Petah Tikva'");
        if ($result) {
            array_push($cities_count, $result->num_rows);
        }
        $result = $database->query("select * from users  where city = 'Holon'");
        if ($result) {
            array_push($cities_count, $result->num_rows);
        }
        $result = $database->query("select * from users  where city = 'Jerusalem'");
        if ($result) {
            array_push($cities_count, $result->num_rows);
        }
        $result = $database->query("select * from users  where city = 'Haifa'");
        if ($result) {
            array_push($cities_count, $result->num_rows);
        }
        return $cities_count;
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

}
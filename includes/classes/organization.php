<?php

require_once('database.php');

class Organization
{
    private $id;
    private $name;
    private $phone;
    private $password;
    private $city;
    private $address;
    private $description;
    private $mission_statement;
    private $image;

    public function init($id, $name, $phone, $city, $address, $description, $mission_statement, $password, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->city = $city;
        $this->address = $address;
        $this->description = $description;
        $this->mission_statement = $mission_statement;
        $this->password = md5($password);
        if ($image != null) {
            $this->image = $image;
        }else{
            $this->image="no_image_available.jpg";
        }
    }

    public static function fetch_organizations()
    {
        global $database;
        $result = $database->query("select * from organizations");
        $organizations = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $organization = new Organization();
                    $organization->instantation($row);
                    $organizations[$i] = $organization;
                    $i += 1;
                }
            }
        }
        return $organizations;
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

    public function login_cred_organ($id, $password)
    {
        global $database;
        $error = '';
        $password = md5($password);
        $result = $database->query("select * from organizations where id='" . $id . "' and password='" . $password . "'");

        if (!$result)
            $error .= "<li> Something went wrong. Please try again. </li>";
        elseif ($result->num_rows > 0) {
            $found_organ = $result->fetch_assoc();
            $this->instantation($found_organ);
        } else
            $error .= "<li> Wrong user or password. Please try again. </li>";

        return $error;
    }

    public function find_organ_by_id($id)
    {
        global $database;
        $error = null;
        $result = $database->query("select * from organizations where id='" . $id . "'");

        if (!$result)
            $error = 'Can not find the organization.  Error is:' . $database->get_connection()->error;
        elseif ($result->num_rows > 0) {
            $found_user = $result->fetch_assoc();
            $this->instantation($found_user);
        } else
            $error = "Can not find organization by this id";

        return $error;
    }

    public static function add_organization($organization)
    {
        global $database;
        $error = '';
        $sql = "INSERT INTO organizations(id ,name ,phone ,city ,address, description, mission_statement, password, image) VALUES ({$organization->id},'{$organization->name}',{$organization->phone},'{$organization->city}','{$organization->address}','{$organization->description}','{$organization->mission_statement}','{$organization->password}','{$organization->image}')";

        $result = $database->query($sql);
        if (!$result)
            $error = '<li>ID is already registered.</li>';
        return $error;
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

}

?>
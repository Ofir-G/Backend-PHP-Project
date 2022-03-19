<?php

require_once('database.php');

class VolunteerPlace
{
    private $number;
    private $name;
    private $organization;
    private $field;
    private $location;
    private $description;
    private $image;
    private $date;

    public function init($name, $organization, $field, $location, $description, $file)
    {
        $this->name = $name;
        $this->organization = $organization;
        $this->field = $field;
        $this->location = $location;
        $this->description = $description;
        $this->date = date("Y-m-d");
        if ($file != null) {
            return $this->fileUpload($file);
        } else {
            $this->image = "no_image_available.jpg";
        }
        return true;
    }

    public static function fetch_places()
    {
        global $database;
        $result = $database->query("select * from volunteerplaces");
        $volunteer_places = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $volunteer_place = new VolunteerPlace();
                    $volunteer_place->instantation($row);
                    $volunteer_places[$i] = $volunteer_place;
                    $i += 1;
                }
            }
        }
        return $volunteer_places;
    }

    public function fileUpload($file)
    {
        $target_dir = "../pics/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $error = "";

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error .= "<li>File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $this->image = basename($file["name"]);
            $uploadOk = 0;
        }

        // Check file size
        if ($file["size"] > 5242880) {
            $error .= "<li>File is too large. Make sure it's under 5MB.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $error .= "<li>Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // if everything is ok, try to upload file
        if ($uploadOk == 1) {
            $this->image = basename($file["name"]);
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $this->image = basename($file["name"]);
            } elseif (empty($error)) {
                $error .= "<li>Sorry, there was an error uploading your file. Please try again.";
            }
        } elseif (!empty($error)) {
            $error_file = "<li>File Check...</li><ul>";
            $error_file .= $error . "</ul>";
            echo $error_file;
            return false;
        }
        return true;

    }


    public function fetch_place_by_num($num)
    {
        global $database;
        $error = null;
        $result = $database->query("select * from volunteerplaces where number={$num}");
        if (!$result)
            $error = 'Can not find the user.  Error is:' . $database->get_connection()->error;

        elseif ($result->num_rows > 0) {
            $found_place = $result->fetch_assoc();
            $this->instantation($found_place);
        } else
            $error = "Can no find user by this id";

        return $error;
    }

    public static function fetch_places_by_organ($num)
    {
        global $database;
        $result = $database->query("select * from volunteerplaces where organization={$num}");
        $volunteer_places = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $volunteer_place = new VolunteerPlace();
                    $volunteer_place->instantation($row);
                    $volunteer_places[$i] = $volunteer_place;
                    $i += 1;
                }
            }
        }
        return $volunteer_places;
    }


    public static function fetch_places_by_location($location)
    {
        global $database;
        $result = $database->query("select * from volunteerplaces where location = '{$location}'");
        $volunteer_places = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $volunteer_place = new VolunteerPlace();
                    $volunteer_place->instantation($row);
                    $volunteer_places[$i] = $volunteer_place;
                    $i += 1;
                }
            }
        }
        return $volunteer_places;
    }

    public static function fetch_places_by_field($field)
    {
        global $database;
        $result = $database->query("select * from volunteerplaces where field = '{$field}'");
        $volunteer_places = null;
        if ($result) {
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $volunteer_place = new VolunteerPlace();
                    $volunteer_place->instantation($row);
                    $volunteer_places[$i] = $volunteer_place;
                    $i += 1;
                }
            }
        }
        return $volunteer_places;
    }

    public static function fetch_most_loved()
    {
        global $database;
        $result = $database->query("SELECT volunteer_num FROM volunteers GROUP BY volunteer_num HAVING COUNT(*) >= ALL (SELECT COUNT(*) AS cnt FROM volunteers GROUP BY volunteer_num)");
        $error = null;

        if (!$result) {
            $error = 'Can not find the user.  Error is:' . $database->get_connection()->error;
        } elseif ($result->num_rows > 0) {
            $found_place = $result->fetch_assoc();
            return $found_place;
        } else
            $error = "Can no find user by this id";
        return $error;
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

    public static function add_volunteer_place($place)
    {
        global $database;
        $error = '';

        $todaydate = date("Y-m-d");

        $sql = "INSERT INTO volunteerplaces(name ,organization ,field ,	location ,description, image, date) VALUES ('{$place->name}','{$place->organization}','{$place->field}', '{$place->location}', '{$place->description}','{$place->image}','{$todaydate}')";
        $result = $database->query($sql);
        if (!$result) {
            $error .= "<li> Error: <li>" . $database->get_connection()->error;
        }
        return $error;
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    public static function delete_volunteer_place($place_num)
    {
        global $database;
        $error = '';

        $sql = "DELETE FROM volunteerplaces WHERE number = $place_num";
        $result = $database->query($sql);
        if (!$result) {
            $error .= "<li> Error: <li>" . $database->get_connection()->error;
        }
        return $error;
    }


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Rohirrim Tour booking confirmation">
    <meta name="keywords" content="PHP, forms, server-side validation">
    <meta name="author" content="Goat">
    <title>Booking Confirmation</title>
</head>
<body>
    <h1>Rohirrim Tour Booking Confirmation</h1>
<?php
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $firstname  = isset($_POST["firstname"]) ? clean_input($_POST["firstname"]) : "";
        $lastname   = isset($_POST["lastname"])  ? clean_input($_POST["lastname"])  : "";
        $age        = isset($_POST["age"])       ? clean_input($_POST["age"])       : "";
        $food       = isset($_POST["food"])      ? clean_input($_POST["food"])      : "";
        $party_size = isset($_POST["partysize"]) ? clean_input($_POST["partysize"]) : "";

        $species_names = array("M" => "Human", "D" => "Dwarf", "E" => "Elf", "H" => "Hobbit");
        $species_code  = isset($_POST["species"]) ? clean_input($_POST["species"]) : "";
        $species       = isset($species_names[$species_code]) ? $species_names[$species_code] : "";

        $tours = array();
        if (isset($_POST["accom"])) $tours[] = "Accommodation";
        if (isset($_POST["4day"]))  $tours[] = "Four-day tour";
        if (isset($_POST["10day"])) $tours[] = "Ten-day tour";

        $errors = array();
        if (empty($firstname)) $errors[] = "First name is required.";
        if (empty($lastname))  $errors[] = "Last name is required.";
        if (empty($species))   $errors[] = "Please select a species.";
        if (empty($tours))     $errors[] = "Please select at least one booking.";
        if (!is_numeric($age) || $age < 1)               $errors[] = "Age must be a positive number.";
        if (!is_numeric($party_size) || $party_size < 1) $errors[] = "Number of travellers must be at least 1.";

        if (!empty($errors)) {
            echo "<p>Your booking could not be processed:</p>\n<ul>\n";
            foreach ($errors as $error) {
                echo "<li>$error</li>\n";
            }
            echo "</ul>\n<p><a href=\"register.html\">Go back to the form</a></p>\n";
        } else {
            $tour_list = implode(" and ", $tours);
            echo "<p>Welcome $firstname $lastname !<br>\n"
               . "You are now booked on the $tour_list<br>\n"
               . "Species: $species<br>\n"
               . "Age: $age<br>\n"
               . "Meal Preference: $food<br>\n"
               . "Number of travellers: $party_size</p>\n";
        }
    } else {
        echo "<p>No booking data received. Please use the <a href=\"register.html\">booking form</a>.</p>\n";
    }
?>
</body>
</html>

<?php
require_once('dbsettings.php');

//Open a new connection to the MySQL server
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
or die('Error connecting to the database');
//**************************************************************************************************************************************************************************************//
//-----------------------------------------------------------------------------------Database connection data----------------------------------------------------------------------------
//**************************************************************************************************************************************************************************************//

session_start();
$id = $_SESSION['id'];
if (isset($_SESSION['id]'])) $id = $_SESSION['id'];

if(isset($_POST['mytext']) && isset($_POST['submitdate'])
    && isset($_POST['usersubmit']) && isset($_POST['week']) &&
    isset($_POST['status'])
    && isset($_POST['projectnr']) && isset($_POST['namecustomer'])
    && isset($_POST['adres']) && isset($_POST['city'])
    && isset($_POST['activities'])) {


//Output any connection error
    if ($dbc->connect_error) {
        die('Error : (' . $dbc->connect_errno . ') ' . $dbc->connect_error);
    }


    $capture_field_vals = "";
    foreach ($_POST["mytext"] as $key => $text_field) {
        $capture_field_vals .= $text_field . ", ";
    }
    $captured_field_vals_workers = $_POST["workers"];


    $captured_field_vals_hours = $_POST["myhours"];

    $date = $_POST['submitdate'];
    $user = $_POST['usersubmit'];
    $week = $_POST['week'];
    $radio = $_POST['status'];
    $projectnr = $_POST['projectnr'];
    $namecustomer = $_POST['namecustomer'];
    $adres = $_POST['adres'];
    $city = $_POST['city'];
    $activities = $_POST['activities'];

}
if(!empty($id))
{$insert_row = $dbc->query("SELECT 1 FROM orders WHERE id='$id' LIMIT 1");
    $workers = count($captured_field_vals_workers);

    if (mysqli_fetch_row($insert_row)) {
        $insert_row = $dbc->query("UPDATE orders SET submitdate = '$date', submitter = '$user', week ='$week', status = '$radio', projectnr ='$projectnr',
                                          customer_name = '$namecustomer', customer_adres = '$adres', customer_city = '$city', activity_description = '$activities', captured_fields = '$capture_field_vals' WHERE id = '" . $id . "'");
        //TODO: uren update query
        $i=0;
        $hours_count =0;
        while ($i < $workers) {
            echo $captured_field_vals_workers[$i];
            //TODO MEEDERE WERKERS KUNNEN OPSLAAN
            $insert_row2 = $dbc->query("SELECT 1 FROM uren WHERE first_name='$captured_field_vals_workers[$i]' AND week='$week' AND projectnr='$projectnr'");
        if (mysqli_fetch_row($insert_row2)) {
            $insert_row2 = $dbc->query("UPDATE uren SET first_name = '$captured_field_vals_workers[$i]', week = '$week', projectnr ='$projectnr', monday = '$captured_field_vals_hours[0]', tuesday = '$captured_field_vals_hours[1]',wednesday = '$captured_field_vals_hours[2]',
                                          thursday = '$captured_field_vals_hours[3]', friday = '$captured_field_vals_hours[4]' WHERE first_name='$captured_field_vals_workers[$i]' AND week='$week' AND projectnr='$projectnr'");

            //delete 5 array values from captured_field_vals_hours
            array_splice($captured_field_vals_hours, 0, 5);
        }
            $i++;
        }
    }}else {
    $insert_row = $dbc->query("INSERT INTO orders ( submitdate, submitter, week, status, projectnr, customer_name, customer_adres, customer_city, activity_description, captured_fields )
                                  VALUES( '$date', '$user', '$week', '$radio', '$projectnr', '$namecustomer', '$adres', '$city', '$activities', '$capture_field_vals' )");

    //SQL insert query for workers name and hours
    $workers = count($captured_field_vals_workers);

    $i=0;
    $hours_count =0;
    while ($i < $workers) {

        $insert_hours_row = $dbc->query("INSERT INTO uren ( first_name, week, projectnr, monday, tuesday, wednesday, thursday, friday)
                                  VALUES( '$captured_field_vals_workers[$i]', '$week', '$projectnr', '$captured_field_vals_hours[0]','$captured_field_vals_hours[1]','$captured_field_vals_hours[2]','$captured_field_vals_hours[3]','$captured_field_vals_hours[4]' )");
        $i++;
        //delete 5 array values from captured_field_vals_hours
        array_splice($captured_field_vals_hours, 0, 5);
    }

}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head lang="nl" >
    <title>Formulier Bewerken</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/webstyle.css" type="text/css" />

    <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>
<body class="backimage">

<?php
if(isset($_POST['namecustomer'])) {

    if ($dbc->connect_error) {
        die('Error : (' . $dbc->connect_errno . ') ' . $dbc->connect_error);
    }
    //echo $_POST['workers'];
    $date = $_POST['submitdate'];
    $user = $_POST['usersubmit'];
    $week = $_POST['week'];
    $radio = $_POST['status'];
    $projectnr = $_POST['projectnr'];
    $namecustomer = $_POST['namecustomer'];
    $adres = $_POST['adres'];
    $city = $_POST['city'];
    $activities = $_POST['activities'];

    $captured_field_vals_workers = $_POST['workers'];


    $captured_field_vals_hours = $_POST['myhours'];


    $capture_field_vals = "";
    foreach ($_POST["mytext"] as $key => $text_field) {
        $capture_field_vals .= $text_field . ", ";
    }

    if($radio === "0"){
        $status = '<p>Ja</p>';
    }elseif($radio === "1"){
        $status = '<p>Nee</p>';
    }

    echo "<table class='table'><tr><th>Werkweek:</th><th>Naam klant:</th></tr>";
    echo "<tr><td>" . $week . "</td>
        <td>" . $namecustomer . "</td></tr>";
    echo "<tr><th>Werk gereed:</th><th>Adres:</th></tr>";
    echo "<tr><td>" . $status . "</td>
        <td>" . $adres . "</td></tr>";
    echo "<tr><th>Project nr:</th><th>Woonplaats:</th></tr>";
    echo "<tr><td>" . $projectnr . "</td>
        <td>" . $city . "</td></tr>";



    echo "</br >";

    echo "<tr><th> Omschrijving werkzaamheden:</th></tr>";
    echo "<tr><td>" . $activities . "</td></tr>";

    //uren
    $exploded = $captured_field_vals_hours;
    echo "<tr><th>Werknemer:</th><th>Maandag:</th><th>Dinsdag:</th><th>Woensdag:</th><th>Donderdag:</th><th>Vrijdag:</th></tr>";
    $count =0;
    $workers=count($captured_field_vals_workers);
    $workerscount=0;
    $workersloop= 0;
    $total=0;
    echo '<tr>';
    foreach($exploded as $value)
    {
        if($count <= 3) {
            if($workerscount < $workers && $workerscount == 0)
            {
                echo "<td>" . $captured_field_vals_workers[$workersloop] . "</td>";
                $workersloop ++;
            }
            $count ++;
            $workerscount ++;
            echo "<td>" . $value . "</td>";
        }else{
            echo "<td>" . $value . "</td>";
            echo "</tr>";
            echo "<tr>";
            $count =0;
            $workerscount =0;
            unset($exploded[$total]);
        }
        $total++;

    }


    //materialen
    $exploded = explode(", ",$capture_field_vals);
    echo "<tr><th>Aantal:</th><th>Art.nr:</th><th>Omschrijving:</th><th>Leverancier:</th></tr>";
    $count =0;
    $total=0;
    echo '<tr>';
    foreach($exploded as $value)
    {
        if($count <= 2) {
            $count ++;
            echo "<td>" . $value . "</td>";
        }else{
            echo "<td>" . $value . "</td>";
            echo "</tr>";
            echo "<tr>";
            $count =0;
            unset($exploded[$total]);
        }
        $total++;

    }
echo "</table>";
}else{
    echo "<p>Geen formulier selecteerd of ingevuld!</p>";

}




if (isset($_SESSION['id'])){$_SESSION['id'] = '';}


echo '<a href="index.php" class="btn btn-danger btn-lg" role="button"><span class="glyphicon glyphicon-list-alt"></span> <br/><p class="button-text">Menu</p></a>'

?>

</body>
</html>

<?php
require "../../../Others/Shared_Files/establishConnection.php";
$connection = establishConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $husbandCNIC = $_POST['Husband_CNIC'];
    $wifeCNIC = $_POST['Wife_CNIC'];
    $divorceDate = $_POST['Divorce_Date'];

    if(marrigeExists($husbandCNIC, $wifeCNIC) == true){
        $marriageID = getMarriageID($husbandCNIC, $wifeCNIC);
        setMarriageTo_Divorced($marriageID);
        echo "Divorce has been registered!". " <br>". PHP_EOL;
    }else echo "This marraige is not found inside database!". " <br>". PHP_EOL;

}

function marrigeExists($spouse1, $spouse2){ //Return true if the marriage is between the two partners and if the status
    //of the marriage is active

    global $connection;

    $query_select_marriages = "SELECT COUNT(*) as noOfMarriages FROM marriages WHERE spouse1_cnic = '$spouse1' AND spouse2_cnic = '$spouse2' AND status = 'active'";
    $rawData = mysqli_query($connection, $query_select_marriages);
    $data = mysqli_fetch_assoc($rawData);

    if ($data["noOfMarriages"] > 0){
        return true;
    }else return false;

}

function getMarriageID($spouse1, $spouse2){

    global $connection;

    $query_select_marriages = "SELECT id FROM marriages WHERE spouse1_cnic = '$spouse1' AND spouse2_cnic = '$spouse2'";
    $rawData = mysqli_query($connection, $query_select_marriages);
    $data = mysqli_fetch_assoc($rawData);

    return $data["id"];
}

function setMarriageTo_Divorced($marriageID){

    global $connection;

    $query_update_marriages = "UPDATE marriages SET status = 'divorced' WHERE id = '$marriageID'";
    mysqli_query($connection, $query_update_marriages);
}

?>

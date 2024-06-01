<?php 
session_start();
$action = $_POST['action'] ?? '';

switch ($action){
    case 'init':
        init();
        break;
    case 'inputData':
        PutData();
        break;
}

function init() {
    include '../application/db.php';
    $id_product = $_POST['id_product'];
    $id_product = substr($id_product, 0, -1);
    $test_query = 'SELECT id, name, price FROM merchandise WHERE id IN ('.$id_product.')';
    $result = mysqli_query($conn, $test_query);
    $out1 = array();
    while($row = mysqli_fetch_assoc($result)){
        $out1[$row["id"]] = $row;
    }
    echo json_encode($out1);
    mysqli_close($conn);
}

function PutData(){
    include '../application/db.php';
    if(isset($_POST['Data_Order'])){
        $Data_Order = $_POST['Data_Order'];

        $arrProd = explode(',', substr($Data_Order["product"], 0, -1));
        $arrPrice = explode(',', substr($Data_Order["price"], 0, -1));
        $arrCount = explode(',', substr($Data_Order["count_product"], 0, -1));
        $arrSum = explode(',', substr($Data_Order["summa"], 0, -1));

        $userid = $_SESSION["id"];

        $query = "SELECT email FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt ->bind_param("i",$userid);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();
        $Data_Order["users"] = $email;

        for($i = 0; $i < count($arrProd); $i++){
            $product = mysqli_real_escape_string($conn, $arrProd[$i]);
            $price = mysqli_real_escape_string($conn, $arrPrice[$i]);
            $count = mysqli_real_escape_string($conn, $arrCount[$i]);
            $sum = mysqli_real_escape_string($conn, $arrSum[$i]);

            $StrQuery = 'INSERT INTO social.order (`num_order`, `date_order`, `users`, `product`, `price`, `count_product`, `summa`, `paid`) 
                         VALUES ('.$Data_Order["num_order"].', "'.$Data_Order["date_order"].'", "'.$Data_Order["users"].'", "'.$product.'", "'.$price.'", "'.$count.'", "'.$sum.'", 0)';
            $rez = mysqli_query($conn, $StrQuery);
        }
        mysqli_close($conn);
    }
}
?>

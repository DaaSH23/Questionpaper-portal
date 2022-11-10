<?php
$course = $_POST['course'];
$dept = $_POST['dept'];
$sem = $_POST['sem'];
$term = $_POST['term'];
$year = $_POST['year'];
$papercode = $_POST['papercode'];
// $myfiles = $_POST['myfiles'];

$filename = $_FILES['myfiles']['name'];
$destination = 'uploads/' . $filename;

$extension = pathinfo($filename,PATHINFO_EXTENSION);

$file = $_FILES['myfiles']['tmp_name'];

move_uploaded_file($file,$destination);




if(!empty($course) || !empty($dept) || !empty($sem) || !empty($term) || !empty($year) || !empty($papercode) || !empty($filename)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "prevquestions";

    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);


    if(mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    } else {        

        // if(isset($_POST['upld']))
        // {   
        //     if(!in_array($extension,['zip','pdf'])) {
        //         echo "file must be in pdf";
        //     } elseif($_FILES['myfiles']['size'] > 100000000){
        //         echo "file is too large";
        //     }else{
        //         if(move_uploaded_file($file, $destination))
        //         {
        //             $sql = "INSERT INTO papers (files) values('$filename')"; 
    
        //             if(mysqli_query($conn,$sql))
        //             {
        //                 echo "file uploaded";
        //             }
        //             else {
        //                 echo "failed to upload";
        //             }
        //         }
        //     }
        // }

        $SELECT = "SELECT papercode FROM papers WHERE papercode = ? Limit 1";
        // $SELECT = "SELECT files FROM papers WHERE files = ? Limit 1";
        $INSERT = "INSERT INTO papers (course, dept, sem, term, year, papercode, files) values(?, ?, ?, ?, ?, ?, ?)";
        // $sql = "INSERT INTO papers (files) values('$filename')"; 
        //prepare statement
        // $stmt = $conn->prepare($SELECT);
        // $stmt->bind_param("s", $papercode);
        // $stmt->execute();
        // $stmt->bind_result($papercode);
        // $stmt->store_result();
        // $rnum = $stmt->num_rows; 
        
        //prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $papercode);
        $stmt->execute();
        $stmt->bind_result($papercode);
        $stmt->store_result();
        $rnum = $stmt->num_rows; 

        if($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssisiss", $course, $dept, $sem, $term, $year, $papercode, $filename);
            $stmt->execute();
            echo "New record inserted sucessfully";
        } else {
            echo "you already inserted this papercode";
        }

        $stmt->close();
        $conn->close();


    }


} else {
    echo "All fields are required";
    die();
}

// if(isset($_POST['upld']))
        // {   
        //     if(!in_array($extension,['zip','pdf'])) {
        //         echo "file must be in pdf";
        //     } elseif($_FILES['myfiles']['size'] > 100000000){
        //         echo "file is too large";
        //     }else{
        //         if(move_uploaded_file($file, $destination))
        //         {
        //             $sql = "INSERT INTO papers (files) values('$filename')"; 
    
        //             if(mysqli_query($conn,$sql))
        //             {
        //                 echo "file uploaded";
        //             }
        //             else {
        //                 echo "failed to upload";
        //             }
        //         }
        //     }
        // }

?>


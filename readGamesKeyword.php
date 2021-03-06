<?php
   ini_set('display_errors', 1);
   include 'databaseInfo.php';
   $keywords = $_POST['key'];
   //$keywords = "inal";
   //$keywords = "bright";
   $preparedString = "%" . $keywords . "%";

   //get all the rows in the mysql database
   $stmt = $db->prepare("SELECT item.item_id, item.price, item.quantity, video_game.title, video_game.publisher, video_game.rating, video_game.platform,
     video_game.genre FROM (video_game NATURAL JOIN item) WHERE video_game.title LIKE ?");
   $stmt->bind_param("s", $preparedString);
   $stmt->execute();

   $result = $stmt->get_result();
   $rows = $result->num_rows;

   mysqli_stmt_close($stmt);

   $jsonArray = array();
   header('Content-Type: application/json'); // This line will make your ajax be okay with the json response

   while($row = mysqli_fetch_assoc($result)) { //Returns an associative array of strings representing fetched row in the result set with each key being the name of the field
        $jsonArray[] = $row;
    }
    echo json_encode($jsonArray);
  ?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SCP Files</title>
        <link rel="stylesheet" href="style.css">
    </head> 
    <body class="container">
        <?php include "connection.php"; ?>
        <h1>SCP files</h1>
        
        <nav>
            <a href="index.php">Index Page</a>
            
            <?php foreach ($result as $link): ?>
                <a href="index.php?link=<?php echo $link['subject']; ?>"><?php 
                echo $link['subject']; ?></a>
            <?php endforeach; ?>
            
            <a href="create.php">Add a New Record</a>
        </nav>
        
        <div>
            <?php 
                if(isset($_GET['link']))
                {
                    //save link to get value as a variable
                    $model = $_GET['link'];
                    
                    //prepared statement
                    $stmt = $connection->prepare("select * from scp where subject = ?");
                    if(!$stmt)
                    {
                        echo "<p>Error in preparing SQL statement</p>";
                    exit; 
                    }
                    $stmt->bind_param("s", $model);
                    
                    if($stmt->execute())
                    {
                        $result = $stmt->get_result();
                        
                        // check if a record has been retrieved
                        if($result->num_rows > 0)
                        {
                        $array = array_map('htmlspecialchars', $result->fetch_assoc());
                        $update = "update.php?update=" . $array['id'];
                        $delete = "index.php?delete=" . $array['id'];
                        
                        
                        echo "<div>
                            <h2>{$array['subject']}</h2>
                            <h2>{$array['class']}</h3>
                            <p><img src='{$array['image']}' alt='{$array['subject']}' class='scp-image'></p>
                            <p>{$array['containment']}</p>
                            <p>{$array['description']}</p>
                            <p>
                            <a href='{$update}' class='upd-link'>Update Record</a>
                            <a href='{$delete}' class='del-link'>Delete Record</a>
                            </p>
                            </div>";
                        
                    }
                    else
                    {
                        echo "<p>No record found for this model: {$array['subject']}</p>";
                    }
                }
                else
                {
                    echo "<p>Error executing the statement, {$stmt->error}</p>";
                }
                
              }
              else
              {
                  echo"
                  <p>Welcome to this SCP site.</p>";
              }
              
              //delete record
              if(isset($_GET['delete']))
              {
                  $delID = $_GET['delete'];
                  $delete = $connection->prepare("delete from scp where id=?");
                  $delete->bind_param("i", $delID);
                  
                  if($delete->execute())
                  {
                      echo "<div>Recorded Deleted...</div>";
                      
                  }
                  else
                  {
                      echo "<div>Error deleting record{$delete->error}.</div>";
                  }
              }
             
            ?>
            
        </div>
        
        
        
        
    </body>
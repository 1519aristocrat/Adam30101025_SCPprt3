<!doctype html>
<html lang="en">
  <head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update a record</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body class="container">
      
      <?php
      // Enable error reporting
            error_reporting(E_ALL);

            // Display errors
            ini_set('display_errors', 1);
     
            include "connection.php";
            
            // initialise $row as empty array
            $row = [];
            
            // directed from index page record [update] button
            if(isset($_GET['update']))
            {
                $id = $_GET['update'];
                // based on id select appropriate record from db
                $recordID = $connection->prepare("select * from scp where id = ?");
                
                if(!$recordID)
                {
                    echo "<div class='alert alert-danger p-3 m-2'>Error preparing record for updating.</div>";
                    exit;
                }
                
                $recordID->bind_param("i", $id);
                
                if($recordID->execute())
                {
                    echo "<div class='alert alert-success p-3 m-2'>Record ready for updating.</div>";
                    $temp = $recordID->get_result();
                    $row = $temp->fetch_assoc();
                }
                else
                {
                    echo "<div alert alert-danger p-3 m-2>Error: {$recordID->error}</div>";
                }
            }
            
           if(isset($_POST['update']))
           {
                // write a prepare statement to update data
                $update = $connection->prepare("update scp set subject=?, class=?, containment=?, image=?, description=?  where id=?");
            
                $update->bind_param("ssssss", $_POST['subject'], $_POST['class'], $_POST['containment'], $_POST['image'], $_POST['description'], $_POST['id']);
                
                if($update->execute())
                {
                    echo "<div class='alert alert-success p-3 m-2'>Record updated successfully</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger p-3 m-2'>Error: {$update->error}</div>";
                }
           }
           
        

      ?>
      
      
    <h1>Update record</h1>
    
    <p class="back-index"><a href="index.php">Back to index page.</a></p>
    
    <form method="post" action="update.php" class="form-group">
        <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
        <label>SCP Subject:</label>
        <br>
        <input type="text" name="subject" placeholder="subject..." class="form-control" value="<?php echo isset($row['subject']) ? $row['subject'] : ''; ?>">
        <br><br>
        
        <label>Class:</label>
        <br>
        <input type="text" name="class" placeholder="class..." class="form-control" value="<?php echo isset($row['class']) ? $row['class'] : ''; ?>">
        <br><br>
        
        <label>Containment:</label>
        <br>
        <textarea name="containment" class="form-control"><?php echo isset($row['containment']) ? $row['containment'] : ''; ?></textarea>
        <br><br>
        
        <label>Image:</label>
        <br>
        <input type="text" name="image" placeholder="images/name_of_image.png" class="form-control" value="<?php echo isset($row['image']) ? $row['image'] : ''; ?>">
        <br><br>
        
        <label>Description:</label>
        <br>
        <textarea name="description" class="form-control"><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea>
        
        
        <input type="submit" name="update" value="Update Record" class="btn btn-primary">
        
    </form>
      
  </body>
    

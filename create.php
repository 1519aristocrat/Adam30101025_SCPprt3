<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SCP Files</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="container">
        <?php
        
            include "connection.php";
            
            if(isset($_POST['submit']))
            {
                //write a prepared statement to insert data
                $insert = $connection->prepare("insert into scp(subject, class, image, containment, description) values (?, ?, ?, ?, ?)");
                $insert->bind_param("sssss", $_POST['subject'], $_POST['class'], $_POST['image'], $_POST['containment'], $_POST['description']);
                
                if($insert->execute())
                {
                    echo "
                    <div>Record Successfully Created</div>";
                    
                }
                else
                {
                    echo "
                    <div>Error: {$insert->error}</div>";
                }
            }

        ?>
        <h1>Create a New Record.</h1>
        <p class="back-index"><a href="index.php">Back to Index Page</a></p>
        <div>
            <form method="post" action="create.php">
                <label>Enter SCP subject:</label>
                <br>
                <input type="text" name="subject" placeholder="Subject..." class="form-control" required>
                <br><br>
                <label>Enter a Image</label>
                <br>
                <input type="text" name="image" placeholder="images/nameofimage.png..." class="form-control">
                <br><br>
                <label>Enter the class</label>
                <br>
                <input type="text" name="class" placeholder="class..." class="form-control">
                <br><br>
                <label>Enter the containment procedure</label>
                <br>
                <input type="text" name="containment" placeholder="containment..." class="form-control">
                <br><br>
                <label>Enter the description</label>
                <br>
                <input type="text" name="description" placeholder="containment..." class="form-control">
                <br><br>
                <input type="submit" name="submit" class="btn btn-primary">
            </form>
        </div>
        
    </body>
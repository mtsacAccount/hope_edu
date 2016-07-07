<?php
    include('../includes/header.php');
    
     if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        // Establish database connection
        $mysqli = new mysqli('localhost', 'root', '', 'mtsac');
        $mysqli->set_charset('utf8');
        
        // Build Query
        $query = "INSERT INTO `academic_programs` 
        (title, building, email, phone, map_url, more_info_url)
        VALUES (?, ?, ?, ?, ?, ?)";
        
        // Prep statement
        $stmt = $mysqli->prepare($query);
        
        // Bind the variables 'ssssss' -> all field inputs will be strings
        $stmt -> bind_param('ssssss', $title, $building, $email, $phone, $map_url, $more_info_url);
        
        // Assign the variables values and strip any code
        $title = (string) strip_tags($_POST["title"]);
        $building = (string) strip_tags($_POST['building']);
        $email = (string) strip_tags($_POST['email']);
        $phone = (string) strip_tags($_POST['phone']);
        $map_url = (string) strip_tags($_POST['map_url']);
        $more_info_url = (string) strip_tags($_POST['more_info_url']);
        
        // Execute the statement
        $stmt->execute();
        
        
        // Check if db is updated
        if ($stmt->affected_rows == 1) {
            echo "<div class=\"alert alert-success text-center\">
                    <a href= \"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                    <strong>New Academic Program Data has been succesfully inserted into database!</strong>
                  </div>";
        } else {
             echo "<div class=\"alert alert-danger text-center\"
                      <a href= \"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                      <strong>Error:</strong> " . $stmt->error . "
                   </div";
        }
        
         // Close the statement
         $stmt->close();
         unset($stmt);
         
         // Close the connection
         $mysqli->close();
         unset($mysqli);
        
     }
    
    
    
?>

      <div class="container">
        <div class="row">
             <div class="col-lg-12 text-center">
                <h1>Admin</h1>
                <h2>Academic Programs</h2>
                <hr />
             </div>
         </div>
      <div class="row">
      
      <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8">
        <h3 class='text-center'><strong>New Program Info</strong></h3>  
        <hr>
        <form method="POST" role="form" action="add_program.php" style="border: 2px solid maroon; padding: 20px;">
            
            <div class="row">
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label for="title" class="h4">Program title</label>
                <input id="title" type="text" name="title" minlength=5 maxlength=40 
                placeholder="Program title" required class="form-control"/>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label for="email" class="h4">Email</label>
                <input id="email" type="email" name="email" placeholder="Email" required class="form-control"/>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label for="map_url" class="h4">Map URL</label>
                <input id="map_url" type="text" name="map_url" minlength=5 maxlength=40 
                placeholder="Map URL" required class="form-control"/>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label for="more_info_url" class="h4">More Info URL</label>
                <input id="more_info_url" type="text" name="more_info_url" minlength=2 maxlength=40 
                placeholder="More Info URL" required class="form-control"/>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label for="phone" class="h4">Main Phone Number</label>
                <input id="phone" type="text" name="phone" placeholder="Main Phone Number" required class="form-control"/>
              </div>
              <div class="form-group col-lg-4 col-md-5 col-sm-6 col-xs-6">
                <label for="building " class="h4">Building </label>
                <input id="Building " type="text" name="building" placeholder="Building " required class="form-control"/>
              </div>
              <div class="col-lg-6 col-md-6">
                  <button type="submit" class="btn btn-primary btn-lg pull-left">
                      <a href="" style="color: white; text-decoration: none;">
                      Go Back
                  </a></button>
              </div>
              <div class="col-lg-6 col-md-6">
                  <button id="form-submit" type="submit" class="btn btn-success btn-lg pull-right">Add</button>
                  <button id="form-reset" type="reset" class="btn btn-danger btn-lg pull-right" style="margin-right: 8px;">
                      Clear</button>
              </div>
            </div>
          </form>
      </div>
    
    </div>
        
    </div>


<?php
     include('../includes/footer.php');
?>
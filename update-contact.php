<?php
require_once('includes/function.inc.php');

$error_flag = false;
$id = $_GET['id'];
$query = "SELECT  * FROM contacts WHERE id=$id";
$row = db_select($query)[0];
if(isset($_POST['submit'])) // here submit is name of submit button
{
    $data = [
        'first_name'=> $_POST['first_name'],
        'last_name'=> $_POST['last_name'],
        'email'=> $_POST['email'],
        'address'=> $_POST['address'],
        'telephone'=> $_POST['telephone']
    ];
    $birthdate = db_quote($_POST['birthdate']);
    $birthdate = date('Y-m-d', strtotime($birthdate));
    $data['birthdate'] = $birthdate;
    if(isset($_FILES['pic']))
    {
        $file_name = $_FILES['pic']['name'];
        $old_file_name = $row['image_name'];
        if(!empty($file_name) && $old_file_name !== $file_name):
            if(strlen($file_name) > 250):
                $file_name = substr($file_name,0,250);
            endif;
            $temp = explode('.', $file_name);
            $ext = end($temp);
            $file_name = $temp[0];
            $time = time();
            $image_name = "$file_name"."_"."$time.$ext";
            $temp_file_path  = $_FILES['pic']['tmp_name'];
            unlink("images/users/$old_file_name");
            move_uploaded_file($temp_file_path, "images/users/$image_name");
            $data['image_name'] = $image_name;
        endif;
    }
    
    
    $table = 'contacts';
    $condition = "id=".$row['id'];
    $result = db_update($table, $data, $condition);

    if($result){
        redirect("index.php?q=success&op=update");
    }else{
        $error_flag = true;
    }
}   
?>



<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Update Contact</title>
</head>

<body>
    <!--NAVIGATION BAR-->
    <nav>
        <div class="nav-wrapper">
            <!-- Dropdown Structure -->
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="#!">Profile</a></li>
                <li><a href="#!">Signout</a></li>
            </ul>
            <nav>
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo center">Contact Info</a>
                    <ul class="right hide-on-med-and-down">

                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i
                                    class="material-icons right">more_vert</i></a></li>
                    </ul>
                </div>
            </nav>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <!--/NAVIGATION BAR-->
    <div class="container">
        <div class="row mt50">
            <h2>Update Contact</h2>
        </div>
<?php
if($error_flag):
?> 
        <div class="row">
            <div class="materialert error">
                <div class="material-icons">error_outline</div>
              	There was some Issue while updating data please retry!
                <button type="button" class="close-alert">×</button>
            </div>
           </div>
<?php
endif;
?>  

        <div class="row">
            <form class="col s12 formValidate" action="<?= $_SERVER['PHP_SELF'].'?id='.$row['id']?>" id="add-contact-form" method="POST" enctype="multipart/form-data">
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="first_name" name="first_name" type="text" class="validate" value="<?= $row['first_name'] ?>" data-error=".first_name_error">
                        <label for="first_name">First Name</label>
                        <div class="first_name_error "></div>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" name="last_name" type="text" class="validate" value="<?= $row['last_name'] ?>" data-error=".last_name_error">
                        <label for="last_name">Last Name</label>
                        <div class="last_name_error "></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="email" name="email" type="email" class="validate" value="<?= $row['email'] ?>" data-error=".email_error">
                        <label for="email">Email</label>
                        <div class="email_error "></div>
                    </div>
                    <div class="input-field col s6">
                        <input id="birthdate" name="birthdate" type="text" class="datepicker" value="<?= $row['birthdate'] ?>" data-error=".birthday_error">
                        <label for="birthdate">Birthdate</label>
                        <div class="birthday_error "></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <input id="telephone" name="telephone" type="tel" class="validate" value="<?= $row['telephone'] ?>" data-error=".telephone_error">
                        <label for="telephone">Telephone</label>
                        <div class="telephone_error "></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <textarea id="address" name="address" class="materialize-textarea" data-error=".address_error"><?= $row['address'] ?></textarea>
                        <label for="address">Addess</label>
                        <div class="address_error "></div>
                    </div>
                </div>
                <div class="row mb10 input-image">
                    <div class="col s2">
                        <img src="/images/users/<?= $row['image_name'] ?>" alt="<?= $row['first_name'].$row['last_name']."photo" ?>" class="image-fluid" style="height:100px" >
                    </div>
                    <div class="file-field input-field col s10">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="pic" id="pic" data-error=".pic_error">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload Your Image"value="<?= $row['image_name'] ?>" >
                        </div>
                        <div class="pic_error "></div>
                    </div>
                </div>
                <button class="btn waves-effect waves-light right" type="submit" name="submit">Submit
                        <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© 2020 Study Link Classes</p>
            </div>
        </div>
    </footer>
    <!--JQuery Library-->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--JQuery Validation Plugin-->
    <script src="vendors/jquery-validation/validation.min.js" type="text/javascript"></script>
    <script src="vendors/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
    <!--Include Page Level Scripts-->
    <script src="js/pages/update-contact.js"></script>
    <!--Custom JS-->
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>
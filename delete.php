<?php
require_once('includes/function.inc.php');

$id = $_POST['id'];
$image_name = db_select("SELECT image_name FROM contacts WHERE id=$id")[0]['image_name'];

$query = "DELETE FROM contacts WHERE id=$id";
$result = db_query($query);

if($result){
    unlink("images/users/$image_name");
    redirect("index.php?q=success&op=delete");
}else
{
    redirect("index.php?q=error&op=delete");
}
?>
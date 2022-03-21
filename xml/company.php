<?php
session_start();
$i = 0;

$xml = simplexml_load_file('company.xml');



if (isset($_POST["insert"])) {
$employee = $xml->addChild('employee');
$employee->addchild('name', $_POST['name']);
$employee->addChild('phone', $_POST['phonenumber']);
$employee->addChild('address', $_POST['address']);
$employee->addChild('email', $_POST['email']);
file_put_contents('company.xml', $xml->asXML());

} elseif(isset($_POST["update"])){
    if (isset($_SESSION["id"])) {
        $i = $_SESSION["id"];
        $xml->employee[$i]->name=$_POST["name"];
        $xml->employee[$i]->phone=$_POST["phonenumber"];
        $xml->employee[$i]->adress=$_POST["address"];
        $xml->employee[$i]->email=$_POST["email"];
    }
    else{
        $i = 0;
        $xml->employee[$i]->name=$_POST["name"];
        $xml->employee[$i]->phone=$_POST["phonenumber"];
        $xml->employee[$i]->adress=$_POST["address"];
        $xml->employee[$i]->email=$_POST["email"];
    }
    $xml->asXML('company.xml');
} elseif(isset($_POST["delete"])){
    if (isset($_SESSION["id"])) {
        $i=$_SESSION["id"];
        
        if($i==count($xml[0]->employee)-1)
        unset($xml[0]->employee[$i]);
        {$i=0;
        $_SESSION["id"]=0;}
    }
    else{
        $i=0;
        unset($xml[0]->employee[$i]);

    }
    $xml->asXML('company.xml');
} elseif (isset($_POST["prev"])) {
    if (isset($_SESSION["id"])) {
    if ($_SESSION["id"]<= 0) {
        $i = 0;
        $_SESSION["id"]=$i;
    } else {
        $_SESSION["id"]=$_SESSION["id"]-1;
        $i=$_SESSION["id"];
    }}
    else
    {
        $i = 0;
        $_SESSION["id"]=$i; 
    }

} elseif (isset($_POST["searchbyname"])) {
      $key=$_POST["name"];
      $found=0;
      for ($j=0 ; $j<count($xml[0]->employee);$j++)
      {
          if(strcmp($key,$xml->employee[$j]->name)==0)
          { 
              $i=$j;
              $_SESSION["id"]=$i;
              $found=1;
          }  
      }
      if(!$found)
      {
         echo "there is no employee with this name"; 
      }
      else{
          echo "found";
      }

} elseif (isset($_POST["next"])) {
    if (isset($_SESSION["id"])) {
        $_SESSION["id"] = $_SESSION["id"] + 1;
        if($_SESSION["id"]<count($xml[0]->employee))
        {
             $i = $_SESSION["id"];
        }
        else{
            $i=0;
            $_SESSION["id"]=0;
        }
       
       
    } else {
        $i++;
        $_SESSION["id"] = $i;}
}
/*highlight_string('<?php ' . var_export($xml, true) . ';?>');*/
//echo count($xml[0]->employee);
//var_dump($_SESSION["id"]);
//var_dump($i);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XYZ </title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<div class="content">
    
    <div class="right">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">


            <h2 >Name</h2>
            <input type="text" placeholder="" value="<?php echo $xml[0]->employee[$i]->name; ?>" name="name">
            <h2>phone</h2>
            <input type="text" placeholder="phone" value="<?php echo $xml[0]->employee[$i]->phone; ?>" name="phonenumber">
            <h2>Adress</h2>
            <input type="text"  name="address"value="<?php echo $xml[0]->employee[$i]->adress; ?>" placeholder="Address">
            <h2>Email</h2>
            <input type="email" placeholder="E-mail" value="<?php echo $xml[0]->employee[$i]->email; ?>" name="email">
            <br><br><br>
            <div  class="btns">
            <button type="submit" name="prev">prev</button>  <br><br>  <button type="submit" name="next">next</button><br><br>
            <button type="submit" name="insert">insert</button>  <br> <br>  <button type="submit" name="update">update</button><br><br>
            <button type="submit" name="delete">delete</button>  <br> <br>   <button type="submit" name="searchbyname">searchbyname</button>
<!---->     </div>
        </form>
        <br>
    </div>
</div>
</body>
</html>
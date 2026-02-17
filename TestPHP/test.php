<?php
$name = "";
$message = "";
$age = 0;


if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["my_name"];
  if($name == "Ihor") { 
    $message = "Ahoj Ihore";
    $age = $_POST["my_age"];
  } else {
        $message =  "Neznam te";
  } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PHP</title>
</head>
<body>
    <h1>Test formulare</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat minus non commodi, recusandae voluptate illo neque accusantium perspiciatis tempora ullam officia quas beatae a repellat voluptatem inventore et molestiae mollitia.</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At modi impedit aperiam facilis perspiciatis voluptates, reprehenderit rerum nostrum. Enim eum consectetur quae voluptates obcaecati id ipsum optio dolor. Nisi, quos.</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatem recusandae, modi sed eligendi quas deserunt atque porro in ipsum, iure totam illum vero qui aperiam, pariatur obcaecati! Incidunt, ipsa magni. </p>
    <form method="post">
      <input type="text" name="my_name" placeholder="Zadejte jmeno">
      <input type="number" name="my_age" placeholder="Zadejte vek">
      <button type="submit"> Odeslat </button>
    </form>

    <p>
        <?php 
              echo "Vystup: ";
              echo $message;
               ?>
    </p>
    <p>
        <?php 
              echo "Tvuj vek: ";
              echo $age;
               ?>
    </p>

    
</body>
</html>
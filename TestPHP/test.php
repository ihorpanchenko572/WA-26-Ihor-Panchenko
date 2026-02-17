<?php
$name = ""; //jsou proměnné. uloží jméno, které zadá uživatel.
$message = ""; //zpráva, která se zobrazí uživateli (např. „Ahoj Ihore“ nebo „Neznam te“).
$age = 0; //uloží věk uživatele (číslo).


if($_SERVER["REQUEST_METHOD"] == "POST") { //Kontroluje se, jestli formulář byl odeslán metodou POST. $_SERVER["REQUEST_METHOD"] vrací, jaký HTTP request byl použit (GET nebo POST).
  $name = $_POST["my_name"]; // $_POST je superglobální pole, které obsahuje data odeslaná formulářem metodou POST. $name se tedy nastaví na hodnotu, kterou uživatel zadal do pole my_name.
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
    <title>Test PHP</title> <!-- název stránky, který se zobrazí v záložce prohlížeče. --> 
</head>
<body>
    <h1>Test formulare</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat minus non commodi, recusandae voluptate illo neque accusantium perspiciatis tempora ullam officia quas beatae a repellat voluptatem inventore et molestiae mollitia.</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At modi impedit aperiam facilis perspiciatis voluptates, reprehenderit rerum nostrum. Enim eum consectetur quae voluptates obcaecati id ipsum optio dolor. Nisi, quos.</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatem recusandae, modi sed eligendi quas deserunt atque porro in ipsum, iure totam illum vero qui aperiam, pariatur obcaecati! Incidunt, ipsa magni. </p>
    <form method="post"> <!-- formulář, který odesílá data POSTem (souhlasí s tím, co kontroluje PHP). -->
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
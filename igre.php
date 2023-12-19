<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="igre.css">
    <title>Games</title>
    <ul class="navbar">
        <li><a href="pocetna.php">Početna</a></li>
        <li><a href="igre.php">Igre</a></li>
        <li><a href="ulogujse.php">Uloguj se</a></li>
        <li><a href="registrujse.php">Registruj se</a></li>
    </ul>
</head>
<body>
    <div class="nasmeninaslov">
        <h1>Games to play</h1>
        </div>

    <div class="menu">
    <div class="games_card">
        <div class="menu_image">
            <img src="sevens-card-game.png">
        </div>
        <div class="games_info">
            <h2> 7Cards Game</h2>
            <p> Igra sedmica, potreban je paran broj igraca.</p>
            <h3>Tezina igrice 8/10</h3>
            <button><a href="#">Igraj</a></button>
        </div>
    </div>

    
    <div class="menu">
        <div class="games_card">
            <div class="menu_image">
                <img src="packman.png">
            </div>
            <div class="games_info">
                <h2>Packman</h2>
                <p> Igra Packman, potreban je jedan igrac.</p>
                <h3>Tezina igrice 6/10</h3>
                <button><a href="#">Igraj</a></button>
            </div>
        </div>


        <div class="menu">
            <div class="games_card">
                <div class="menu_image">
                    <img src="farmsimulator.jpg">
                </div>
                <div class="games_info">
                    <h2> Farm Simulator</h2>
                    <p> Igra farm simulator, potreban je jedan igrac.</p>
                    <h3>Tezina igrice 4/10</h3>
                    <button><a href="#">Igraj</a></button>
                </div>
            </div>


</body>
</html>
<?php 
try {
    
    $dbh = new PDO("mysql:host=localhost;dbname=igra;charset=latin5", "root", "");

   
    $dbh->beginTransaction();

    
    $upit3 = "SELECT username FROM korisnik WHERE email=:mejl";
    $stmt1 = $dbh->prepare($upit3);
    $stmt1->bindParam(":mejl",$mejl);

    $mejl = "prviemail@gmail.com";
    $stmt1->execute();


    $result = $stmt1->fetchAll();

    $stvarnoIme = $result[0]['username'];

    
    foreach ($result as $row) {
        echo '<span style="color: white;">' . $row['username'] . '<br>'.'</span>';
    }
    
    $upit4 = "UPDATE korisnik SET username=:username WHERE email=:mejl";  
    $stmt2 = $dbh->prepare($upit4);
    $stmt2->bindParam(":username",$username);
    $stmt2->bindParam(":mejl", $mejl);
        
        if ($stvarnoIme==="ivana") 
        {
            $username="Ivanica";
        } 
        else
        {
           $username="ivana";
        }
    

    $stmt2->execute();

    $dbh->commit();

} catch (PDOException $e) 
{
    $dbh->rollBack();  
    echo "Transakcija nije uspela: " . $e->getMessage();
}
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="registration.css">
    <title>Document</title>

    <ul class="navbar">
        <li><a href="pocetna.php">Početna</a></li>
        <li><a href="igre.php">Igre</a></li>
        <li><a href="ulogujse.php">Uloguj se</a></li>
        <li><a href="registrujse.php">Registruj se</a></li>
    </ul>

</head>
<body>
    
  
<body>
    <div class="form-container">
        <form class="form" action="registrujse.php" method="post">
            <div class="form-group">
                <label>
                    <input type="text" id="username" name="username" required>
                    <span>Username</span>
                </label>
                <label>
                    <input type="password" id="password" name="password" required>
                    <span>Password</span>
                </label>
                <label>
                    <input type="email" id="email" name="email" required>
                    <span>Email:</span>
                </label>
                <button class="dugme" type="submit">Submit</button>
                <br><br>
                <p>Already have an account ? <a href="ulogujse.html" class="signin">Sign in</a></p>
            </div>
        </form>
    </div>
</body>

</html>


<?php
class NovKorisnik {
    public $username;
    public $password;
    public $email;

    public function __construct($username, $password, $email) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function prikaziPodatke() {        
        echo "<div style='color: white;'>";
        echo "<p>Primer ukucavanja:</p>";
        echo "<p>Korisnik: $this->username</p>";
        echo "<p>Email:$this->email</p>";
        echo "</div>";
    }
}



$noviKorisnik = new NovKorisnik('Korisnik1', 'sifra123', 'primer@email.com');
$noviKorisnik->prikaziPodatke();

 

$mysqli = new mysqli("localhost","root", "", "igra");


if($mysqli->connect_errno) {
    echo "ID greške je: " . $mysqli->connect_errno . "<br>";
    echo "Neuspešna konekcija na bazu podataka: " . $mysqli->connect_error;  //kon
    exit();
    }
    echo "<span style='color: white;'> Povezano. </span>";

$sql_upit2 = "DELETE FROM korisnik WHERE email='ivanagobor15@gmail.com'";
if ($mysqli->query($sql_upit2)) {
    echo "<span style='color: white;'> Podaci o korisniku su uspešno obrisani!</span>'<br>'";                 //upit delete
} else {
    echo "Greška pri brisanju korisnika: " . $mysqli->error;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];


   
    $sql_upit = "INSERT INTO korisnik (username, password, email) VALUES (?, ?, ?)";

    
    $stmt = $mysqli->prepare($sql_upit);

    if ($stmt) {
        $stmt->bind_param("sss", $username, $password, $email); 
        $stmt->execute();

        if (!ctype_alnum($username)) {
            echo "Korisničko ime može sadržavati samo slova i brojeve.";
              exit();
           }
           if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
           {
               echo "$email je validna mejl adresa!";
               exit();
           }
        // Provera uspešnog unosa
        if ($stmt->affected_rows > 0) {
            echo "Korisnik uspešno dodat u tabelu!";
        } else {
            echo "Greška pri unosu korisnika!";
        }
        
        $stmt->close();
    } else {
        echo "Priprema upita nije uspela: " . $mysqli->error;
    }
    
   


    $mysqli->close();
}

?>
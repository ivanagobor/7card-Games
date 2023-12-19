
<?php 

class Korisnik {
    private $username;
    private $password;

    
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    
    public function login($enteredUsername, $enteredPassword) {
        return $enteredUsername === $this->username && ($enteredPassword === $this->password);
    }
}

try {
    $dbh = new PDO("mysql:host=localhost;dbname=igra;charset=utf8", "root", "");
    echo"Povezano. ";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $enteredUsername = $_POST['username'];
        $enteredPassword = $_POST['password'];

        $stmt = $dbh->prepare("SELECT * FROM korisnik WHERE username = ?");
        $stmt->execute([$enteredUsername]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $sacuvanaLozinka = $row['password'];
            $user = new Korisnik($enteredUsername, $sacuvanaLozinka);

            if ($user->login($enteredUsername, $enteredPassword)) {
                echo "Uspešno ste se ulogovali!";
                header('Location: igre.php');
                exit();
            } else {
                echo "Pogrešna lozinka!";
            }
        } else {
            echo "Korisnik nije pronađen!";
        }
    }
} catch (PDOException $e) {
    echo "Neuspešna konekcija: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="pocetna.css">
    <title>Document</title>
</head>
<body>
    <ul class="navbar">
        <li><a href="pocetna.php">Početna</a></li>
        <li><a href="igre.php">Igre</a></li>
        <li><a href="ulogujse.php">Uloguj se</a></li>
        <li><a href="registrujse.php">Registruj se</a></li>
    </ul>

    <form class="login-box" method="POST" action="ulogujse.php">
        <div class="user-box">
            <input type="text" name="username" id="username">
            <label for="username">Username</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" id="password">
            <label for="password">Password</label>
        </div>
        <center>
            <button type="submit" name="login" id="login">LOGIN</button>
        </center>
        <a id="register">Don't have an account?</a><br>
        <a class="register-link" href="registrujse.php">REGISTER</a>
    </form>
</body>
</html>















<?php
// Database connection settings
$host = 'sql112.infinityfree.com';
$db = 'if0_37790594_secret_santa';
$user = 'if0_37790594';
$pass = '6p0Iupa571G'; // Use your database password

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Collect data from the form
    $playerName = $_POST['player_name'];
    $guesses = $_POST['guesses'];

    // Insert each guess into the database
    foreach ($guesses as $gifter => $recipient) {
        $stmt = $pdo->prepare("INSERT INTO guesses (player_name, gifter_name, guessed_recipient, timestamp)
                               VALUES (:player_name, :gifter_name, :guessed_recipient, NOW())");
        $stmt->execute([
            ':player_name' => $playerName,
            ':gifter_name' => $gifter,
            ':guessed_recipient' => $recipient
        ]);
    }

    // Display thank you message
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Thank You for Your Submission!</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                text-align: center;
                background-color: #0c3b22;
                color: #fff;
                padding: 20px;
                background-image: url('https://www.transparenttextures.com/patterns/snow.png');
            }
            .container {
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                padding: 20px;
                max-width: 800px;
                margin: 0 auto;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            }
            h1 {
                color: #e74c3c;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            }
            .message {
                font-size: 24px;
                margin-top: 20px;
            }
            .button {
                padding: 10px 20px;
                margin-top: 20px;
                font-size: 16px;
                cursor: pointer;
                background-color: #e74c3c;
                color: white;
                border: none;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            .button:hover {
                background-color: #c0392b;
            }
            .snowflake {
                color: #fff;
                font-size: 1em;
                font-family: Arial;
                text-shadow: 0 0 1px #000;
                position: fixed;
                top: -10%;
                z-index: 9999;
                user-select: none;
                cursor: default;
                animation-name: snowflakes-fall, snowflakes-shake;
                animation-duration: 10s, 3s;
                animation-timing-function: linear, ease-in-out;
                animation-iteration-count: infinite, infinite;
                animation-play-state: running, running;
            }
            @keyframes snowflakes-fall {
                0% {top: -10%}
                100% {top: 100%}
            }
            @keyframes snowflakes-shake {
                0% {transform: translateX(0px)}
                50% {transform: translateX(80px)}
                100% {transform: translateX(0px)}
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>🎅 Ευχαριστούμε για τις Μαντεψιές! 🎄</h1>
            <p class='message'>Οι μαντεψιές σας καταχωρήθηκαν με επιτυχία. Ευχόμαστε καλές γιορτές και καλή τύχη!</p>
            <p> </p>
            <img src='images/butt.jpg' class='float-image'>

        </div>
    </body>
    </html>
    ";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

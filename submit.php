<DOCTYPE html>
    <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <title>Thank you for your application</title>
            <link rel="stylesheet" href="css/styles.css">
        </head>
        <body>
            <div class="container">
                <header>
                    <h1>Thank you for your application</h1>
                </header>
                <div class="content">
                    <?php

                    use classes\TableCreator;

                    require_once "classes/Database.php";
                    require_once "classes/TableCreator.php";
                    require_once "classes/Applicant.php";
                    require_once "classes/Form.php";

                    $host = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "recruitment";

                    $database = new Database($host, $username, $password, $dbname);
                    $database->createDatabase();

                    $conn = $database->getConnection();

                    $table = new TableCreator($conn);
                    $table->createApplicantTable();
                    $table->createInternshipsTable();

                    $formService = new Form($conn);
                    $formService->processForm();

                    $database->closeConnection();

                    ?>
                </div>
        </body>
    </html>
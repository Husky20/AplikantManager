<?php

class Form
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function processForm(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = $this->validateInput($_POST["email"] ?? '');

            if ($this->isApplicantExists($email)) {
                echo "Applicant with this email already exists";
                return;
            }

            $firstName = $this->validateInput($_POST["firstName"] ?? '');
            $lastName = $this->validateInput($_POST["lastName"] ?? '');
            $birthDate = $this->validateInput($_POST["birthDate"] ?? '');

            $education = $this->validateInput($_POST["education"] ?? '');
            $attachment1 = $_FILES["attachment1"]["name"] ?? '';
            $attachment2 = $_FILES["attachment2"]["name"] ?? '';
            $attachment3 = $_FILES["attachment3"]["name"] ?? '';

            $internshipCompanies = $_POST['internshipCompanies'];
            $internshipStartDates = $_POST['internshipStartDates'];
            $internshipEndDates = $_POST['internshipEndDates'];

            if (!$this->checkAttachmentFormat($attachment1, $attachment2)) {
                echo "Invalid attachment format";
                return;
            }

            $attachment3 !== '' ?
                $this->moveAttachments($attachment1, $attachment2, $attachment3)
                : $this->moveAttachments($attachment1, $attachment2);


            if (!$this->validateEmail($email)) {
                echo "Invalid email address";
            } elseif (!$this->validateDate($birthDate)) {
                echo "Invalid birth date format" . $birthDate;
            } else {
                $applicant = new Applicant($this->conn);

                $applicant->setFirstName($firstName);
                $applicant->setLastName($lastName);
                $applicant->setBirthDate($birthDate);
                $applicant->setEmail($email);
                $applicant->setEducation($education);
                $applicant->setAttachment1($attachment1);
                $applicant->setAttachment2($attachment2);
                $applicant->setAttachment3($attachment3);

                for ($i = 0; $i < count($internshipCompanies); $i++) {
                    $company = $internshipCompanies[$i];
                    $startDate = $internshipStartDates[$i];
                    $endDate = $internshipEndDates[$i];

                        if (!$this->validateDate($startDate) || !$this->validateDate($endDate)) {
                            echo "Invalid internship date format";
                            return;
                        }
                        if ($startDate > $endDate) {
                            echo "Start date cannot be later than end date";
                            return;
                        }

                    $applicant->addInternship($company, $startDate, $endDate);
                }

                if ($applicant->save()) {
                    echo "Application submitted successfully. We will contact you soon.\n";
                } else {
                    echo "Error occurred while saving the application.\n";
                }
            }
        }
    }

    private function validateInput($data): string
    {
        return trim(stripslashes(htmlspecialchars($data)));
    }

    private function validateEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validateDate($date): bool
    {
        return date_create_from_format("Y-m-d", $date) !== false;
    }

    private function isApplicantExists($email)
    {
        $email = mysqli_real_escape_string($this->conn, $email);

        $query = "SELECT COUNT(*) FROM applicant WHERE email = '$email'";

        $result = mysqli_query($this->conn, $query);
        $count = mysqli_fetch_array($result)[0];

        return $count > 0;
    }

    private function checkAttachmentFormat($attachment1, $attachment2): bool
    {
        $allowedExtensions = ['jpg', 'pdf', 'doc'];

        if ($_FILES['attachment1']['error'] === UPLOAD_ERR_OK && $_FILES['attachment2']['error'] === UPLOAD_ERR_OK) {
            $attachment1Name = $_FILES['attachment1']['name'];
            $attachment2Name = $_FILES['attachment2']['name'];
            $attachment1Extension = strtolower(pathinfo($attachment1Name, PATHINFO_EXTENSION));
            $attachment2Extension = strtolower(pathinfo($attachment2Name, PATHINFO_EXTENSION));

            if (in_array($attachment1Extension, $allowedExtensions) && in_array($attachment2Extension, $allowedExtensions)) {
                return true;
            } else {
                echo 'Inncorrect file format. Allowed formats: '.implode(', ', $allowedExtensions);

                return false;
            }
        } else {
            echo 'Error during uploading file.';

            return false;
        }
    }

    private function moveAttachments($attachment1, $attachment2, $attachment3 = null): void
    {
        $targetDir = "attachments/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir);
            chmod($targetDir, 0777);
        }
        move_uploaded_file($_FILES["attachment1"]["tmp_name"], $targetDir . $attachment1);
        move_uploaded_file($_FILES["attachment2"]["tmp_name"], $targetDir . $attachment2);
        move_uploaded_file($_FILES["attachment3"]["tmp_name"], $targetDir . $attachment3);
    }
}

<?php

require_once 'Internship.php';

class Applicant
{
    private $conn;
    private $firstName;
    private $lastName;
    private $birthDate;
    private $email;
    private $education;
    private $attachment1;
    private $attachment2;
    private $attachment3;
    private $internships;
    private $createdAt;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->internships = [];
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setEducation($education)
    {
        $this->education = $education;
    }

    public function setAttachment1($attachment1)
    {
        $this->attachment1 = $attachment1;
    }

    public function setAttachment2($attachment2)
    {
        $this->attachment2 = $attachment2;
    }

    public function setAttachment3($attachment3)
    {
        $this->attachment3 = $attachment3;
    }

    public function addInternship($company, $startDate, $endDate)
    {
        $internship = new Internship($company, $startDate, $endDate);
        $this->internships[] = $internship;
    }

    public function save()
    {
        $firstName = mysqli_real_escape_string($this->conn, $this->firstName);
        $lastName = mysqli_real_escape_string($this->conn, $this->lastName);
        $birthDate = mysqli_real_escape_string($this->conn, $this->birthDate);
        $email = mysqli_real_escape_string($this->conn, $this->email);
        $education = mysqli_real_escape_string($this->conn, $this->education);
        $attachment1 = mysqli_real_escape_string($this->conn, $this->attachment1);
        $attachment2 = mysqli_real_escape_string($this->conn, $this->attachment2);
        $attachment3 = mysqli_real_escape_string($this->conn, $this->attachment3);

        $query = "INSERT INTO applicant (first_name, last_name, birth_date, email, education, attachment1, attachment2, attachment3, created_at) 
            VALUES ('$firstName', '$lastName', '$birthDate', '$email', '$education', '$attachment1', '$attachment2', '$attachment3', NOW())";

        try {
            mysqli_query($this->conn, $query);

            $applicantId = mysqli_insert_id($this->conn);

            foreach ($this->internships as $internship) {
                $company = mysqli_real_escape_string($this->conn, $internship->getCompany());
                $startDate = mysqli_real_escape_string($this->conn, $internship->getStartDate());
                $endDate = mysqli_real_escape_string($this->conn, $internship->getEndDate());

                $internshipQuery = "INSERT INTO internships (applicant_id, company, start_date, end_date, created_at) 
                                    VALUES ('$applicantId', '$company', '$startDate', '$endDate', NOW())";
                mysqli_query($this->conn, $internshipQuery);
            }

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }
}


<?php

class Internship
{
    private $company;
    private $startDate;
    private $endDate;

    public function __construct($company, $startDate, $endDate)
    {
        $this->company = $company;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }
}
<?php

namespace App\Http\Services;
use App\Models\SoldCar;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportService
{
    private $view_template = "";
    private $view_values = [];
    private $target_format = "";


    public function setContent($content)
    {

    }

    public function generateReport(){
        $pdf = PDF::loadView($this->view_template,$this->view_values);
        return $pdf->output();
    }
}


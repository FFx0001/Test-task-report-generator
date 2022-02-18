<?php

namespace App\Http\Services;
use Barryvdh\DomPDF\Facade\Pdf;
use BenSampo\Enum\Enum;

/**
 * Class ReportService
 * @package App\Http\Services
 * Class for generating reports in office formats (binary\raw)
 */
class ReportService
{
    private $view_template = null;
    private $view_values = [];
    private $convert_format = null;

    /**
     * set format for report ( pdf, docx, xlsx )
     * @param null $convert_format
     * @return $this
     */
    public function setConvertMode($convert_format) { $this->convert_format = $convert_format; return $this; }

    /**
     * @param $view
     * @return mixed
     * set name blade template
     */
    public function setViewReportTemplateName($view="") { $this->view_template = $view;  return $this;  }

    /**
     * @param $values
     * @return mixed
     * set values array for view
     */
    public function setViewTemplateValues($values=[]) { $this->view_values = $values;  return $this;  }

    /**
     * @return array ["raw_data"(binary),"completed"(bool),"info"(string)]
     * procedure converting view -> pdf (raw)
     */
    private function pdfProcessing()
    {
        $pdf = PDF::setOptions ([ 'dpi' => 150 , 'defaultFont' => 'sans-serif' ]);
        $pdf = PDF::loadView($this->view_template,$this->view_values);
        $raw_data = $pdf->output();// get raw data
        if($raw_data){
            return ["raw_data"=>$raw_data,"completed"=>true,"info"=>"success"];
        }else{
            return ["raw_data"=>null,"completed"=>false,"info"=>"error converting to PDF!"];
        }
    }

    /**
     * @return array ["raw_data"(binary),"completed"(bool),"info"(string)]
     * procedure converting view -> docx (raw)
     */
    private function docxProcessing()
    {
        return ["raw_data"=>null,"completed"=>false,"info"=>"not implemented"];
    }

    /**
     * @return array ["raw_data"(binary),"completed"(bool),"info"(string)]
     * procedure converting view -> xlsx (raw)
     */
    private function xlsxProcessing()
    {
        return  ["raw_data"=>null,"completed"=>false,"info"=>"not implemented"];
    }

    /**
     * @return array ["raw_data"(binary),"completed"(bool),"info"(string)]
     * Start creating report
     */
    public function generateReport(){
        $raw_data = ["raw_data"=>null,"completed"=>false,"info"=>"format not found"];
        if($this->convert_format == "pdf") {  $raw_data    = $this->pdfProcessing();   }
        if($this->convert_format == "docx"){  $raw_data    = $this->docxProcessing();  }
        if($this->convert_format == "xlsx"){  $raw_data    = $this->xlsxProcessing();  }
        return $raw_data;
    }
}

/**
 * Class ReportFormat
 * @package App\Http\Services
 * using package: bensampo/laravel-enum
 */
/*
final class ReportFormat extends Enum
{
    const PDF = ['application/pdf'];
    const XLSX = ['application/vnd.ms-excel'];
    const DOCX = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
}

*/
/*
 * Extension MIME Type
.doc      application/msword
.dot      application/msword

.docx     application/vnd.openxmlformats-officedocument.wordprocessingml.document
.dotx     application/vnd.openxmlformats-officedocument.wordprocessingml.template
.docm     application/vnd.ms-word.document.macroEnabled.12
.dotm     application/vnd.ms-word.template.macroEnabled.12

.xls      application/vnd.ms-excel
.xlt      application/vnd.ms-excel
.xla      application/vnd.ms-excel

.xlsx     application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
.xltx     application/vnd.openxmlformats-officedocument.spreadsheetml.template
.xlsm     application/vnd.ms-excel.sheet.macroEnabled.12
.xltm     application/vnd.ms-excel.template.macroEnabled.12
.xlam     application/vnd.ms-excel.addin.macroEnabled.12
.xlsb     application/vnd.ms-excel.sheet.binary.macroEnabled.12

.ppt      application/vnd.ms-powerpoint
.pot      application/vnd.ms-powerpoint
.pps      application/vnd.ms-powerpoint
.ppa      application/vnd.ms-powerpoint

.pptx     application/vnd.openxmlformats-officedocument.presentationml.presentation
.potx     application/vnd.openxmlformats-officedocument.presentationml.template
.ppsx     application/vnd.openxmlformats-officedocument.presentationml.slideshow
.ppam     application/vnd.ms-powerpoint.addin.macroEnabled.12
.pptm     application/vnd.ms-powerpoint.presentation.macroEnabled.12
.potm     application/vnd.ms-powerpoint.template.macroEnabled.12
.ppsm     application/vnd.ms-powerpoint.slideshow.macroEnabled.12

.mdb      application/vnd.ms-access
 */

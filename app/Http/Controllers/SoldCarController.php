<?php

namespace App\Http\Controllers;


use App\Http\Services\FileService;
use App\Http\Services\ReportService;
use Illuminate\Http\Request;
use App\Models\SoldCar;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LinkController;

class SoldCarController extends Controller
{
    /**
     * @param $format
     * @param $template
     * @return mixed or binary string (raw_data)
     */
    private function reportGenerator($format,$template){
        $RService = new ReportService();
        $RService->setConvertMode($format);
        $RService->setViewReportTemplateName($template);
        $sold_cars = (new SoldCar())->getAllRecordsForReport();
        if(!empty($sold_cars)) {
            $date = new \DateTime('now');
            $RService->setViewTemplateValues(["time" => $date->format('D M d, Y G:i'), "sold_cars" => $sold_cars]);
            $report = $RService->generateReport();
            if($report["completed"]) {
                return $report["raw_data"];
            }else{
                $this->response()->setStatus(501)->setErrors($report["info"])->build();
            }
        }else{
            $this->response()->setStatus(404)->setErrors("Table is empty, generating report canceled!")->build();
        }
    }

    public function generateReportAndSendToPost($format)
    {
        //
    }

    /**
     * generate report in raw type
     * @param $format
     * @return {'raw_data'(binary string),'extension'(string),'real_file_name'(string) }
     */
    public function generateReportRawForFront($format)
    {
        $sub_folder_name = "reports";
        $file_display_name = "Отчет о проданных автомобилях";
        $report_raw_data = $this->reportGenerator($format,"report");
        return $this->response()->setContent(["raw_data"=>$report_raw_data,"extension"=>$format["extension"],"real_file_name"=>$file_display_name])->build();
    }

    /**
     * generate report and save file in public folder? return link for download file
     * @param $format
     */
    public function generateReportAndShareLink($format)
    {
        $sub_folder_name = "reports";
        $file_display_name = "Отчет о проданных автомобилях";
        $report_raw_data = $this->reportGenerator($format,"report");
        $record_file_id = (new FileController())->CreatePublicFile($file_display_name,$format,$sub_folder_name,$report_raw_data);
        $link_record_id = (new LinkController())->createLink($record_file_id);
        return $this->response()->setContent(["url"=>$this->buildDownloadUrl($link_record_id)])->build();
    }

    private function buildDownloadUrl($link_record_id){
       return url('/')."/api/file/download/".$link_record_id;
    }
}

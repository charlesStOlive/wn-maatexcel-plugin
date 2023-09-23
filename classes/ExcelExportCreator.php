<?php

namespace Waka\MaatExcel\Classes;
use File;
use Excel;


use Waka\Wutils\Classes\TinyUuid;

class ExcelExportCreator
{
    public $maatExcelClass;
    public array $vars;
    public $outputName;
    //


    public function __construct($slug, $vars, $options = [])
    {
        $modelConfig = \Waka\MaatExcel\Models\ExportExcel::findBySlug($slug);
        //trace_log($modelConfig);
        $modelId = $options['modelId'];
        $maatClass = $modelConfig['class'];
        $this->outputName = $modelConfig['output_name'] ?? 'pas de nom';
        //trace_log("output_name!",$this->output_name);
        $this->maatExcelClass = new $maatClass($modelId);
    }

    public function setOutputName($outputName)
    {
        if($outputName) {
            $this->outputName = $outputName;
        }
        
    }

    public function saveTo()
    {
        $finalName = \Str::slug($this->outputName, '_');
        $uuid = TinyUuid::generateFromDate();
        $path = sprintf('uploads/tempproductor/%s/%s',$uuid,$finalName . '.xlsx');
        Excel::store($this->maatExcelClass, $path);
        return storage_path('app/'.$path);
    }
}

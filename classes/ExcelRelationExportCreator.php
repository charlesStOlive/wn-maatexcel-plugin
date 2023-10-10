<?php

namespace Waka\MaatExcel\Classes;
use File;
use Excel;


use Waka\Wutils\Classes\TinyUuid;

class ExcelRelationExportCreator
{
    public $maatExcelClass;
    public array $vars;
    public $outputName;
    //


    public function __construct($slug, $initOptions = [])
    {
        $modelConfig = \Waka\MaatExcel\Models\ExportRelationExcel::findBySlug($slug);
        $maatClass = $modelConfig['class'];
        $this->outputName = $initOptions['output_name'] ?? 'pas de nom';
        $this->maatExcelClass = new $maatClass($initOptions);
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

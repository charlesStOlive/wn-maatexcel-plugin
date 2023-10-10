<?php namespace Waka\MaatExcel\Classes;

use Waka\Wutils\Classes\TinyUuid;
class ExcelImportRelationCreator 
{
    public $maatExcelClass;
    public array $vars;
    public $output_name;
    //
    private $outputName;
    private $path;


    public function __construct($slug, $initOptions = [])
    {
        //trace_log('constructor excelImport');
        //trace_log($options);
        $modelConfig = \Waka\MaatExcel\Models\ImportRelationExcel::findBySlug($slug);
        $modelId = $initOptions['modelId'];
        $maatClass = $modelConfig['class'];
        $this->path = $initOptions['filePath'];
        $this->maatExcelClass = new $maatClass($modelId);

    }





    /**
     * Set METHOD
     */

    public function importData()
    {
        try {
            \Excel::import($this->maatExcelClass, $this->path);
        } catch(\Exception $ex) {
            throw $ex;
        }
        
        
    }
    
}
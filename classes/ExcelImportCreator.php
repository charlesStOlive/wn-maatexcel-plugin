<?php namespace Waka\MaatExcel\Classes;

use Waka\Wutils\Classes\TinyUuid;
class ExcelImportCreator 
{
    public $maatExcelClass;
    public array $vars;
    public $output_name;
    //
    private $outputName;
    private $path;


    public function __construct($slug, $vars = [], $options = [])
    {
        //trace_log('constructor excelImport');
        //trace_log($options);
        $modelConfig = \Waka\MaatExcel\Models\ImportExcel::findBySlug($slug);
        $modelId = $options['modelId'];
        $maatClass = $modelConfig['class'];
        $this->path = $options['filePath'];
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
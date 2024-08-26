<?php

namespace Waka\MaatExcel\Classes;

use \Waka\Productor\Classes\Abstracts\BaseProductor;
use Closure;
use Arr;

use Lang;

class ExcelImporter extends BaseProductor
{

    public static $config =  [
        'label' => 'waka.maatexcel::lang.driver.excel_importer.label',
        'icon' => 'icon-file-excel',
        'description' => 'waka.maatexcel::lang.excel_importer.description',
        'productorCreator' => \Waka\MaatExcel\Classes\ExcelImportCreator::class,
        'productorModel' => \Waka\MaatExcel\Models\ImportExcel::class,
        'productorFilesRegistration' =>  'registerExcelImport',
        'noProductorBdd' => true,
        'use_import_file_widget' => true,
        'productor_yaml_config' => '~/plugins/waka/maatexcel/models/importexcel/productor_config.yaml',
        'methods' => [
            'prepareDownload' => [
                'label' => 'Télécharger Excel',
                'handler' => 'prepareImporter',
            ]
        ],
    ];


    /**
     * Instancieation de la class creator
     *
     * @param string $url
     * @return \Spatie\Browsershot\Browsershot
     */
    private static function instanciateCreator(string $templateCode, array $initoptions)
    {
        $productorClass = self::getStaticConfig('productorCreator');
        $class = new $productorClass($templateCode, $initoptions);
        return $class;
    }

    public  function prepareImporter($code,  $allDatas): array
    {
        $sessionKey = Arr::get($allDatas, '_session_key');
        $iel = new \Waka\MaatExcel\Models\ImportExcel();
        $iel->fill($allDatas['productorDataArray']);
        $file = $iel
            ->excel_file()
            ->withDeferred($sessionKey)
            ->first();
        if (!$file) {
            throw new ValidationException(['excel_file' => 'il manqie le fichier xlsx']);
        }
        //trace_log($file->getDiskPath());
        self::importData($code, ['filePath' => $file->getDiskPath()]);
        return [
            'message' => 'waka.maatexcel::lang.driver.eri.execute.success.message',
            'btn' => [
                'label' => 'waka.productor::lang.drivers.success_label.close_refresh',
                'request' => 'onCloseAndRefresh'
            ],
        ];
    }

    public static function importData($templateCode, $vars, Closure $callback = null)
    {
        // Créer l'instance de pdf
        $creator = self::instanciateCreator($templateCode, $vars);
        // Appeler le callback pour définir les options
        if (is_callable($callback)) {
            $callback($creator);
        }
        // Sauver le fichier pdf. 
        try {
            return $creator->importData();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    
}

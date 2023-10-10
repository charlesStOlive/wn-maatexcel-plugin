<?php

namespace Waka\MaatExcel\Classes;

use \Waka\Productor\Classes\Abstracts\BaseProductor;
use Lang;
use Arr;
use Closure;
use ApplicationException;
use ValidationException;

class ExcelRelationImporter extends BaseProductor
{

    public static $config = [
            'label' => 'waka.maatexcel::lang.driver.excel_relation_importer.label',
            'icon' => 'icon-file-excel',
            'description' => 'waka.maatexcel::lang.excel_relation_importer.description',
            'productorCreator' => \Waka\MaatExcel\Classes\ExcelImportCreator::class,
            'productorModel' => \Waka\MaatExcel\Models\ImportRelationExcel::class,
            'productorFilesRegistration' =>  'registerExcelRelationImport',
            'noProductorBdd' => true,
            'use_import_file_widget' => true,
            'productor_yaml_config' => '~/plugins/waka/maatexcel/models/importrelationexcel/productor_config.yaml',
            'methods' => [
                'importData' => [
                    'label' => 'Importer Excel',
                    'handler' => 'importExcel',
                    'load-indicator' => true,
                ]
            ],
        ];

    public static function updateFormwidget($slug, $formWidget, $config= [])
    {
        return $formWidget;
    }

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

    public  function execute($code, $responseType, $allDatas): array
    {
        //trace_log('execute----');
        $modelId = Arr::get($allDatas, 'modelId');
        $sessionKey = Arr::get($allDatas, '_session_key');;
        //trace_log($allDatas);
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
        self::importData($code, ['modelId' => $modelId, 'filePath' => $file->getDiskPath()]);
        return [
            'message' => 'waka.maatexcel::lang.driver.eri.execute.success.message',
            'btn' => [
                'label' => 'waka.productor::lang.drivers.sucess_label.close_refresh',
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

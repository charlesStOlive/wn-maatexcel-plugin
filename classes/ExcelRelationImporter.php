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
    use \Waka\Productor\Classes\Traits\TraitProductor;

    public static $config = [
            'label' => 'waka.maatexcel::lang.driver.excel_relation_importer.label',
            'icon' => 'icon-mjml',
            'description' => 'waka.maatexcel::lang.excel_relation_importer.description',
            'productorCreator' => \Waka\MaatExcel\Classes\ExcelImportCreator::class,
            'productorModel' => \Waka\MaatExcel\Models\ImportExcel::class,
            'productorFilesRegistration' =>  'registerExcelRelationImport',
            'noproductorBdd' => true,
            'use_import_file_widget' => true,
            'productor_yaml_config' => '~/plugins/waka/maatexcel/models/importexcel/productor_config.yaml',
            'methods' => [
                'importData' => [
                    'label' => 'Importer Excel',
                    'handler' => 'importExcel',
                    'load-indicator' => true,
                ]
            ],
        ];

    public static function updateFormwidget($slug, $formWidget)
    {
        return $formWidget;
    }

    /**
     * Instancieation de la class creator
     *
     * @param string $url
     * @return \Spatie\Browsershot\Browsershot
     */
    private static function instanciateCreator(string $templateCode, array $vars, array $options)
    {
        $productorClass = self::getStaticConfig('productorCreator');
        $class = new $productorClass($templateCode, $vars, $options);
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
        self::importData($code, [], ['modelId' => $modelId, 'filePath' => $file->getDiskPath()]);
        return [
            'message' => 'Import terminé',
            'btn' => [
                'label' => 'Fermer et rafraichir',
                'request' => 'onCloseAndRefresh'
            ],
        ];
    }

    public static function importData($templateCode, $vars, $options = [], Closure $callback = null)
    {
        // Créer l'instance de pdf
        $creator = self::instanciateCreator($templateCode, $vars, $options);
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

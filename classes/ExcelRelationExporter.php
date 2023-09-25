<?php

namespace Waka\MaatExcel\Classes;

use Waka\Productor\Interfaces\BaseProductor;
use Waka\Productor\Interfaces\SaveTo;
use Closure;
use Arr;

use Lang;

class ExcelRelationExporter implements BaseProductor,SaveTo 
{
    use \Waka\Productor\Classes\Traits\TraitProductor; 

    public static function getConfig()
    {
        return [
            'label' => Lang::get('waka.maatexcel::lang.driver.excel_relation_exporter.label'),
            'icon' => 'icon-mjml',
            'description' => Lang::get('waka.maatexcel::lang.excel_relation_exporter.description'),
            'productorCreator' => \Waka\MaatExcel\Classes\ExcelExportCreator::class,
            'productorModel' => \Waka\MaatExcel\Models\ExportExcel::class,
            'productorFilesRegistration' =>  'registerExcelRelationExport',
            'noproductorBdd' => true,
            'productor_yaml_config' => '~/plugins/waka/maatexcel/models/exportexcel/productor_config.yaml',
            'methods' => [
                'download' => [
                    'label' => 'Télécharger Excel',
                    'handler' => 'saveTo',
                ]
            ],
        ];
    }

    public static function updateFormwidget($slug, $formWidget) {
        $formWidget->getField('output_name')->value = 'Export excel';
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
        $productorClass = self::getConfig()['productorCreator'];
        $class = new $productorClass($templateCode, $vars, $options);
        return $class;
    }

    public static function execute($code, $productorHandler, $allDatas):array {
        $modelId = Arr::get($allDatas, 'modelId');
        $modelClass = Arr::get($allDatas, 'modelClass');
        $productorClass = self::getConfig()['productorCreator'];
        $targetModel = $modelClass::find($modelId);
        $data = [];
        if ($targetModel) {
            $data = $targetModel->dsMap('full');
        }
        $opt = [
            'modelId' => $modelId,
        ];
        $creator = new $productorClass($code, $data, $opt);
        $creator->setOutputName(\Arr::get($allDatas, 'productorDataArray.output_name', 'fichier_sans_nom'));

        try {
            $link =  $creator->saveTo();
            return [
                'message' => 'Export  prêt pour télechargement',
                'btn' => [
                    'label' => 'Télécharger le fichier',
                    'request' => 'onCloseAndDownload',
                    'link' => $link
                ],
            ];
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function saveTo($templateCode, $vars = [], $options = [], $path = '', Closure $callback = null)
    {
        // Créer l'instance de pdf
        $creator = self::instanciateCreator($templateCode, $vars, $options);
        // Appeler le callback pour définir les options
        if (is_callable($callback)) {
            $callback($creator);
        }
        // Sauver le fichier pdf. 
        try {
            return $creator->saveTo($path);
        } catch (\Exception $ex) {
            throw new \ApplicationException($ex);
        }
    }
}
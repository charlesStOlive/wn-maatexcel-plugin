<?php

namespace Waka\MaatExcel\Classes;

use \Waka\Productor\Classes\Abstracts\BaseProductor;
use Closure;
use Arr;

use Lang;

class ExcelRelationExporter extends BaseProductor
{

    public static $config =  [
        'label' => 'waka.maatexcel::lang.driver.excel_relation_exporter.label',
        'icon' => 'icon-file-excel',
        'description' => 'waka.maatexcel::lang.excel_relation_exporter.description',
        'productorCreator' => \Waka\MaatExcel\Classes\ExcelRelationExportCreator::class,
        'productorModel' => \Waka\MaatExcel\Models\ExportRelationExcel::class,
        'productorFilesRegistration' =>  'registerExcelRelationExport',
        'noProductorBdd' => true,
        'productor_yaml_config' => '~/plugins/waka/maatexcel/models/exportrelationexcel/productor_config.yaml',
        'methods' => [
            'prepareRelationExporter' => [
                'label' => 'Télécharger Excel',
                'handler' => 'prepareRelationExporter',
            ]
        ],
    ];

    public function prepareRelationExporter($code, $allDatas): array
    {
        $this->getBaseVars($allDatas);
        $productorClass = $this->getStaticConfig('productorCreator');
        $initOptions = [
            'modelId' => $this->modelId,
        ];
        $creator = new $productorClass($code, $initOptions, $this->data);
        $creator->setOutputName(\Arr::get($allDatas, 'productorDataArray.output_name', 'fichier_sans_nom'));

        try {
            $link =  $creator->saveTo();
            return [
                'message' => 'waka.maatexcel::lang.driver.ere.execute.success.message',
                'btn' => [
                    'label' => 'waka.productor::lang.drivers.success_label.close_download',
                    'request' => 'onCloseAndDownload',
                    'link' => $link
                ],
            ];
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function updateFormwidget($slug, $formWidget, $config = [])
    {
        $formWidget->getField('output_name')->value = $config['output_name'] ?? 'Export excel';;
        return $formWidget;
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

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
        'icon' => 'icon-mjml',
        'description' => 'waka.maatexcel::lang.excel_relation_exporter.description',
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

    public function execute($code, $productorHandler, $allDatas): array
    {
        $this->getBaseVars($allDatas);
        $productorClass = $this->getStaticConfig()['productorCreator'];
        $opt = [
            'modelId' => $this->modelId,
        ];
        $creator = new $productorClass($code, $this->data, $opt);
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

    public static function updateFormwidget($slug, $formWidget)
    {
        $formWidget->getField('output_name')->value = 'Export excel';
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

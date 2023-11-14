<?php

return [
    'commons' => [
        'import_excel' => 'Import XLSX',
    ],
    'driver' => [
        'ee' => [
            'execute' => [
                'success' => [
                    'message' => 'Export ready for download',
                ],
            ],
        ],
        'ei' => [
            'execute' => [
                'success' => [
                    'message' => 'Importation completed',
                ],
            ],
        ],
        'ere' => [
            'execute' => [
                'success' => [
                    'message' => 'Relations importation completed',
                ],
            ],
        ],
        'eri' => [
            'execute' => [
                'success' => [
                    'message' => 'Importation completed',
                ],
            ],
        ],
        'excel_exporter' => [
            'label' => 'Excel Export',
        ],
        'excel_relation_exporter' => [
            'label' => 'Excel Export (relations)',
        ],
        'excel_relation_importer' => [
            'label' => 'Excel Import (relations)',
        ],
    ],
    'excel_relation_exporter' => [
        'description' => 'Exports the relations of a model',
    ],
    'excel_relation_importer' => [
        'description' => 'Imports the relations of a model',
    ],
    'models' => [
        'export_excel' => [
            'output_name' => 'Name of file to create',
        ],
    ],
    'plugin' => [
        'description' => 'Plugin providing drivers for importing and exporting items with Waka/Productor',
        'name' => 'MaatExcel',
    ],
];

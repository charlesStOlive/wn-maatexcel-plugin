<?php

return [
    'commons' => [
        'import_excel' => 'Importer XLSX',
    ],
    'driver' => [
        'excel_exporter' => [
            'label' => 'Exportation Excel',  
        ],
        'excel_relation_exporter' => [
            'label' => 'Exportation Excel (relations)',  
        ],
        'excel_relation_importer' => [
            'label' => 'Importation Excel (relations)', 
        ],
        'ee' => [
            'execute' => [
                'success' => [
                    'message' => 'Exportation prête pour téléchargement', 
                ],
            ],
        ],
        'ei' => [
            'execute' => [
                'success' => [
                    'message' => 'Importation terminée',  
                ],
            ],
        ],
        'ere' => [
            'execute' => [
                'success' => [
                    'message' => 'Importation des relations terminée',  
                ],
            ],
        ],
        'eri' => [
            'execute' => [
                'success' => [
                    'message' => 'Importation terminée',  
                ],
            ],
        ],
    ],
    'models' => [
        'export_excel' => [
            'configs' => 'Configuration',
            'output_name' => 'Nom du fichier à créer',
        ],
    ],
    'plugin' => [
        'description' => 'Plugin fournissant des drivers pour importer et exporter des éléments avec Waka/Productor',  
        'name' => 'MaatExcel',
    ],
    'excel_relation_exporter' => [
        'description' => 'Exporte les relations d\'un modèle',
    ],
    'excel_relation_importer' => [
        'description' => 'Importe les relations d\'un modèle',
    ],
];


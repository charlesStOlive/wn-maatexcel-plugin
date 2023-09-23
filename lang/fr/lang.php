<?php

return [
    'driver' => [
        'excel_relation_exporter' => [
            'label' => 'Export Excel (relations)'
        ],
        'excel_relation_importer' => [
            'label' => 'Excel Import relations'
        ]
    ],
    'models' => [
        'export_excel' => [
            'output_name' => 'Nom du fichier à créer'
        ],
        'general' => [
            'created_at' => 'Created At',
            'id' => 'ID',
            'updated_at' => 'Updated At'
        ]
    ],
    'permissions' => [
        'some_permission' => 'Some permission'
    ],
    'plugin' => [
        'description' => 'PLugin fournissant des drivers ppour importer et exporter des élements avec Waka/Productor',
        'name' => 'MaatExcel'
    ]
];

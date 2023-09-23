<?php namespace Waka\MaatExcel;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;
use App;

/**
 * MaatExcel Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = [
        'Waka.productor',
    ];
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'waka.maatexcel::lang.plugin.name',
            'description' => 'waka.maatexcel::lang.plugin.description',
            'author'      => 'Waka',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {
        $driverManager = App::make('waka.productor.drivermanager');
        $driverManager->registerDriver('excelerRelationExporter', function () {
            return new \Waka\MaatExcel\Classes\ExcelRelationExporter();
        });
        $driverManager->registerDriver('excelerRelationImporter', function () {
            return new \Waka\MaatExcel\Classes\ExcelRelationImporter();
        });

    }


    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return []; // Remove this line to activate
    }
}

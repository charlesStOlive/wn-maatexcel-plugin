<?php

namespace Waka\MaatExcel\Models;

use Model;
use System\Classes\PluginManager;

/**
 * ImportExport Model
 */
class ImportExcel extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_maatexcel_import_exports';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [''];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['*'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'excel_file' => ['System\Models\File', 'delete' => true],
    ];
    public $attachMany = [];



    public static function findBySlug($slug)
    {
        //trace_log('findBySlug code ',$slug );
        $ExcelExportClass= PluginManager::instance()->getRegistrationMethodValues("registerExcelRelationImport");
        //trace_log($ExcelExportClass);
        foreach($ExcelExportClass as $pluginBundle) {
            foreach($pluginBundle as $key=>$config) {
                if($key == $slug) {
                    //trace_log('config founded!', $config);
                    return $config;
                }
            }
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Schema;

class BaseModel extends Model
{
    static $uuidField = 'id';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        self::setUuid();
    }

    public static function setUuid() 
    {
        static::creating(function ($model) {
            // controllo l'esistenza del campo uuid
            $bFieldExists = Schema::hasColumn($model->getTable(), self::$uuidField);
            if (!$bFieldExists) {
                return false;
            }

            $uuid = self::v4();

            // controllo uuid duplicati
            $ifUuidExists = $model->find(array(self::$uuidField, $uuid))->first();
            if ($ifUuidExists) {
                // se avessi generato un uuid già esistente, lo rigenero
                $uuid = self::v4();
            }

            $model->{self::$uuidField} = $uuid;
        });
    }

    /**
     * http://www.php.net/manual/en/function.uniqid.php#94959
     */
    public static function v4() 
    {
        //return "97b792a9-2df7-441c-a9f8-addc0f14c2a2";

        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
    
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
    
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
    
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
    
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

}

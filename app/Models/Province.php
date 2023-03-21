<?php


namespace App\Models;


class Province extends BaseModel
{
    const TABLE_NAME = "province";
    protected $table = self::TABLE_NAME;

    /** Field name **/
    const FIELD_NAME = 'name';

    /** Field province_id **/
    const FIELD_PROVINCE_ID = 'province_id';

    public function city()
    {
        return $this->hasMany(City::class,City::FIELD_PROVINCE_ID,self::FIELD_PROVINCE_ID);
    }
}

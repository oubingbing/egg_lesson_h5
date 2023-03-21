<?php


namespace App\Models;


class City extends BaseModel
{
    const TABLE_NAME = "city";
    protected $table = self::TABLE_NAME;

    /** Field name **/
    const FIELD_NAME = 'name';

    /** Field city_id **/
    const FIELD_CITY_ID = 'city_id';

    /** Field province_id **/
    const FIELD_PROVINCE_ID = 'province_id';

    public function country()
    {
        return $this->hasMany(Country::class,Country::FIELD_CITY_ID,self::FIELD_CITY_ID);
    }
}

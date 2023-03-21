<?php


namespace App\Models;


class Country extends BaseModel
{
    const TABLE_NAME = "country";
    protected $table = self::TABLE_NAME;

    /** Field name **/
    const FIELD_NAME = 'name';

    /** Field city_id **/
    const FIELD_CITY_ID = 'city_id';

    /** Field country_id **/
    const FIELD_PROVINCE_ID = 'country_id';

}

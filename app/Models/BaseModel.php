<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/22 0022
 * Time: 16:24
 */

namespace App\Models;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    /** Field id 主键 **/
    const FIELD_ID = "id";

    /** Field created_at **/
    const FIELD_CREATED_AT = "created_at";

    /** Field updated_at **/
    const FIELD_UPDATED_AT = "updated_at";

    /** Field deleted_at **/
    const FIELD_DELETED_AT = "deleted_at";

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: xiaorui
 * Date: 2018/2/5
 * Time: 下午7:44
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LookUp extends Model
{
    protected $table = "userinfo_center"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = ['userinfo_id', 'type', 'openid',
        'uri', 'unionid', 'telephone', 'bindId', 'createTime', 'LastLoginTime'];//数据添加、修改时允许维护的字段
}
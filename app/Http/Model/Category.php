<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';

    public function tree()
    {
        $category = $this->all();
        return $this->getTree($category, 'id', 'pid');
    }


    public function getTree($data, $id='id', $pid='pid')
    {
        $arr =array();
        foreach ($data as $k=>$v){
            if($v->$pid == 0){
                $data[$k]['_name'] = $data[$k]['name'];
                $arr[] = $data[$k];
                foreach ($data as $m=>$n){
                    if($n->$pid == $v->$id){
                        $data[$m]['_name'] = '--- '.$data[$m]['name'];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}

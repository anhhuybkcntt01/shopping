<?php
namespace App\Components;

use App\Menu;

class MenuRecusive {
    private $html;
    public function __construct()
    {
        $this->html = '';
    }

    public function menuRecusiveAdd($parentId = 0, $subMark = '')
    {
        $data = Menu::where('parent_id',$parentId)->get();
        foreach ($data as $item)
        {
            $this->html .= '<option value=" ' .$item->id.'">'.$subMark.$item->name.'</option>';
            $this->menuRecusiveAdd($item->id, $subMark.'--');
        }
        return $this->html;

    }
    public function menuRecusiveEdit($selectedId,$parentId = 0, $subMark = '')
    {
        $data = Menu::where('parent_id',$parentId)->get();
        foreach ($data as $item)
        {
            if($item->id == $selectedId)
            {
                $this->html .= '<option selected value=" ' .$item->id.'">'.$subMark.$item->name.'</option>';
            }else {
                $this->html .= '<option value=" ' .$item->id.'">'.$subMark.$item->name.'</option>';
            }
            $this->menuRecusiveEdit($selectedId,$item->id, $subMark.'--');
        }
        return $this->html;

    }
}

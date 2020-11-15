<?php
if (!function_exists("convert_base64")) {

    function convert_base64($bod)
    {
        //data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAgAElEQVR4XmS9iZYc15Ek6pH7XhtQhR2ipB7NvPf/f/C63z
        $bod = explode(";", $bod);
        // base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAgAElEQVR4XmS9iZYc15Ek6pH7XhtQhR2ipB7NvPf/f/C63z
        $bod = explode(",", $bod[1]);
        // iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAgAElEQVR4XmS9iZYc15Ek6pH7XhtQhR2ipB7NvPf/f/C63z
        return base64_decode($bod[1]);
    }
}



if (!function_exists("sort_table")) {
    function sort_table($request, $fields)
    {
        $typeSort = ["desc" => "DESC", "asc" => "ASC"];
        $sort = "";
        foreach ($fields as $field) {
            if (!array_key_exists($field, $request))
                continue;
            if (array_key_exists($request[$field], $typeSort))
                $sort .= " `" . $field . "` " . $typeSort[$request[$field]] . ",";
        }
        // fileds `DESC` 
        return substr($sort, 0, -1);
    }
}


if (!function_exists('tree')) {
    function tree($data, $parent_id = 0, $level = 0)
    {
        $result = [];
        foreach ($data as $key => $item) {
            if ($item['parent_id'] == $parent_id) {
                $item['name'] = str_repeat('|--', $level) . $item['name'];
                $result[] = $item;
                unset($data[$key]);
                $child = tree($data, $item['id'], $level + 1);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }
}

if (!function_exists('setDataTree')) {
    // hàm này setup giá trị
    function setDataTree($cats)
    {
        $dataTree = tree($cats);
        $result = [];
        $result[''] = 'Lựa chọn bạn';
        foreach ($dataTree as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }
}


if (!function_exists('currencyFormat')) {
    // hàm này setup giá trị
    function currencyFormat($number)
    {
        $number = intval($number);
        return number_format($number)." VNĐ";
    }
}

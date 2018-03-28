<?php
include 'database.php';

$db = new MysqliDb ('localhost', 'patria_findo', 'WO9w1+BMGuw}', 'patria_satoshi');

function getItem($id = false, $currentPage = 1) {
    global $db;
    $prevPage = false;
    $nextPage = false;
    $items = array();
    if(!$id) {
        $db->pageLimit = 10;
        $items['items'] = $db->arraybuilder()->paginate("items", $currentPage);
        if ($currentPage > 1){
            $prevPage = true;
        }
        if ($currentPage < $db->totalPages) {
            $nextPage = true;
        }

        if($prevPage && $nextPage){
            $items['pagination'] = array("next" => $currentPage+1, "prev" => $currentPage-1);
        } elseif($prevPage && !$nextPage){
            $items['pagination'] = array("prev" => $currentPage-1);
        } elseif(!$prevPage && $nextPage){
            $items['pagination'] = array("next" => $currentPage+1);
        }

        return $items;
    } else {
		$db->where('id', $id);
	    return $db->get('items');
    }
}

function insertItem($name, $desc, $size, $cost) {
    global $db;
    if(!empty($name) && !empty($desc) && !empty($size) && !empty($cost)){
        $data = array (
            "item_name"         => $name,
            "item_description"  => $desc,
            "item_size"         => $size,
            "item_cost"         => $cost
        );
        $id = $db->insert ('items', $data);
        if($id)
            return '{"code": 200, "msg": "Item created"}';
    }
    return '{"code": 400, "msg": "Error"}';
}

function deleteItem($id){
    global $db;
    $db->where('id', $id);
    if($db->delete('items'))
        return '{"code": 200, "msg": "Item deleted"}';
    return '{"code": 400, "msg": "Error"}';
}

function updateItem($id, $name = false, $desc = false, $size = false, $cost = false){
    global $db;
    $data = array();
    if($name || $desc || $size || $cost){
        if($name)
            $data['item_name'] = $name;
        if($desc)
            $data['item_description'] = $desc;
        if($size)
            $data['item_size'] = $size;
        if($cost)
            $data['item_cost'] = $cost;
        $db->where('id', $id);
        if($db->update('items', $data))
            return '{"code": 200, "msg": "Item Updated"}';
        return '{"code": 400, "msg": "Error"}';
    } else {
        return '{"code": 400, "msg": "You need to enter at least one value to edit."}';
    }
}

function escape_text($text_string = '') {
    if (is_array($text_string))
        return array_map(__METHOD__, $text_string);
    if (!empty($text_string) && is_string($text_string))
        return str_replace(['\\', "\0", "\n", "\r", "'", '"', "\x1a"], ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'], $text_string);
    return $text_string;
}

function validToken($token){
	global $db;
	$db->where('token', $token);
	if($db->get('access')) {
		$data = array(
			'last_ip' => $_SERVER['REMOTE_ADDR']
		);
		$db->where('token', $token);
		$db->update('access', $data);
		return true;
	}
	return false;
}
//��ά���鰴�ֶ�����
function sortArrByField($array, $field, $desc = false){
	$fieldArr = array();
	foreach ($array as $k => $v) {
		$fieldArr[$k] = $v[$field];
	}
	$sort = $desc == false ? SORT_ASC : SORT_DESC;
	array_multisort($fieldArr, $sort, $array);
	return $array;
}
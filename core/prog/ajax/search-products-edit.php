<?php

if($core->chk_GET(V_SEARCH_QUERY)){
    header('Content-Type: application/json');
    $core->requireClass('search');
    $search = new search();
    
    $out        = array();
    $items      = array();
    $all_items  = array();
    
    if(!empty($_GET[V_PAGE_QUERY]))
        $page = $_GET[V_PAGE_QUERY];
    else
        $page = 1;
    if(!empty($_GET[V_ROWS_PER_PAGE_QUERY]))
        $rows = $_GET[V_ROWS_PER_PAGE_QUERY];
    else
        $rows = V_ROWS_PER_PAGE_SELECT2;
    
    $total_rows = 0;
    $rows_sql = $core->dbFetch('products', null, 'ORDER BY created_at DESC');
    foreach($rows_sql as $r){
        if($search->v1($_GET[V_SEARCH_QUERY], $core->aes($r['name'], 1)) || $search->v2($_GET[V_SEARCH_QUERY], $core->aes($r['name'], 1)) || $search->v1($_GET[V_SEARCH_QUERY], $core->aes($r['item_no'], 1)) || $search->v2($_GET[V_SEARCH_QUERY], $core->aes($r['item_no'], 1))){
            array_push($all_items, array(
                'id'    => $r['id'],
                'text'  => $core->aes($r['name'], 1).' ('.$core->aes($r['item_no'], 1).')'
            ));
            $total_rows++;
        }
    }
    
    $total_pages = ceil($total_rows / $rows);
    $start_from = ($page - 1) * $rows;
    if($total_rows < $start_from + $rows)
        $start_to = $total_rows;
    else
        $start_to = $start_from + $rows;
    if($total_rows > 0)
        for($i = $start_from, $j = 0; $i < $start_to; $i++, $j++)
            $items[$j] = $all_items[$i];
    $out['total_count'] = $total_rows;
    $out['matches']     = $items;
    echo json_encode($out);
}

?>
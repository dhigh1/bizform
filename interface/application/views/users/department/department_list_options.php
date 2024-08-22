
<?php 

printTree($datas);
function printTree($tree, $r = 0, $p = null) {
  //$output='';
  //print_r($tree);
   foreach ($tree as $i => $t) {
       $dash = ($t['parent'] == 0) ? '' : str_repeat('-', $r) .'';
       printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['name']);
       if ($t['parent'] == $p) {
           // reset $r
           $r = 0;
       }
       //print_r($t);
       if (isset($t['_children'])) {
        
           printTree($t['_children'], $r+1, $t['parent']);
       }
   }
   //return $output;
}

?>
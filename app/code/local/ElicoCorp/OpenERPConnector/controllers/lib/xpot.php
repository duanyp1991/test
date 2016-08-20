<?php
function xpot($obj,$type='print'){
    switch($type){
        case 'dump':
            echo "<pre style='border:1px dashed; background-color:#FFFF99; padding:5px;'>";
                var_dump($obj);
            echo "</pre>";
            break;
        case 'print':
            echo "<pre style='border:1px dashed; background-color:#99FFFF; padding:5px;'>";
                print_r($obj);
            echo "</pre>";
            break;
        case 'export':
            echo "<pre style='border:1px dashed; background-color:#CCFF66; padding:5px;'>";
                var_export($obj);
            echo "</pre>";
            break;
        default:
            echo $obj;
    }
}
?>
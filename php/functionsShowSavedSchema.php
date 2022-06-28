<?php
function showSchema(){
    $string = "SELECT * FROM `site_schemacontent` 
    LEFT JOIN `site_schema` ON `site_schemacontent`.`ID_schema` = `site_schema`.`ID` 
    LEFT JOIN `site_users` ON `site_schema`.`ID_users` = `site_users`.`ID`
    LEFT JOIN `site_oefeningen` ON `site_schemacontent`.`ID_oefeningen` = `site_oefeningen`.`ID` 
    LEFT JOIN `site_link_media` ON `site_oefeningen`.`ID` = `site_link_media`.`oefeningenID` 
    LEFT JOIN `site_media` ON `site_link_media`.`mediaID` = `site_media`.`ID`";;
    DatbQuery(null, $string);
    echo $string;
}
?>
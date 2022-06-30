<?php
function showSchema(){
    $string = "SELECT * FROM `site_schemacontent` 
    LEFT JOIN `site_schema` ON `site_schemacontent`.`ID_schema` = `site_schema`.`ID` 
    LEFT JOIN `site_users` ON `site_schema`.`ID_users` = `site_users`.`ID`
    LEFT JOIN `site_oefeningen` ON `site_schemacontent`.`ID_oefeningen` = `site_oefeningen`.`ID` 
    LEFT JOIN `site_link_media` ON `site_oefeningen`.`ID` = `site_link_media`.`oefeningenID` 
    LEFT JOIN `site_media` ON `site_link_media`.`mediaID` = `site_media`.`ID`;";
    $schema = (DatbQuery(null, $string));
    $schemaShow = array();
    while($row = $schema->fetch_all(MYSQLI_ASSOC)){
        $schemaShow[] = $row;
    }
    $arrayNumber = 0;
    $newSchema = 0;
    echo '<section class="resultBYW-section"><div class="content"><div>';
    while($arrayNumber < count($schemaShow[0])){
        if($schemaShow[0][$arrayNumber]['ID_schema'] > $newSchema){
            echo "<div class='rounded border border-dark p-2'><h1 class='text-center'>Schema " . $schemaShow[0][$arrayNumber]['ID_schema'] ." </h1>";
        }
        ?>
        <hr class="mt-3">
        <div class="row">
            <div class="col-8">
                <h4 class="text-center"><?php echo $schemaShow[0][$arrayNumber]['name'] ?></h4>
                <div class="sub d-flex gap-2 justify-content-center">
                    <p class="type"><?php echo $schemaShow[0][$arrayNumber]['type'] ?></p>
                    <p class="spiergroep"><?php echo $schemaShow[0][$arrayNumber]['spiergroepen'] ?></p>
                </div>
                <p class="description text-center"><?php echo $schemaShow[0][$arrayNumber]['description'] ?></p>
            </div>
            <div class="col-4">
                <img class="img-end" src="img/oefeningFoto/<?php echo explode("\n", $schemaShow[0][$arrayNumber]['link'])[0] ?>" alt="image">
            </div>
 
        </div>
        <?php
        $newSchema = $schemaShow[0][$arrayNumber]['ID_schema'];
        $arrayNumber++;
        if($arrayNumber >= count($schemaShow[0])){
            echo '</div>';
        }
        else{
            if($schemaShow[0][$arrayNumber]['ID_schema'] > $newSchema){
                echo '</div><br>';
            }
        }
    }
    echo '</div></div></div><div>';
}
?>
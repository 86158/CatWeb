<?php
    if(isset($_GET['geslacht']) && isset($_GET['doel']) && isset($_GET['oefeningen']) && (isset($_GET['buik']) || isset($_GET['rug']) || isset($_GET['hamstrings']) || isset($_GET['biceps']) || isset($_GET['triceps'])))
    {
        echo "Succes";
    }
    else if((!isset($_GET['geslacht']) || !isset($_GET['doel']) || !isset($_GET['oefeningen']) || (!isset($_GET['buik']) && !isset($_GET['rug']) && !isset($_GET['hamstrings']) && !isset($_GET['biceps']) && !isset($_GET['triceps']))))
    {
        echo "You forgot to fill in some fields.";
        Questions();
    }
    else
    {
        Questions();
    }
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if( isset($_POST['geslacht']) && isset($_POST['doel']) && isset($_POST['oefeningen']) && 
        (isset($_POST['buik']) || isset($_POST['rug']) || isset($_POST['hamstrings']) || isset($_POST['biceps']) || isset($_POST['triceps'])))
        {
            echo "Succes";
        }
        else if(!isset($_POST['geslacht']) || !isset($_POST['doel']) || !isset($_POST['oefeningen']) || (!isset($_POST['buik']) && !isset($_POST['rug']) && !isset($_POST['hamstrings']) && !isset($_POST['biceps']) && !isset($_POST['triceps'])))
        {
            echo "You forgot to fill in some fields.";
            Questions();
        }
    }
    else
    {
        // echo "I should only show this in the beginning.";
        Questions();
    }
?>
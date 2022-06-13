<?php
    function QuestionSpier()
    {
        ?>
        <div class="col-6">
            <div class="mb-3">
                <h4>Welke spiergroep(en) wilt u trainen?</h4>
                <!-- Triceps -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="triceps" id="inputTriceps" value="triceps">
                    <label class="form-check-label" for="inputTriceps">
                        Triceps
                    </label>
                </div>
                <!-- Rug -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="rug" id="inputRug" value="rug">
                    <label class="form-check-label" for="inputRug">
                        Rug
                    </label>
                </div>
                <!-- Buik -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="buik" id="inputBuik" value="buik">
                    <label class="form-check-label" for="inputBuik">
                        Buik
                    </label>
                </div>
                <!-- Hamstring -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hamstring" id="inputHamstring" value="hamstring">
                    <label class="form-check-label" for="inputHamstring">
                        Hamstring
                    </label>
                </div>
                <!-- Biceps -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="biceps" id="inputBiceps" value="biceps">
                    <label class="form-check-label" for="inputBiceps">
                        Biceps
                    </label>
                </div>
                <?php SubmitButton();?>
            </div>
            <img src="img/BYW3.png" alt="Muscles">
        </div>
        <?php
    }

    function BeginForm()
    {
        ?>
        <section class="buildYourWorkout-Section">
            <div class="container">
                <h1 class="text-center mb-3">Build your workout</h1>
                <form action="" method="post">
                    <input type=hidden name="page" value="build">
                    <div class="row">
        <?php
    }

    function EndForm(){
        echo '</div>';
        echo '</form></div></section>';
    }

    function QuestionGeslacht(){
        ?>
        <div class="section-gender row justify-content-center">
            <div class="col-3 first">
                <br>
                <br>
                <br>
                <h3> Wat is uw geslacht?</h3>
                <!-- Vrouw -->
                <div class="form-check fs-5">
                    <input class="form-check-input" type="radio" name="geslacht" id="inputVrouw" value="vrouw">
                    <label class="form-check-label" for="inputVrouw">
                        Vrouw
                    </label>
                </div>
                <!-- Man -->
                <div class="form-check fs-5">
                    <input class="form-check-input" type="radio" name="geslacht" id="inputMan" value="man">
                    <label class="form-check-label" for="inputMan">
                        Man
                    </label>
                </div>
                <!-- Neutraal -->
                <div class="form-check fs-5">
                    <input class="form-check-input" type="radio" name="geslacht" id="inputNeutraal" value="neutraal">
                    <label class="form-check-label" for="inputNeutraal">
                        Neutraal
                    </label>
                </div>
                 <?php SubmitButton();?>
            </div>
            <div class="col-3">
                <img src="img/BYW1.jpg" alt="Gender">
            </div>
        </div>
        <?php
    }

    function QuestionDoel(){
        ?>
        <div class="col-6">
            <div class="mb-3">
                <h4>Wat is uw doel?</h4>
                <!-- Afslanken -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="afslanken" id="inputAfslanken" value="afslanken">
                    <label class="form-check-label" for="inputAfslanken">
                        Afslanken
                    </label>
                </div>
                <!-- Spier Opbouw -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="spier" id="inputSpier" value="spier">
                    <label class="form-check-label" for="inputSpier">
                        Spier Opbouw
                    </label>
                </div>
                <!-- Conditie -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="conditie" id="inputConditie" value="conditie">
                    <label class="form-check-label" for="inputConditie">
                        Conditie
                    </label>
                </div>
                <?php SubmitButton();?>
            </div>
            <img src="img/BYW2.jpg" alt="Goal">
        </div>
        <?php
    }

    function QuestionAantal(){
        ?>
        <div class="col-6">
            <div class="mb-3">
                <h4>Wat is het aantal oefeningen dat u wilt doen?</h4>
                <!-- 3 oefeningen -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="oefeningen" id="inputDrieOefeningen" value="drie">
                    <label class="form-check-label" for="inputDrieOefeningen">
                        3 oefeningen
                    </label>
                </div>
                <!-- 4 oefeningen -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="oefeningen" id="inputVierOefeningen" value="vier">
                    <label class="form-check-label" for="inputVierOefeningen">
                        4 oefeningen
                    </label>
                </div>
                <!-- 5 oefeningen -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="oefeningen" id="inputVijfOefeningen" value="vijf">
                    <label class="form-check-label" for="inputVijfOefeningen">
                        5 oefeningen
                    </label>
                </div>
                <?php SubmitButton();?>
            </div>
            <img src="img/BYW4.png" alt="Excercises">
        </div>
        <?php
    }

    function SessionAdd(){
        if(!isset($_SESSION['workoutStart']))
        {
            $_SESSION['workoutStart'] = '';
        }
        if(!isset($_SESSION['workoutGeslacht']))
        {
            $_SESSION['workoutGeslacht'] = '';
        }
        if(!isset($_SESSION['workoutDoel']))
        {
            $_SESSION['workoutDoel'] = array();
        }
        if(!isset($_SESSION['workoutSpier']))
        {
            $_SESSION['workoutSpier'] = array();
        }
        if(!isset($_SESSION['workoutAantal']))
        {
            $_SESSION['workoutAantal'] = '';
        }
    }

    function SessionChange(){
        if(isset($_POST['start'])){
            $_SESSION['workoutStart'] = $_POST['start'];
        }
        if(isset($_POST['geslacht'])){
            $_SESSION['workoutGeslacht'] = $_POST['geslacht'];
        }
        $doel = ['afslanken', 'spier', 'conditie'];
        foreach ($doel as $value){
            if(isset($_POST[$value])) {
                array_push($_SESSION['workoutDoel'], $_POST[$value]);
            }
        }
        $spierNames = ['triceps', 'rug', 'buik', 'biceps', 'hamstring'];
        foreach ($spierNames as $value) {
            if(isset($_POST[$value])) {
                array_push($_SESSION['workoutSpier'], $_POST[$value]);
            }
        }
        if(isset($_POST['oefeningen'])){
            $_SESSION['workoutAantal'] = $_POST['oefeningen'];
        }
    }
    function CheckIfPageReloaded(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            unset($_SESSION['workoutStart']);
            unset($_SESSION['workoutGeslacht']);
            unset($_SESSION['workoutDoel']);
            unset($_SESSION['workoutSpier']);
            unset($_SESSION['workoutAantal']);
        }
    }

    function ParagraphBYW(){
        echo '<p class="beginning-text fs-5 text-center">Welkom bij Build your workout. Op deze pagina kunt u uw eigen workout samen stellen met het maken door een paar simpele vragen te beantwoorden.</p>';
        echo '<input type="hidden" name="start" value="true">';
    }
    
    function ImagesBYW(){

        SubmitButton();
        ?>
        <div class="images d-flex justify-content-around mt-5">
            <img class="" src="img/water.jpg" alt="water" style="width: 15%">;
            <img class="" src="img/graph.jpg" alt="graph" style="width: 15%">;
            <img class="" src="img/weight.jpg" alt="weight" style="width: 15%">;
        </div>
        <?php
    }

    function AddJS(){
        echo '<div class="js-local" hidden><script src="js/ajax_communication.js" defer></script><script src="js/tableFunctions.js" defer></script></div>';
    }

    function SubmitButton(){
        if($_SESSION['workoutStart'] == false){
            echo '<div class="button-start d-flex justify-content-center mt-4"><button type="submit" class="btn btn-primary" style="color: white;">Start</button></div>';
        }    
        else if(empty($_SESSION['workoutSpier'])){
            echo '<button type="submit" class="btn btn-primary align-self-center mt-4" style="color: white;">Volgende</button>';
        }
        else if($_SESSION['workoutAantal'] == ''){
            echo '<button type="submit" class="btn btn-primary">Finish</button>';
        }   
    }
?>
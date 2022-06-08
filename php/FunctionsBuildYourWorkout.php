<?php
    function QuestionSpier()
    {
        ?>
        <div class="col-6">
            <div class="mb-3">
                <h4>Welke spiergroep(en) wilt u trainen?</h4>
                <!-- Triceps -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="triceps" id="inputTriceps" value="inputTriceps">
                    <label class="form-check-label" for="inputTriceps">
                        Triceps
                    </label>
                </div>
                <!-- Rug -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="rug" id="inputRug" value="inputRug">
                    <label class="form-check-label" for="inputRug">
                        Rug
                    </label>
                </div>
                <!-- Buik -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="buik" id="inputBuik" value="inputBuik">
                    <label class="form-check-label" for="inputBuik">
                        Buik
                    </label>
                </div>
                <!-- Hamstring -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hamstring" id="inputHamstring" value="inputHamstring">
                    <label class="form-check-label" for="inputHamstring">
                        Hamstring
                    </label>
                </div>
                <!-- Biceps -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="biceps" id="inputBiceps" value="inputBiceps">
                    <label class="form-check-label" for="inputBiceps">
                        Biceps
                    </label>
                </div>
            </div>
        </div>
        <?php
    }

    function BeginForm()
    {
        ?>
        <section class="buildYourWorkout-Section">
            <div class="container">
                <h1 class="text-center">Build Your Workout</h1>
                <form action="" method="post">
                    <input type=hidden name="page" value="build">
                    <div class="row">
        <?php
    }

    function EndForm(){
        ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
        </section>
        <?php
    }

    function QuestionGeslacht(){
        ?>
        <div class="col-6">
            <div class="mb-3">
                <h4> Wat is uw geslacht?</h4>
                <!-- Vrouw -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="geslacht" id="inputVrouw" value="inputVrouw">
                    <label class="form-check-label" for="inputVrouw">
                        Vrouw
                    </label>
                </div>
                <!-- Man -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="geslacht" id="inputMan" value="inputMan">
                    <label class="form-check-label" for="inputMan">
                        Man
                    </label>
                </div>
                <!-- Neutraal -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="geslacht" id="inputNeutraal" value="inputNeutraal">
                    <label class="form-check-label" for="inputNeutraal">
                        Neutraal
                    </label>
                </div>
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
                    <input class="form-check-input" type="checkbox" name="afslanken" id="inputAfslanken" value="inputAfslanken">
                    <label class="form-check-label" for="inputAfslanken">
                        Afslanken
                    </label>
                </div>
                <!-- Spier Opbouw -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="spier" id="inputSpier" value="inputSpier">
                    <label class="form-check-label" for="inputSpier">
                        Spier Opbouw
                    </label>
                </div>
                <!-- Conditie -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="conditie" id="inputCondite" value="inputConditie">
                    <label class="form-check-label" for="inputConditie">
                        Conditie
                    </label>
                </div>
            </div>
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
                    <input class="form-check-input" type="radio" name="oefeningen" id="inputDrieOefeningen" value="inputDrieOefeningen">
                    <label class="form-check-label" for="inputDrieOefeningen">
                        3 oefeningen
                    </label>
                </div>
                <!-- 4 oefeningen -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="oefeningen" id="inputVierOefeningen" value="inputVierOefeningen">
                    <label class="form-check-label" for="inputVierOefeningen">
                        4 oefeningen
                    </label>
                </div>
                <!-- 5 oefeningen -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="oefeningen" id="inputVijfOefeningen" value="inputVijfOefeningen">
                    <label class="form-check-label" for="inputVijfOefeningen">
                        5 oefeningen
                    </label>
                </div>
            </div>
        </div>
        <?php
    }

    function SessionAdd(){
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
            unset($_SESSION['workoutGeslacht']);
            unset($_SESSION['workoutDoel']);
            unset($_SESSION['workoutSpier']);
            unset($_SESSION['workoutAantal']);
        }
    }
?>
<?php
require_once './php/credentialFunctions.php';
$data = getInfo();
?>
<!-- The section of the profile page -->
<div class="section-profilepage">
    <div class="container-fluid">
        <!-- The image and username of the user -->
        <div class="profile d-flex column justify-content-center align-items-center flex-column mt-3">
            <img class="rounded-circle" src="img/profile.png" alt="Profile Pic">
            <h5 class="mt-2"><?php if(is_array($data) && is_string($data['username'])) echo $data['username']; else echo 'Username';?></h5>
        </div>
        <div class="information mt-4 d-flex justify-content-around">
            <div class="profileInformation">
                <!-- The left side of the page -->
                <div class="title">
                    <h2 class="fw-bold text-center">Profile information</h2>
                    <hr class="mt-3">
                </div>
                <form method=POST class="credentials fs-5">
                    <input type=hidden name=formID value=updateUser />
                    <input type=hidden name=page value=user />
                    <!-- First Name -->
                    <label class="row item-1 justify-content-between">
                        <div class="col-6 text-center">
                            <p class="fw-bold">Voornaam</p>
                        </div>
                        <div class="col-6 text-center">
                            <input type=text name=FirstName autocomplete=given-name <?php if(is_array($data) && is_string($data['FirstName'])) echo 'value="', $data['FirstName'], '" ';?>>
                        </div>
                    </label>
                    <!-- Horizontal Line -->
                    <hr class="hr-1 text-center m-auto mb-3">
                    <!-- Last Name -->
                    <label class="row item-1 justify-content-between">
                        <div class="col-6 text-center">
                            <p class="fw-bold">Achternaam</p>
                        </div>
                        <div class="col-6 text-center">
                            <input type=text name=LastName autocomplete=family-name <?php if(is_array($data) && is_string($data['LastName'])) echo 'value="', $data['LastName'], '" ';?>>
                        </div>
                    </label>
                    <!-- Horizontal Line -->
                    <hr class="text-center m-auto mb-3">
                    <!-- Email -->
                    <label class="row item-1 justify-content-between">
                        <div class="col-6 text-center">
                            <p class="fw-bold">Email</p>
                        </div>
                        <div class="col-6 text-center">
                            <input type=email autocomplete=email name=email <?php if(is_array($data) && is_string($data['email'])) echo 'value="', $data['email'], '" ';?>>
                        </div>
                    </label>
                    <!-- Horizontal Line -->
                    <hr class="text-center m-auto mb-3">
                    <!-- Password -->
                    <label class="row item-1 justify-content-between">
                        <div class="col-6 text-center">
                            <p class="fw-bold">Wachtwoord</p>
                        </div>
                        <div class="col-6 text-center">
                            <input type=password autocomplete=new-password name=pwd>
                        </div>
                    </label>
                    <!-- Button to change the information about the user -->
                    <button type=submit class="btn btn-primary d-flex m-auto mt-3">Verander uw gegevens</button>
                    <button type=reset class="btn btn-primary d-flex m-auto mt-3">Reset</button>
                </form>
            </div>
            <!-- Right side of the page -->
            <div class="profileFavourites">
                <div class="title">
                    <h2 class="text-center fw-bold">Favorite Exercises</h2>
                    <hr class="mt-3">
                </div>
                <!-- The content of the favourites section -->
                <div class="content">

                </div>
                <a class="btn btn-primary d-flex m-auto mt-3" href="?page=favorieten">Zie alle favorieten oefeningen</a>
            </div>
        </div>
    </div>
</div>
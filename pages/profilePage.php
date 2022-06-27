<?php
require_once './php/credentialFunctions.php';
$data = getInfo();
?>
<!-- The section of the profile page -->
<div class="section-profilepage">
    <div class="container-fluid">
        <!-- The image and username of the user -->
        <div class="profile d-flex justify-content-center align-items-center flex-column mt-3">
            <img class="rounded-circle" src="img/profile.png" alt="Profile Pic" style="width: 7%; height: 7%;">
            <h5 class="mt-2"><?php if(is_array($data) && is_string($data['username'])) echo $data['username']; else echo 'Username';?></h5>
        </div>
        <!-- Bottom of the page -->
        <div class="row justify-content-around mt-3">
            <div class="col-5">
                <!-- The left side of the page -->
                <div class="profileInformation">
                    <div class="title d-flex flex-column align-items-center">
                        <h2 class="fw-bold text-center">Profile information</h2>
                        <hr class="mt-3" style="width: 50%;">
                    </div>
                    <form class="d-flex flex-column m-auto" method=POST class="credentials fs-5" style="width: 60%;">
                        <input type=hidden name=formID value=updateUser />
                        <input type=hidden name=page value=user />
                        <!-- First Name -->
                        <label class="row item-1 justify-content-between">
                            <div class="col-6">
                                <p class="fw-bold">Voornaam</p>
                            </div>
                            <div class="col-6 text-center">
                                <input type=text name=FirstName autocomplete=given-name <?php if(is_array($data) && is_string($data['FirstName'])) echo 'value="', $data['FirstName'], '" ';?>>
                            </div>
                        </label>
                        <!-- Last Name -->
                        <label class="row item-1 justify-content-between">
                            <div class="col-6">
                                <p class="fw-bold">Achternaam</p>
                            </div>
                            <div class="col-6 text-center">
                                <input type=text name=LastName autocomplete=family-name <?php if(is_array($data) && is_string($data['LastName'])) echo 'value="', $data['LastName'], '" ';?>>
                            </div>
                        </label>
                        <!-- Email -->
                        <label class="row item-1 justify-content-between" title="Changing password or email requires password field to be filled.">
                            <div class="col-6">
                                <p class="fw-bold">Email</p>
                            </div>
                            <div class="col-6 text-center">
                                <input type=email autocomplete=email name=email <?php if(is_array($data) && is_string($data['email'])) echo 'value="', $data['email'], '" ';?>>
                            </div>
                        </label>
                        <!-- Password -->
                        <label class="row item-1 justify-content-between" title="Changing password or email requires password field to be filled.">
                            <div class="col-6">
                                <p class="fw-bold">Nieuw wachtwoord</p>
                            </div>
                            <div class="col-6 text-center">
                                <input type=password autocomplete=new-password name=pwd_new>
                            </div>
                        </label>
                        <!-- Password -->
                        <label class="row item-1 justify-content-between" title="Changing password or email requires password field to be filled.">
                            <div class="col-6">
                                <p class="fw-bold">Wachtwoord</p>
                            </div>
                            <div class="col-6 text-center">
                                <input type=password autocomplete=new-password name=pwd_old>
                            </div>
                        </label>
                        <!-- Button to change the information about the user -->
                        <button type=submit class="btn btn-primary d-flex m-auto mt-3" style="color: white;">Verander uw gegevens</button>
                        <button type=reset class="btn btn-primary d-flex m-auto mt-3" style="color: white;">Reset</button>
                    </form>
                </div>
            </div>
            <div class="col-5">
                <!-- Right side of the page -->
                <div class="profileFavourites">
                    <div class="title d-flex flex-column align-items-center">
                        <h2 class="text-center fw-bold">Favorite Exercises</h2>
                        <hr class="mt-3" style="width: 50%;">
                    </div>
                    <!-- The content of the favourites section -->
                    <div class="content d-flex justify-content-center">
                        <a class="btn btn-primary m-auto mt-3" href="?page=favorieten" style="color: white;">Zie alle favorieten oefeningen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
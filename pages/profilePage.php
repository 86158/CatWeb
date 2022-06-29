<?php
require_once './php/credentialFunctions.php';
$id = $_SESSION['ID'];
$pwdKey = $_SESSION['pwdKey'];
$data = 'Incorrect/missing ID and pwdKey values';
if(is_int($id) && is_string($pwdKey))
	$data = getInfo($id, $pwdKey);
?>
<!-- The section of the profile page -->
<section class="profilepage-section">
    <div class="container-fluid">
        <!-- The image and username of the user -->
        <div class="profile d-flex justify-content-center align-items-center flex-column mt-3">
            <img class="rounded-circle" src="img/profile.png" alt="Profile Pic">
            <h5 class="mt-2"><?php if(is_array($data) && is_string($data['username'])) echo $data['username']; else echo 'Username';?></h5>
        </div>
        <!-- Bottom of the page -->
        <div class="row mt-3">
            <div class="col-4">
                <!-- The left side of the page -->
                <div class="profileInformation">
                    <div class="title d-flex flex-column align-items-center">
                        <h2 class="fw-bold text-center">Profiel Informatie</h2>
                        <hr class="mt-1">
                    </div>
                    <form class="d-flex flex-column m-auto" method=POST class="credentials fs-5">
                        <input type=hidden name=formID value=updateUser />
                        <input type=hidden name=page value=user />
                        <!-- First Name -->
                        <label class="row item-1 justify-content-between">
                            <div class="col-6">
                                <p class="fw-bold">Voornaam</p>
                            </div>
                            <div class="col-6 text-center">
                                <input class="inputs" type=text name=FirstName autocomplete=given-name pattern="\w*"<?php if(is_array($data) && is_string($data['FirstName'])) echo 'value="', $data['FirstName'], '" ';?>>
                            </div>
                        </label>
                        <!-- Last Name -->
                        <label class="row item-1 justify-content-between">
                            <div class="col-6">
                                <p class="fw-bold">Achternaam</p>
                            </div>
                            <div class="col-6 text-center">
                                <input class="inputs" type=text name=LastName autocomplete=family-name pattern="\w*"<?php if(is_array($data) && is_string($data['LastName'])) echo 'value="', $data['LastName'], '" ';?>>
                            </div>
                        </label>
                        <!-- Email -->
                        <label class="row item-1 justify-content-between" title="Changing password or email requires password field to be filled.">
                            <div class="col-6">
                                <p class="fw-bold">Email</p>
                            </div>
                            <div class="col-6 text-center">
                                <input class="inputs" type=email autocomplete=email name=email<?php if(is_array($data) && is_string($data['email'])) echo 'value="', $data['email'], '" ';?>>
                            </div>
                        </label>
                        <!-- Password -->
                        <label class="row item-1 justify-content-between">
                            <div class="col-6">
                                <p class="fw-bold">Nieuw wachtwoord</p>
                            </div>
                            <div class="col-6 text-center">
                                <input class="inputs" type=password autocomplete=new-password pattern="[^\0\n\f\r\t\v]*" name=pwd_new>
                            </div>
                        </label>
                        <!-- Password -->
                        <label class="row item-1 justify-content-between">
                            <div class="col-6">
                                <p class="fw-bold">Wachtwoord</p>
                            </div>
                            <div class="col-6 text-center">
                                <input class="inputs" type=password autocomplete=new-password pattern="[^\0\n\f\r\t\v]+" name=pwd_old required>
                            </div>
                        </label>
                        <!-- Button to change the information about the user -->
                        <button type=submit class="btn btn-primary d-flex m-auto mt-3">Verander uw gegevens</button>
                        <button type=reset class="btn btn-primary d-flex m-auto mt-3">Reset</button>
                    </form>
                </div>
            </div>
            <div class="col-4">
                <div class="profileSavedSchema">
                    <div class="title d-flex flex-column align-items-center">
                        <h2 class="text-center fw-bold">Opgeslagen Schema</h2>
                        <hr class="mt-1" style="width: 50%;">
                    </div>
                    <!-- The content of the saved schema section -->
                    <div class="content d-flex justify-content-center">
                        <a class="btn btn-primary m-auto mt-3" href="?page=savedSchema" style="color: white;">Zie alle opgeslagen Schema's</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <form id="js-filters" aria-label="Filters">
                    <!-- Right side of the page -->
                    <div class="profileFavourites">
                        <div class="title d-flex flex-column align-items-center">
                            <h2 class="text-center fw-bold">Favoriete Oefeningen</h2>
                            <hr class="mt-1">
                        </div>
                        <!-- The content of the favourites section -->
                        <section id="js-oefeningen"></section>



                        <!-- <div class="content d-flex justify-content-center">
                            <a class="btn btn-primary m-auto mt-2" href="?page=favorieten">Zie alle favorieten oefeningen</a>
                        </div> -->
                    </div>  
                </form>
            </div>
        </div>
    </div>
</section>
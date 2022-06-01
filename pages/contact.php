<section class="contact-section">
    <div class="container">
        <h1 class="text-center mb-2">Contact</h1>
        <div class="row justify-content-between">
            <div class="col-6">
                <h5>Formulier</h5>
                <hr class="w-25">
                <!-- Form -->
                <form>
                    <div class="mb-3">
                        <label for="formName" class="form-label">Name</label>
                        <input type="name" class="form-control w-75" id="formName">
                    </div>
                    <div class="mb-3">
                        <label for="formEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control w-75" id="formEmail">
                    </div>
                    <div class="mb-3">
                        <label for="formTitel" class="form-label">Titel</label>
                        <input type="titel" class="form-control w-75" id="formTitel">
                    </div>
                    <div class="mb-3">
                        <label for="formBeschrijving" class="form-label">Beschrijving</label>
                        <textarea type="beschrijving" class="form-control" rows="5" id="formBeschrijving" name="text"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-75">Submit</button>
                </form>
            </div>
            <!-- Vertical line in between two columns -->
            <div class="col-1 text-center">
                <div class="vr h-100 mt-3"></div>
            </div>
            <div class="col-5">
                <h5>Veelgestelde vragen</h5>
                <hr class="w-75">
                <!-- Accordion -->
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Accordion Item #1
                        </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Accordion Item #2
                        </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Accordion Item #3
                        </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
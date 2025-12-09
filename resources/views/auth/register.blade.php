@include('partials.header')

<main class="register">
    <!-- Feature Section with Title and Breadcrumb -->
    <div class="container">
        <div class="row text-center">
            <!-- Title -->
            <div class="formdiv col-12">
                <h1 class="display-4">Register</h1>
            </div>
            <!-- Breadcrumb -->
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="bi bi-house-fill"></i> Home</a> <!-- Home Icon added -->
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Register</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row text-start">
            <div class="col-12">
                <h1 class="display-5">Start From here</h1>
                <h2 class="display-6">Account Application</h2>
                <p class="display-7">Already have an account? <a href="#">Log In</a></p>
            </div>
        </div>
    </div>
    <!-- Flash message for success or error -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Registration Form Section -->
    <div class="container mt-5" style="background: black;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Legal Notice -->
                <div class="smaller-div p-3 mb-3">
                    <h5>AUTOBOLI LTD is exclusively designed for use by independent dealers, motor dealers, traders, and
                        individuals engaged in the motor business. By using our platform, you confirm that you meet this
                        criterion.</h5>
                    <p>We reserve the right to terminate or suspend accounts if we determine that a user does not meet
                        these eligibility requirements. <a href="#">Read more</a></p>
                </div>

                <!-- Form -->
                <div>
                    <form method="POST" id="companyForm" action="{{ url('/register') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $planId }}">

                        <!-- Company Details Section -->
                        <h4 class="proof">Company Details</h4>
                        <div class="dividerhead"></div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="companyName" name="companyName"
                                    placeholder="Company / Trading or Business Name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="companyAddress1" name="companyAddress1"
                                    placeholder="Company Address 1" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select class="form-select" id="businessType" name="businessType" required>
                                    <option value="" disabled selected>Business Type</option>
                                    <option value="MotorTrader">Motor Trader</option>
                                    <option value="CarSupermarket">Car Supermarket</option>
                                    <option value="FranchiseDealer">Franchise Dealer</option>
                                    <option value="Fleet">Fleet</option>
                                    <option value="SmallIndependent">Small Independent</option>
                                    <option value="LargeIndependent">Large Independent</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="companyAddress2" name="companyAddress2"
                                    placeholder="Company Address 2 (Optional)">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="companyReg" name="companyReg"
                                    placeholder="Company Reg. Number (Optional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="townCity" name="townCity"
                                    placeholder="Town / City" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="url" class="form-control" id="website" name="website"
                                    placeholder="Website (Optional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="country" name="country"
                                    placeholder="Country" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control" id="businessEmail" name="businessEmail"
                                    placeholder="Business Email (Optional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="postcode" name="postcode"
                                    placeholder="Postcode / Zip Code" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select class="form-control" id="motorTradeInsurance" name="motorTradeInsurance"
                                    required>
                                    <option value="" disabled selected>Motor Trade Insurance? (Optional)</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="tel" class="form-control" id="telephone" name="telephone"
                                    placeholder="Telephone" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="vatNumber" name="vatNumber"
                                    placeholder="VAT Number (if applicable)">
                            </div>
                        </div>

                        <!-- Personal Information Section -->
                        <h4 class="proof mt-4">Personal Information</h4>
                        <div class="dividerhead"></div>

                        <p class="dividerper">Provide the name and contact details of proprietors, partners, directors,
                            and authorized buyer for AUTOBOLI LTD, along with proof of identity (driving license or
                            passport in .jpg, .png, or .pdf format).</p>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    placeholder="First Name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" id="surname" name="surname"
                                    placeholder="Surname" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Title">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" id="jobTitle" name="jobTitle"
                                    placeholder="Job Title">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="+44">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="email" class="form-control" id="personalEmail" name="personalEmail"
                                    placeholder="Personal Email for Login" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                            </div>

                            <!-- Password Confirmation -->
                            <div class="col-md-6 mb-3">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm Password" required>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <h4 class="proof mt-4">File Uploads</h4>
                        <div class="dividerhead"></div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="uploadID" class="form-label">Upload ID*</label>
                                <div class="custom-file">
                                    <!-- Hidden file input -->
                                    <input type="file" class="form-control d-none" id="uploadID" name="uploadID"
                                        accept=".jpg, .png, .pdf">
                                    <!-- Custom button -->
                                    <button type="button" class="upload btn btn-primary"
                                        id="selectFileButton1">Select file (Max. 4MB)</button>
                                    <!-- Display selected file name -->
                                    <div id="fileName1" class="mt-2 text-muted"></div>
                                </div>
                                <div class="form-text">Upload must be in .jpg, .png or .pdf format.</div>
                            </div>
                        </div>

                        <!-- JavaScript to trigger file input and show selected file name -->
                        <script>
                            // File upload for ID
                            document.getElementById('selectFileButton1').addEventListener('click', function() {
                                document.getElementById('uploadID').click();
                            });

                            document.getElementById('uploadID').addEventListener('change', function() {
                                var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
                                document.getElementById('fileName1').textContent = 'Selected file: ' + fileName;
                            });
                        </script>

                        <!-- Repeat for other file uploads -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="motorTradeProof" class="form-label">Proof of Motor Trade
                                    (Optional)</label>
                                <div class="custom-file">
                                    <input type="file" class="form-control d-none" id="motorTradeProof"
                                        name="motorTradeProof" accept=".jpg, .png, .pdf">
                                    <button type="button" class="upload btn btn-primary"
                                        id="selectFileButton2">Select file (Max. 4MB)</button>
                                    <div id="fileName2" class="mt-2 text-muted"></div>
                                </div>
                                <div class="form-text">Upload must be in .jpg, .png or .pdf format.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="addressProof" class="form-label">Proof of Address *</label>
                                <div class="custom-file">
                                    <input type="file" class="form-control d-none" id="addressProof"
                                        name="addressProof" accept=".jpg, .png, .pdf">
                                    <button type="button" class="upload btn btn-primary"
                                        id="selectFileButton3">Select file (Max. 4MB)</button>
                                    <div id="fileName3" class="mt-2 text-muted"></div>
                                </div>
                                <div class="form-text">Upload must be in .jpg, .png or .pdf format.</div>
                            </div>
                        </div>

                        <!-- JavaScript for other file inputs -->
                        <script>
                            // File upload for Motor Trade Proof
                            document.getElementById('selectFileButton2').addEventListener('click', function() {
                                document.getElementById('motorTradeProof').click();
                            });

                            document.getElementById('motorTradeProof').addEventListener('change', function() {
                                var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
                                document.getElementById('fileName2').textContent = 'Selected file: ' + fileName;
                            });

                            // File upload for Address Proof
                            document.getElementById('selectFileButton3').addEventListener('click', function() {
                                document.getElementById('addressProof').click();
                            });

                            document.getElementById('addressProof').addEventListener('change', function() {
                                var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
                                document.getElementById('fileName3').textContent = 'Selected file: ' + fileName;
                            });
                        </script>


                        <!-- Terms and Conditions -->
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="termsConditions"
                                name="termsConditions" required>
                            <label class="form-check-label" for="termsConditions">By submitting this form, you are
                                accepting the terms and conditions and privacy policy which apply when buying with
                                AutoBoli LTD.</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
</main>

@include('partials.footer')

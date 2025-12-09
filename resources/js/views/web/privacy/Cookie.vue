<template>
    <v-container fluid class="" max-width="1500px">

        <div class="mt-16 mx-auto content d-flex w-100 ga-12">

            <div class="position-sticky d-none d-md-block" style="min-width: 200px; top: 120px; align-self: flex-start;">
               <Sidebar/>
            </div>

            <div class="flex-grow-1 mt-10">
                <div>
                    <h1 class="text-h6 text-lg-h4  text-md-h5 font-weight-bold mb-10">Cookie Policy</h1>
                    <p class="my-5 text-body-1">Your privacy is extremely important to us. To better protect you, we
                        provide
                        this notice explaining our online information practices and the choices you can make about
                        the way your information is collected and used.</p>

                    <p class="my-5 text-body-1">This Privacy Policy relates to information collected by Mango
                        Technologies, Inc.
                        DBA ClickUp (referred to in this Privacy Policy as "ClickUp" "we" or "us" or "our") through
                        your use of our website and our Services, features, browser extensions, integrations, API,
                        mobile or desktop applications, information available on our website or app, or when you
                        otherwise interact with us (which are collectively referred to in this Privacy Policy as the
                        "ClickUp Service").</p>

                    <p class="font-weight-bold text-body-1">
                        If you do not agree to our use of your personal data in line with this policy, please do not
                        use the ClickUp Services.
                    </p>
                </div>

                <div>
                    <h1 class="text-h3  text-md-h2 font-weight-bold mt-12 mb-10">Scope of this Privacy Policy</h1>
                    <p class="my-5 text-body-1">Please be aware that this Privacy Policy does not govern all the
                        information
                        ClickUp may process. Our commitment to customers and service providers is governed by a separate
                        <a class="text-decoration-none" href="#">Data Protection Addendum</a>. This Privacy Policy is
                        also
                        incorporated into and governed by our <a class="text-decoration-none" href="@">Terms of
                            Use</a>.
                    </p>

                    <p class="my-6 text-body-1">Our commitments to employees are governed by our internal employment
                        policies.</p>

                    <p class="font-weight-bold text-body-1">
                        In all instances we are committed to transparency with our customers, employees, and to
                        protecting
                        your data privacy. </p>
                </div>

                <div>
                    <h1 class="text-h3  text-md-h2 font-weight-bold mt-12 mb-10">What Information do we Collect?</h1>
                    <p class="my-5 text-body-1">You will be required to establish an account in order to take advantage
                        of
                        certain features of the ClickUp Service. If you wish to establish an account you will be
                        required to
                        provide us with information (including personally identifiable information and non-personally
                        identifiable information). In addition, we may obtain your personally identifiable information
                        from
                        you if you identify yourself to us by sending us an e-mail with questions or comments.
                    </p>

                    <p class="my-5 text-body-1">Depending on your use of the ClickUp Service, we collect two types of
                        information:
                        personally identifiable information and non-personally identifiable information.</p>
                </div>
                <div>
                    <h1 class="text-h3  text-md-h2 font-weight-bold mt-12 mb-10">Personally Identifiable Information</h1>
                    <p class="my-5 text-body-1">Personally identifiable information identifies you or can be used to
                        identify or contact you. Examples of personally identifiable information may include your name,
                        IP
                        address, company name, job title, address, e-mail address, telephone number, and billing and
                        credit
                        card information.
                    </p>

                </div>

                <div>
                    <h1 class="text-h3  text-md-h2 font-weight-bold mt-12 mb-10">Non-Personally Identifiable Information</h1>
                    <p class="my-5 text-body-1">Non-personally identifiable information is information, any single item
                        of
                        which, by itself, cannot be used to identify or contact you, which may include demographic
                        information (such as age, profession, company industry, gender, current location, or zip code),
                        IP
                        addresses, browser types, domain names, and statistical data involving the use of the ClickUp
                        Service. Certain non-personally identifiable information may be considered a part of your
                        personally
                        identifiable information if it were combined with other identifiers (for example, combining your
                        zip
                        code with your street address) in a way that enables you to be identified. But the same pieces
                        of
                        information may be considered non-personally identifiable information when they are taken alone
                        or
                        combined only with other non-personally identifiable information (for example, your account
                        preferences).</p>
                </div>
                <div>
                    <h1 class="text-h3  text-md-h2 font-weight-bold mt-12 mb-10">Why do we Need your Personal Data?</h1>
                    <p class="my-5 text-body-1">We do not sell any data, including your personal data. We will only
                        collect
                        and process your personal data in accordance with applicable data protection and privacy laws.
                        We
                        need to collect and process certain personal data in order to provide you with access to
                        ClickUp. If
                        you registered with us, you will have been asked to check a tick box indicating your agreement
                        to
                        provide this data in order to access our services. This consent provides us with the legal basis
                        we
                        require under applicable law to process your data. You maintain the right to withdraw such
                        consent
                        at any time.</p>
                </div>
                <div>
                    <h1 class="text-h3  text-md-h2 font-weight-bold mt-12 mb-10">Information we collect automatically when you use
                        the
                        Services:</h1>
                    <p class="my-5 text-body-1">We collect information about you when you use our Services, such as
                        browsing
                        our websites and taking certain actions within the Services, including:</p>
                    
                </div>
            </div>



        </div>
    </v-container>
</template>


<script>
import Sidebar from './Sidebar.vue';

export default {
    components : {
        Sidebar,
    }
}
</script>
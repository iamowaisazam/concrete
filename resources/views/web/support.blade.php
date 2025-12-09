@extends('web.partial.layout')

@section('css')
<style>
 

    /* .form-section,
    .faq-section {
    } */
.faq-section,
.faq-section * {
    color: #ffffff !important;
    font-size: var(--font-p1)
}


.faq-section a {
    color: var(--text-color) !important;
    text-decoration: none;
}

/* .faq-section a:hover {
    text-decoration: underline;
    color: #2847d3 !important;
} */
    .form-label {
        color: var(--dimtext);
        font-size: var(--font-p1);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control {
        background: #1a2533b0;
        border: 1px solid var(--items-border-colur);
        border-radius: 5px;
        color: #ffffff;
        backdrop-filter: blur(8px);

        padding: 0.75rem 1rem;
    }

    .form-control:focus {
        background: transparent;   
        border-color: var(--text-color);
        box-shadow: none;
        /* box-shadow: 0 0 0 0.2rem rgba(66, 153, 225, 0.25); */
        color: var(--white-text);
    }

    .form-control::placeholder {
        color: var(--nave-text-color);
    }

    .btn-primary {
        background: #4299e1;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 5px;
        font-weight: 500;
    }

    .btn-primary:hover {
        background: #3182ce;
    }

    .btn-outline-secondary {
        border: 1px solid #8892b0;
        color: var(--dimtext);
        padding: 0.75rem 2rem;
        border-radius: 5px;
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ffffff;
        color: #ffffff;
    }

    

    .faq-item {
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        margin-bottom: 1rem;
        background: rgba(255, 255, 255, 0.05);
    }

    .faq-header {
        padding: 1rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .faq-header:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .faq-header.active {
        background: #0031649e;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .faq-content {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: all 0.4s ease;
        padding: 0 1.5rem;
    }

    .faq-content.show {
        max-height: 300px;
        opacity: 1;
        font-size: var(--font-p2);
        padding: 1rem 1.5rem;
    }

    .faq-icon {
        transition: transform 0.3s ease;
    }

    .faq-header.active .faq-icon {
        transform: rotate(45deg);
    }

    .learn-more-link {
        color: var(--text-color);
        text-decoration: none;
    }

    .learn-more-link:hover {
        text-decoration: underline;
    }

    .help-text {
        color: #8892b0;
        font-size: 0.9rem;
        margin-top: 1rem;
    }

    .faq-icon-top-left {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .faq-icon-top-left i {
        color: #ffffff;
        background: #2d3748;
        border-radius: 10px;
        padding: 12px;
        /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);    */
    }
.cover {
    background: linear-gradient(
            to right,
            #010b16d8 40%,
            #010b16 100%,
            rgba(0, 0, 0, 0) 110%
        ),
        url("{{ asset('/public/theme/assets/CarGroup.png') }}");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    display: flex;
    align-items: flex-end; 
    padding-bottom: 10px; 
}
.btnGlass {
    background: rgba(0, 49, 100, 0.6);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.15);
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 1rem;
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px #0031649e;
    position: relative;
    overflow: hidden;
}

.btnGlass:hover {
    background: #0356af80;
    border-color: rgb(255, 255, 255);
    color: #ffffff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
   
}






    @media (max-width: 991.98px) {
        .row.min-vh-100 {
            flex-direction: column;
        }

        .main-title {
            font-size: 2.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100 align-items-center ">
        <!-- Left: Contact Form -->
        <div class="col-lg-6 d-flex justify-content-center cover">
            <div class="w-100 px-4" style="max-width: 700px;">
               

                <div class="form-section">
                     <h2 class="main-title" style="color: white">Contact Us</h2>
                    <form id="contactForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name <span style="color: red;">*</span> </label>
                                <input type="text" class="form-control" name="name" placeholder="Full Name" >
                                <div class="invalid-feedback" id="error-name"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone" placeholder="Phone Number">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email </label>
                                <input type="email" class="form-control" name="email" placeholder="Email" >
                            </div>
                           
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" placeholder="Country">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" placeholder="City">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="postal_code" placeholder="Postal Code">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profession / Organization</label>
                            <input type="text" class="form-control" name="profession" placeholder="Profession / Organization">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Question <span style="color: red;">*</span> </label>
                            <textarea class="form-control" name="message" rows="4"  placeholder="Your Question"></textarea>
                            <div class="invalid-feedback" id="error-message"></div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <button type="submit" class="btn btnGlass">Send</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- Right: FAQ -->
      <div class="col-lg-6 d-flex justify-content-center">
    <div class="w-100 px-4" style="max-width: 700px;">
        <div class="faq-section position-relative">

  

            <div class="faq-icon-top-left mb-3">
              
            </div>

            @php
                $faqs = [
                    [
                        'title' => "I'm interested in a lifetime account.",
                        'content' => "Of course you are! It's an incredible deal. Pay once, and access the entire Laracasts catalog (including all future content) FOREVER. <a href='#' class='learn-more-link'>Learn more here</a>.",
                        'active' => true,
                    ],
                    [
                        'title' => "May I pay with Paypal?",
                        'content' => "Yes, PayPal is accepted for all subscription plans and lifetime accounts.",
                    ],
                    [
                        'title' => "I have a question about business/team accounts.",
                        'content' => "We offer special pricing for teams and businesses. Contact us for more information about bulk licensing.",
                    ],
                    [
                        'title' => "I have a code-related question.",
                        'content' => "For code-related questions, please use our community forum where you can get help from other developers.",
                    ],
                    [
                        'title' => "We're interested in advertising with you.",
                        'content' => "We'd love to hear from you! Please reach out with details about your advertising needs and budget.",
                    ]
                ];
            @endphp

            @foreach($faqs as $faq)
                <div class="faq-item">
                    <div class="faq-header {{ isset($faq['active']) ? 'active' : '' }}" onclick="toggleFaq(this)">
                        <span>{!! $faq['title'] !!}</span>
                        <i class="fas {{ isset($faq['active']) ? 'fa-times' : 'fa-plus' }} faq-icon"></i>
                    </div>
                    <div class="faq-content {{ isset($faq['active']) ? 'show' : '' }}">
                        {!! $faq['content'] !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

    </div>
</div>
@endsection

@section('js')
<script>
    function toggleFaq(element) {
        const content = element.nextElementSibling;
        const icon = element.querySelector('.faq-icon');

        document.querySelectorAll('.faq-header').forEach(header => {
            if (header !== element) {
                header.classList.remove('active');
                header.nextElementSibling.classList.remove('show');
                header.querySelector('.faq-icon').classList.remove('fa-times');
                header.querySelector('.faq-icon').classList.add('fa-plus');
            }
        });

        element.classList.toggle('active');
        content.classList.toggle('show');

        if (element.classList.contains('active')) {
            icon.classList.remove('fa-plus');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-plus');
        }
    }
</script>

<script>
$(document).ready(function () {
    $('#contactForm').submit(function (e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: "{{ url('/send-contact') }}",
            method: 'POST',
            data: form.serialize(),
            success: function (res) {
                toastr.success(res.message);
                form[0].reset();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $('.invalid-feedback').text('');
                    $('.form-control').removeClass('is-invalid');

                    $.each(errors, function (key, value) {
                        let errorDiv = $('#error-' + key);
                        let inputField = $('[name="' + key + '"]');

                        inputField.addClass('is-invalid');
                        errorDiv.text(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong!');
                }
            }

        });
    });
});

</script>

@endsection

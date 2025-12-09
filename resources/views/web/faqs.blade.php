@extends('web.partial.layout')
@section('css')
    <style>
        .faq-content {
            border-radius: 2px;
            min-width: 40vw;
            margin-bottom: 40px;
            transition: .5s
        }

        .accordion-button {
            background-color: #1e1e1e;
            color: var(--white-text) !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: #2a2a2a;
            color: var(--white-text) !important;
        }
        
       .faq-content.active .toggle-icon {
        color: var(--text-color) !important; /* Tumhara icon & text color */
}
.faq-content.active {
    background-color: var(--background-color) !important;
    color: white !important;
    padding-top: 22px;
}
.faq-content.active h5 span{
 
    color: white !important;
  
}
.toggle-icon {
    font-size: var(--font-h4);
    font-weight: 400;
}




        /* .accordion-body {
                color: var(--white-text) !important;
                font-size: 16px !important;
                font-weight: 200 !important;
            } */

        /* .toggle-icon {
                font-size: 1.5rem;
                font-weight: bold;

            } */
    </style>
@endsection

@section('content')
    <section style="background: var(--background-color2); padding: 10px 20px"  >
    <div style="margin: 10px 500px">
        <h4 class=" text-center " style="margin: 100px 100px; color: var(--white-text)">
            Frequently Asked Questions
        </h4>

        <!-- Tab 1 -->
       <div class="accordion" id="faqAccordion">
    
    <!-- Tab 1 -->
    <div class="faq-content">
        <div style="border-bottom: 1px solid var(--items-border-colur)">
            <h5 class="accordion-header" id="headingOne1">
                <div class="d-flex justify-content-between align-items-center px-3"
                    style="color: var(--dimtext); cursor: pointer; padding-bottom: 2rem"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseOne1"
                    aria-controls="collapseOne1"
                    aria-expanded="false"
                    onclick="rotateIcon(this.querySelector('.toggle-icon'))">
                    <span>How do the credits work?</span>
                    <span class="toggle-icon">+</span>
                </div>
            </h5>
            <div id="collapseOne1" class="accordion-collapse collapse"
                aria-labelledby="headingOne1"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>Credits are used to generate images...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2 -->
    <div class="faq-content">
        <div style="border-bottom: 1px solid var(--items-border-colur)">
            <h5 class="accordion-header" id="headingTwo1">
                <div class="d-flex justify-content-between align-items-center px-3 py-2"
                    style="color: var(--dimtext); cursor: pointer; padding-bottom: 2rem !important"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo1"
                    aria-controls="collapseTwo1"
                    aria-expanded="false"
                    onclick="rotateIcon(this.querySelector('.toggle-icon'))">
                    <span>Can I use created images commercially?</span>
                    <span class="toggle-icon">+</span>
                </div>
            </h5>
            <div id="collapseTwo1" class="accordion-collapse collapse"
                aria-labelledby="headingTwo1"
                data-bs-parent="#faqAccordion">
                <p class="accordion-body">Yes, you can use generated images commercially...</p>
            </div>
        </div>
    </div>

    <!-- Tab 3 -->
    <div class="faq-content">
        <div style="border-bottom: 1px solid var(--items-border-colur)">
            <h5 class="accordion-header" id="headingThree1">
                <div class="d-flex justify-content-between align-items-center px-3 py-2"
                    style="color: var(--dimtext); cursor: pointer; padding-bottom: 2rem !important"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseThree1"
                    aria-controls="collapseThree1"
                    aria-expanded="false"
                    onclick="rotateIcon(this.querySelector('.toggle-icon'))">
                    <span>How much does it cost?</span>
                    <span class="toggle-icon">+</span>
                </div>
            </h5>
            <div id="collapseThree1" class="accordion-collapse collapse"
                aria-labelledby="headingThree1"
                data-bs-parent="#faqAccordion">
                <p class="accordion-body">Pricing depends on the selected plan...</p>
            </div>
        </div>
    </div>

</div>

    </div>
    </section>
@endsection

@section('js')
<script>
    document.querySelectorAll('.accordion-collapse').forEach(item => {
        item.addEventListener('show.bs.collapse', function () {
            this.closest('.faq-content').classList.add('active');
            this.closest('.faq-content').querySelector('.toggle-icon').textContent = '+';
        });
        item.addEventListener('hide.bs.collapse', function () {
            this.closest('.faq-content').classList.remove('active');
            this.closest('.faq-content').querySelector('.toggle-icon').textContent = '-';
        });
    });
</script>

@endsection

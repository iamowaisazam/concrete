@include('partials.head')
<style>
   /* Sticky Menu Blur */
   .main-menu {
   backdrop-filter: blur(20px);
   }
   @media (max-width: 1024px) {
   .main-menu {
   overflow: visible;
   backdrop-filter: none;
   background-color: rgba(0, 4, 17, 0.95);
   }
   }
</style>
<style>
   .blur {
   backdrop-filter: blur(20px);
   }
</style>
<div class="elementor-element elementor-element-c649ea3 e-flex e-con-boxed e-con e-parent e-lazyloaded" data-id="c649ea3" data-element_type="container">
   <div class="e-con-inner">
      <div class="elementor-element elementor-element-0cec2c2 e-con-full e-flex e-con e-child" data-id="0cec2c2" data-element_type="container">
         <div class="elementor-element elementor-element-360d786 elementor-widget elementor-widget-heading" data-id="360d786" data-element_type="widget" data-widget_type="heading.default">
            <div class="elementor-widget-container">
               <h1 class="elementor-heading-title elementor-size-default">Service Price Plan</h1>
            </div>
         </div>
         <div class="elementor-element elementor-element-93cfdb6 elementor-widget elementor-widget-heading" data-id="93cfdb6" data-element_type="widget" data-widget_type="heading.default">
            <div class="elementor-widget-container">
               <p class="elementor-heading-title elementor-size-default">Choose a pricing plan that works for you</p>
            </div>
         </div>
      </div>
      <div class="elementor-element elementor-element-8d3b82b e-con-full e-grid e-con e-child" data-id="8d3b82b" data-element_type="container">











      @forelse($plans as $plan)

        @php
        $mod = $loop->iteration % 3;
       @endphp


      @if($mod == 1)
      <div class="elementor-element elementor-element-4ba7581 e-con-full blur e-flex e-con e-child" data-id="4ba7581" data-element_type="container">
            <div class="elementor-element elementor-element-e05dda4 e-con-full e-flex e-con e-child" data-id="e05dda4" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
               <div class="elementor-element elementor-element-9cd3290 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="9cd3290" data-element_type="widget" data-widget_type="icon-list.default">
                  <div class="elementor-widget-container">
                     <ul class="elementor-icon-list-items">
                        <li class="elementor-icon-list-item">
                           <span class="elementor-icon-list-text">{{ $plan->plan_name }}</span>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="elementor-element elementor-element-c2c3a87 elementor-widget elementor-widget-elementskit-heading" data-id="c2c3a87" data-element_type="widget" data-widget_type="elementskit-heading.default">
                  <div class="elementor-widget-container">
                     <div class="ekit-wid-con">
                        <div class="ekit-heading elementskit-section-title-wraper text_left   ekit_heading_tablet-   ekit_heading_mobile-">
                           <span class="ekit-heading--title elementskit-section-title "><span><span>£{{ number_format($plan->price, 0) }}</span></span>/{{ ucfirst($plan->duration_unit) }}</span>				
                           <div class="ekit-heading__description">
                              <p>{{ $plan->short_desc }}</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="elementor-element elementor-element-e4140ba elementor-align-justify elementor-widget elementor-widget-button" data-id="e4140ba" data-element_type="widget" data-widget_type="button.default">
                  <div class="elementor-widget-container">
                     <div class="elementor-button-wrapper">
                        <a class="elementor-button elementor-button-link elementor-size-sm" href="{{ url('/register/'.$plan->id) }}">
                        <span class="elementor-button-content-wrapper">
                        <span class="elementor-button-text">Subscribe Now</span>
                        </span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="elementor-element elementor-element-b715304 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="b715304" data-element_type="widget" data-widget_type="divider.default">
               <div class="elementor-widget-container">
                  <div class="elementor-divider">
                     <span class="elementor-divider-separator">
                     </span>
                  </div>
               </div>
            </div>
            <div class="elementor-element elementor-element-e34c1d1 e-con-full e-flex e-con e-child" data-id="e34c1d1" data-element_type="container">
               <div class="elementor-element elementor-element-f372b80 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="f372b80" data-element_type="widget" data-widget_type="icon-list.default">
                  <div class="elementor-widget-container">
                     <ul class="elementor-icon-list-items">
                         @foreach(explode("\n", $plan->description) as $item)
                           @if(trim($item) != '')
                           <li class="elementor-icon-list-item">
                                 <span class="elementor-icon-list-icon">
                                    <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                                    </svg>
                                 </span>
                                 <span class="elementor-icon-list-text">{{ trim($item) }}</span>
                           </li>
                           @endif
                        @endforeach
                     </ul>
                  </div>
               </div>
            </div>
         </div>





























@elseif($mod == 2)

         <div class="elementor-element elementor-element-edcaaea e-con-full blur e-flex e-con e-child" data-id="edcaaea" data-element_type="container">
            <div class="elementor-element elementor-element-837ec9e e-con-full e-flex e-con e-child" data-id="837ec9e" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
               <div class="elementor-element elementor-element-7ea6c7d e-con-full e-flex e-con e-child" data-id="7ea6c7d" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;position&quot;:&quot;absolute&quot;}">
                  <div class="elementor-element elementor-element-b9fe270 elementor-align-center elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="b9fe270" data-element_type="widget" data-widget_type="icon-list.default">
                     <div class="elementor-widget-container">
                        <ul class="elementor-icon-list-items">
                           <li class="elementor-icon-list-item">
                              <span class="elementor-icon-list-text">Popular</span>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="elementor-element elementor-element-5caf11d elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="5caf11d" data-element_type="widget" data-widget_type="icon-list.default">
                  <div class="elementor-widget-container">
                     <ul class="elementor-icon-list-items">
                        <li class="elementor-icon-list-item">
                           <span class="elementor-icon-list-text">{{ $plan->plan_name }}</span>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="elementor-element elementor-element-c77e6a2 elementor-widget elementor-widget-elementskit-heading" data-id="c77e6a2" data-element_type="widget" data-widget_type="elementskit-heading.default">
                  <div class="elementor-widget-container">
                     <div class="ekit-wid-con">
                        <div class="ekit-heading elementskit-section-title-wraper text_left   ekit_heading_tablet-   ekit_heading_mobile-">
                           <span class="ekit-heading--title elementskit-section-title "><span><span>£{{ number_format($plan->price, 0) }}</span></span>/{{ ucfirst($plan->duration_unit) }}</span>				
                           <div class="ekit-heading__description">
                              <p>{{ $plan->short_desc }}</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="elementor-element elementor-element-ded32a6 elementor-align-justify elementor-widget elementor-widget-button" data-id="ded32a6" data-element_type="widget" data-widget_type="button.default">
                  <div class="elementor-widget-container">
                     <div class="elementor-button-wrapper">
                        <a class="elementor-button elementor-button-link elementor-size-sm" href="{{ url('/register/'.$plan->id) }}">
                        <span class="elementor-button-content-wrapper">
                        <span class="elementor-button-text">Subscribe Now</span>
                        </span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="elementor-element elementor-element-3ea3e3c elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="3ea3e3c" data-element_type="widget" data-widget_type="divider.default">
               <div class="elementor-widget-container">
                  <div class="elementor-divider">
                     <span class="elementor-divider-separator">
                     </span>
                  </div>
               </div>
            </div>
            <div class="elementor-element elementor-element-a4ae726 e-con-full e-flex e-con e-child" data-id="a4ae726" data-element_type="container">
               <div class="elementor-element elementor-element-62da76c elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="62da76c" data-element_type="widget" data-widget_type="icon-list.default">
                  <div class="elementor-widget-container">
                     <ul class="elementor-icon-list-items">
                         @foreach(explode("\n", $plan->description) as $item)
        @if(trim($item) != '')
        <li class="elementor-icon-list-item">
            <span class="elementor-icon-list-icon">
                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                </svg>
            </span>
            <span class="elementor-icon-list-text">{{ trim($item) }}</span>
        </li>
        @endif
    @endforeach
                     </ul>
                  </div>
               </div>
            </div>
         </div>
@else
         <div class="elementor-element elementor-element-c4ef486 e-con-full blur e-flex e-con e-child" data-id="c4ef486" data-element_type="container">
            <div class="elementor-element elementor-element-df6b1c3 e-con-full e-flex e-con e-child" data-id="df6b1c3" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
               <div class="elementor-element elementor-element-641e93f elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="641e93f" data-element_type="widget" data-widget_type="icon-list.default">
                  <div class="elementor-widget-container">
                     <ul class="elementor-icon-list-items">
                        <li class="elementor-icon-list-item">
                           <span class="elementor-icon-list-text">{{ $plan->plan_name }}</span>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="elementor-element elementor-element-a0ec310 elementor-widget elementor-widget-elementskit-heading" data-id="a0ec310" data-element_type="widget" data-widget_type="elementskit-heading.default">
                  <div class="elementor-widget-container">
                     <div class="ekit-wid-con">
                        <div class="ekit-heading elementskit-section-title-wraper text_left   ekit_heading_tablet-   ekit_heading_mobile-">
                           <span class="ekit-heading--title elementskit-section-title "><span><span>£{{ number_format($plan->price, 0) }}</span></span>/{{ ucfirst($plan->duration_unit) }}</span>				
                           <div class="ekit-heading__description">
                              <p>{{ $plan->short_desc }}</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="elementor-element elementor-element-46e2238 elementor-align-justify elementor-widget elementor-widget-button" data-id="46e2238" data-element_type="widget" data-widget_type="button.default">
                  <div class="elementor-widget-container">
                     <div class="elementor-button-wrapper">
                        <a class="elementor-button elementor-button-link elementor-size-sm" href="{{ url('/register/'.$plan->id) }}">
                        <span class="elementor-button-content-wrapper">
                        <span class="elementor-button-text">Subscribe Now</span>
                        </span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="elementor-element elementor-element-290b431 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="290b431" data-element_type="widget" data-widget_type="divider.default">
               <div class="elementor-widget-container">
                  <div class="elementor-divider">
                     <span class="elementor-divider-separator">
                     </span>
                  </div>
               </div>
            </div>
            <div class="elementor-element elementor-element-aba427e e-con-full e-flex e-con e-child" data-id="aba427e" data-element_type="container">
               <div class="elementor-element elementor-element-a62d956 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="a62d956" data-element_type="widget" data-widget_type="icon-list.default">
                  <div class="elementor-widget-container">
                     <ul class="elementor-icon-list-items">
                         @foreach(explode("\n", $plan->description) as $item)
        @if(trim($item) != '')
        <li class="elementor-icon-list-item">
            <span class="elementor-icon-list-icon">
                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                </svg>
            </span>
            <span class="elementor-icon-list-text">{{ trim($item) }}</span>
        </li>
        @endif
    @endforeach
                     </ul>
                  </div>
               </div>
            </div>
         </div>
		 


    @endif
@empty
    <p>No plans available.</p>
@endforelse







		 
      </div>
   </div>
</div>
@include('partials.foot')
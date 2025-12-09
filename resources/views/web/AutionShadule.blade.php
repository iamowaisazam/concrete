@extends('web.partial.layout')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
 <style>
        .autionshadular {
        position: relative;
        width: 100%;
        background-image: url("./assets/Dots.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow-x: hidden;
        }


        .tabs-container {
            background-color: #1e293b;
            border-radius: 8px;
            padding: 4px;
        }
        
        .custom-tab {
            background-color: #475569;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 0 2px;
            transition: all 0.2s ease;
            min-width: 120px;
            font-weight: 500;
        }
        
        .custom-tab:hover {
            background-color: #64748b;
            color: white;
        }
        
        .custom-tab.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .tab-content-area {
            border-radius: 8px;
            margin-top: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .tab-numbers {
            font-size: 12px;
            margin-top: 4px;
        }


        .table-dark-custom {
            background-color: #1a1f2e;
            border-color: #2d3748;
            margin-bottom: 0px;
        }
        
        .table-dark-custom th,
        .table-dark-custom td {
            border-color: #2d3748;
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table-dark-custom th {
            background-color: #1a1f2e;
            font-weight: 500;
            font-size: 1rem;
        }
        
        .platform-text {
            color: #3b82f6;
            font-weight: 500;
        }
        
        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
        }
        
        .status-in-progress {
            background-color: #dc2626;
            color: white;
            font-size: 10px;
        }
        
        .status-planned {
            background-color: #2563eb;
            color: white;
        }
        
        .status-cancel {
            background-color: #f59e0b;
            color: white;
        }
        
        .action-link {
            color: #9ca3af;
            text-decoration: none;
        }
        
        .action-link:hover {
            color: #ffffff;
        }
       .menucoustome-scrolbar {
  scrollbar-width: thin; /* For Firefox */
  scrollbar-color: #007bff rgba(255, 255, 255, 0.137); /* thumb | track for Firefox */
}




    </style>
@endsection

@section('content')

  <div class="autionshadular">
<div class="py-5">
    <h2 class="text-white mt-5 container">Auction Schedule</h2>


   
  <!-- Nav tabs -->
  <ul class="nav nav-tabs border-0 mt-4 container " id="customTabs">
    {{-- <li class="nav-item">
      <button class="nav-link active border-primary bg-transparent border-0 "  data-bs-toggle="tab" data-bs-target="#tab1">
        First Tab
      </button>
    </li> --}}
    {{-- <li class="nav-item">
      <button class="nav-link  bg-transparent border-0" data-bs-toggle="tab" data-bs-target="#tab2">
        Second Tab
      </button>
    </li> --}}
  </ul>

  <!-- Tab content -->
  <div class="tab-content my-4 ">
    <div class="tab-pane fade show active " id="tab1">
 <div class="d-flex gap-4 align-items-center text-white my-4 container">

      <!-- Platform Dropdown -->
        <div class="dropdown me-3">
            <span style="color: #ccc; font-weight: 500;">Platform:</span>
            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                style="color: #0d6efd; background: transparent; border: none; font-weight: 600; padding: 0;">
                Select Platform
            </button>
                <ul class="dropdown-menu menucoustome-scrolbar" style="background-color: #1a2533; max-height: 200px; overflow-y: auto;">
                    @foreach ($platforms as $platform)
                        <li>
                            <a class="dropdown-item text-white platform-option" href="#" data-id="{{ $platform->id }}">
                                {{ $platform->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
        </div>

        <!-- Center Dropdown -->
        <div class="dropdown">
            <span style="color: #ccc; font-weight: 500;">Center:</span>
            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                style="color: #0d6efd; background: transparent; border: none; font-weight: 600; padding: 0;">
                Select Center
            </button>
            <ul class="dropdown-menu menucoustome-scrolbar" style="background-color: #1a2533; max-height: 200px; overflow-y: auto;">
                @foreach ($centers as $center)
                    <li>
                        <a class="dropdown-item text-white center-option" href="#" data-id="{{ $center->id }}">
                            {{ $center->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

  
    <div class="dropdown">
        <span style="color: #ccc; font-weight: 500;">Status:</span>
        <button class=" dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
          style="color: #0d6efd; background: transparent; border: none ; font-weight: 600; padding: 0;">
          Center
        </button>
        <ul class="dropdown-menu menucoustome-scrolbar" style="background-color: #1a2533;">
          <li><a class="dropdown-item text-white" href="#" data-id="all">All</a></li>
          <li><a class="dropdown-item text-white" href="#" data-id="in_Progress"> In Progress </a></li>
        </ul>
      </div>

    </div>



    <!-- days tabs -->

    <div class="row ">
            <div class=" ">
                <!-- Tabs Navigation -->
                <div class="tabs-container d-flex flex-wrap gap-1 container">
                        @foreach ($days as $index => $day)
                            <button 
                                class="custom-tab flex-fill {{ $index === 0 ? 'active' : '' }}" 
                                data-date="{{ $day['date'] }}"
                                style="display: flex; flex-direction: column; align-items: center;"
                            >
                                <span>{{ $day['label'] }}</span>
                                <div class="tab-numbers d-flex justify-content-between w-100">
                                    <span>{{ $day['display'] }}</span>
                                    <span>{{ $day['count'] }}</span>
                                </div>
                            </button>
                        @endforeach
                    </div>


                
                <!-- Tab Content -->
                <div class="tab-content-area">
                    <div id="daytab1" class="day-tab-pane active" >
                       <div style="background-color: #1a2533; padding: 40px 0px; ">

                        <div class="container" >
                                <div class="table-responsive" style="border-radius: 10px !important;  border: 1px solid var(--items-border-colur);">
                                    <table id="auctionTable" class="table table-dark-custom text-white" style="background-color: var(--background-color) !important; " >
                                        <thead >
                                            <tr style="background-color: var(--background-color) !important; ">
                                                <th scope="col" style="background-color: var(--background-color) !important; border-bottom: 1px solid var(--items-border-colur);">Platform</th>
                                                <th scope="col" style="background-color: var(--background-color) !important; border-bottom: 1px solid var(--items-border-colur);">Center</th>
                                                <th scope="col" style="background-color: var(--background-color) !important; border-bottom: 1px solid var(--items-border-colur);">Vehicles</th>
                                                <th scope="col" style="background-color: var(--background-color) !important; border-bottom: 1px solid var(--items-border-colur);">Time</th>
                                                <th scope="col" style="background-color: var(--background-color) !important; border-bottom: 1px solid var(--items-border-colur);">Status</th>
                                                <th scope="col" style="background-color: var(--background-color) !important; border-bottom: 1px solid var(--items-border-colur);">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>





    {{-- <div class="tab-pane fade" id="tab2">
      <h4>Second Tab Content</h4>
    </div> --}}
  </div>




</div>
     </div>


       
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function () {
    let selectedPlatform = '';
    let selectedCenter = '';
    let selectedStatus = '';
  let selectedDate = '{{ \Carbon\Carbon::today()->format("Y-m-d") }}'; 
    function loadAuctions() {
        $.ajax({
            url: '{{ url('autionshadule') }}',
            method: 'GET',
            data: {
                platform_id: selectedPlatform,
                center_id: selectedCenter,
                status: selectedStatus,
                date: selectedDate
            },
            dataType: 'json',
            success: function (response) {
                let tbody = $('#auctionTable tbody');
                tbody.empty();

                $.each(response.data, function (index, item) {
                    let row = `
                        <tr>
                            <td>${item.platform}</td>
                            <td>${item.center}</td>
                            <td>${item.total_vehicles}</td>
                            <td>${item.time}</td>
                            <td>${item.status}</td>
                            <td>${item.action}</td>
                        </tr>`;
                    tbody.append(row);
                });
            },
            error: function (xhr) {
                console.error("Failed to load data:", xhr);
            }
        });
    }

    $('.platform-option').click(function (e) {
        e.preventDefault();
        selectedPlatform = $(this).data('id');
        $(this).closest('.dropdown').find('button').text($(this).text());
        loadAuctions();
    });

    $('.center-option').click(function (e) {
        e.preventDefault();
        selectedCenter = $(this).data('id');
        $(this).closest('.dropdown').find('button').text($(this).text());
        loadAuctions();
    });

    $('.dropdown-menu a[data-id]').click(function (e) {
        if ($(this).closest('.dropdown').find('span').text() === "Status:") {
            e.preventDefault();
            selectedStatus = $(this).data('id');
            $(this).closest('.dropdown').find('button').text($(this).text());
            loadAuctions();
        }
    });

        $('.custom-tab').click(function () {
            $('.custom-tab').removeClass('active');
            $(this).addClass('active');

            selectedDate = $(this).data('date'); 
            loadAuctions(); 
        });

    loadAuctions();
});

</script>






@endsection




@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('/css/activity-log.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('components.notifikasi-action')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Activity Log</a></li>
    <li class="breadcrumb-item active" aria-current="page">History</li>
  </ol>
</nav>

<body>
    <div class="container">
        {{-- <h1>Activity Log</h1> --}}
        <table id="activityTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h4>Log Details</h4>
        <p id="popupUser"></p>
        <p id="popupAction"></p>
        <p id="popupTimestamp"></p>
        <button class="close-btn" onclick="closePopup()">Close</button>
    </div>

</body>
</html>


@endsection 

@push('custom-scripts')
  <script src="{{ asset('assets/js/activity-log.js') }}"></script>
@endpush
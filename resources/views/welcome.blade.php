@extends('layout')
@section('content')
    <div class="container">
        <button id="GetDataBtn" type="button" class="btn btn-primary btn-lg">Get Data</button>
    </div>
@endsection

@push('js')
    <script>
        $('#GetDataBtn').click(function() {
            $.ajax({
                url: "{{ route('GetData') }}",
                method: 'GET',
                success: function() {
                    window.location.href = '/Data';
                },
                error: function(error) {
                    console.error(error);
                }

            });
        })
    </script>
@endpush

@push('css')
    <style>
        .container {
            text-align: center;
        }
    </style>
@endpush

@extends('layout')

@section('content')

    <head>
        <title>HydePark</title>
    </head>
    <h1 class="title">HydePark Employees Table</h1>
    <div class="table-data">
        <div class="input_container">
            <input class="form-control" type="month" id="date" name="date">
        </div>

        <br>
        <table id="table" class="table">
            <thead class="thead-dark">

                <tr>
                    <th scope="col">name</th>
                    <th scope="col">person_number</th>
                    <th scope="col">HIRE_DATE</th>
                    <th scope="col">TerminationDate</th>
                    <th scope="col">Count</th>
                    <th scope="col">assignment_name</th>
                    <th scope="col">assignment_status</th>
                    <th scope="col">assignment_start_effective_date</th>
                    <th scope="col">assignment_end_effective_date</th>
                    <th scope="col">payroll_name</th>
                    <th scope="col">payroll_start_effective_date</th>
                    <th scope="col">payroll_end_effective_date</th>
                </tr>
            </thead>
        </table>
        <button id="downloadDataBtn" class="btn btn-primary">Download All Data</button>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $('#date').on('change', function() {
                $('#table').DataTable().ajax.reload();

            });

            $('#table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('Employeesdatatable') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.date = $('#date').val();
                    }
                },
                columns: [{
                        name: "name",
                        orderable: true
                    },
                    {
                        name: "person_number",
                        orderable: true
                    },
                    {
                        name: "HIRE_DATE",
                        orderable: true
                    },
                    {
                        name: "TerminationDate",
                        orderable: true
                    },
                    {
                        name: "Count",
                        orderable: true
                    },
                    {
                        name: "assignment_name",
                        orderable: true
                    },
                    {
                        name: "assignment_status",
                        orderable: true
                    },
                    {
                        name: "assignment_start_effective_date",
                        orderable: true
                    },
                    {
                        name: "assignment_end_effective_date",
                        orderable: true
                    },
                    {
                        name: "payroll_name",
                        orderable: true
                    },
                    {
                        name: "payroll_start_effective_date",
                        orderable: true
                    },
                    {
                        name: "payroll_end_effective_date",
                        orderable: true
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                iDisplayLength: 10,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10', '25', '50', '100', 'All']
                ],
                dom: 'Blfrtip',
                buttons: ['colvis', 'excel', 'csv', 'print', 'copy', 'pdf'],
                autoFill: true
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .input_container {
            background: #3498db;
            padding: 30px
        }

        .input_container input {
            height: 50px;
            background: #ecf0f1;
        }

        .title {
            text-align: center;
            color: blue;
        }

        .table-data {
            margin: 20px;
        }

        #table thead th {
            background-color: #3498db;
            color: #fff;
        }

        #table tbody tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        #table tbody tr:nth-child(odd) {
            background-color: #fff;
        }
    </style>
@endpush

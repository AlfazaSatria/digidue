<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jadwal Hari Ini</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @include('includes.script')
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
          <h4>Digidue</h4>
        </div>
       
        <div class="card-body">
          <div class="table-responsive">
            <table id="table-schedule" class="table table-striped table-bordered" style="width:100%">
            </table>
        
      </div>
      
      <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
        $(function() {
            var oTable = $('#table-schedule').DataTable({
              "columnDefs": [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{url()->current()}}'
                },
                columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, title: 'No'},
                {data: 'month.name', name: 'month.name', title: 'Bulan'},
                {data: 'year', name: 'year', title: 'Tahun'},
                {data: 'location.name', name: 'location.name', title: 'Lokasi'},
                {data: 'desc_job', name: 'desc_job', title: 'Uraian Pekerjaan'},
                {data: 'voltage', name: 'voltage', title: 'Tegangan'},
                {data: 'equipment_out.name', name: 'equipment_out.name', title: 'Peralatan Padam'},
                {data: 'attribute', name: 'attribute', title: 'Sifat'},
                {data: 'person_responsibles', name: 'person_responsibles', title: 'Penanggung Jawab Pelaksanaan'},
                {data: 'start_date', name: 'start_date', title: 'Awal'},
                {data: 'end_date', name: 'end_date', title: 'Akhir'},
                {data: 'start_hours', name: 'start_hours', title: 'Jam Awal'},
                {data: 'end_hours', name: 'end_hours', title: 'Jam Akhir'},
                {data: 'operation_plan', name: 'operation_plan', title: 'Rencana Operasi'},
                {data: 'note', name: 'note', title: 'Keterangan'},
                {data: 'notif', name: 'notif', title: 'Notif'},
            ],
            });
        });
      
      </script>
</body>

</html>
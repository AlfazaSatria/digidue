@extends('layouts.app')
@section('title', 'Jadwal')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>Daftar Jadwal </h4>
       
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-schedule" class="table table-striped table-bordered" style="width:100%">
            </table>
        </div>
    </div>
    <div class="card-footer bg-whitesmoke">
        Digidue
    </div>
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
            {data: 'approve', name: 'approve', title: 'Status'},
           
            {data: 'action', name: 'action', title: 'Aksi'},
        ],
        });
    });

    $(document).on('click', '#changestatus', function(){
      swal({
              title: 'Update',
              text: 'Anda yakin ingin approve jadwal ini?',
              icon: 'warning',
              buttons: true,
            })
            .then((willProccess) => {
              if(willProccess){
                let id = $(this).data("id");
                $.ajax(
                {
                    url: `/schedule/approve/revision/${id}`,
                    type: 'POST',
                    data: {
                        id
                    },
                    success: function (response)
                    {
                        swal("Success", "Data Anda Telah Dirubah", "success");
                        oTable.ajax.reload(null,false);
                    },
                    error: function(xhr) {
                        $("#save-data").removeClass("disabled btn-progress");
                    swal("Oops!", "Error Update Data!", "error");
                    }
                });
              };
      });        
    });

    $(document).on('click', '#changeapprove', function(){
      swal({
              title: 'Update',
              text: 'Anda yakin ingin menolak jadwal ini?',
              icon: 'warning',
              buttons: true,
            })
            .then((willProccess) => {
              if(willProccess){
                let id = $(this).data("id");
                $.ajax(
                {
                    url: `/schedule/decline/revision/${id}`,
                    type: 'POST',
                    data: {
                        id
                    },
                    success: function (response)
                    {
                        swal("Success", "Data Anda Telah Dirubah", "success");
                        oTable.ajax.reload(null,false);
                    },
                    error: function(xhr) {
                        $("#save-data").removeClass("disabled btn-progress");
                    swal("Oops!", "Error Update Data!", "error");
                    }
                });
              };
      });        
    });

    
</script>


@endsection
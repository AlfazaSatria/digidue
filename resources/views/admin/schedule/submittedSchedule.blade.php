@extends('layouts.app')
@section('title', 'Jadwal ULTG')
@section('content')



<div class="card">
    <div class="card-header">
        <h4>Revisi Jadwal</h4>
    </div>
    <div class="card-body">
        <form id="schedule-submitted">
            <input type="hidden" name="id" id="id" value="{{$schedule->id}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                        <label for="month_id">Bulan</label>
                        <select class="form-control select2" id="month_id" name="month_id"disabled>
                            <option value="{{ $month->id }}">{{$month->name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Tahun</label>
                        <input type="text" class="form-control" id="year" name="year"
          value="{{$schedule->year}}" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="location_id">Lokasi</label>
                        <select class="form-control select2" id="location_id" name="location_id"disabled>
                            <option value="{{ $location->id }}">{{$location->name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jenis Bay</label>
                        <select class="form-control select2" name="bay_type_id" id="bay_type_id" disabled>
                            <option value="{{ $bay_type->id }}">{{$bay_type->name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="form-group">
                        <label>Peralatan Padam</label>
                        <select class="form-control select2" name="equipment_out_id" id="equipment_out_id" disabled>
                            <option value="{{ $equipment_out->id }}">{{$equipment_out->name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="seller_id">Tegangan</label>
                        <select class="form-control select2" id="voltage" name="voltage" disabled>
                            <option value="{{ $schedule->voltage }}">{{$schedule->voltage}}</option>


                        </select>
                    </div>
                </div>
            </div>






            <div class="form-group">
                <label for="desc">Uraian Pekerjaan</label>
                <input type="text" class="form-control" id="desc_job" name="desc_job"
                value="{{$schedule->desc_job}}" readonly>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seller_id">Sifat</label>
                        <select class="form-control select2" id="attribute" name="attribute" disabled>
                            <option value="{{ $schedule->attribute }}">{{$schedule->attribute}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="person_responsible">Penanggung Jawab Pelaksanaan</label>
                        <select class="form-control select2" id="person_responsibles" name="person_responsibles" disabled>
                            <option value="{{ $schedule->person_responsibles }}">{{$schedule->person_responsibles}}</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operation_plan">Rencana Operasi </label>
                       
                        <input type="text" class="form-control" id="operation_plan" name="operation_plan" placeholder="Input ROB/ROM/ROH">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">

                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="text" class="form-control datepicker" name="start_date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="text" class="form-control datepicker" name="end_date">
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="form-group">
                        <label for="end_date">Pukul Mulai</label>
                        <input type="text" class="form-control timepicker" name="start_hours">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="end_date">Pukul Selesai</label>
                        <input type="text" class="form-control timepicker" name="end_hours">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="note">Keterangan</label>
                <input type="text" class="form-control" id="note" name="note"
          value="{{$schedule->note}}" readonly>
            </div>

            <div class="form-group">
                <label for="notif">Notif/WO</label>
                <input type="number" class="form-control" id="notif" name="notif"
          value="{{$schedule->notif}}" readonly>
            </div>


            <div class="form-group">
                <button class="btn btn-success" id="save-data">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
  
  
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#schedule-submitted').submit(function(e) {
    e.preventDefault();
    $("#save-data").addClass("btn disabled btn-success btn-progress");
    const id = $("#id").val();
    $.ajax({
      type: 'POST',
      url:`/schedule/submitted/${id}`,
      data:new FormData(this),
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,
      error: function(err){
        $("#save-data").removeClass("disabled btn-progress");
        swal("Oops!", "Error Input Data!", "error");
      },
      success: function(response){
        console.log(response.status)
        if(response.status == 200 || response.status == 201){
          swal("Success", "Pengajuan Berhasil diajukan!", "success");
          $("#save-data").removeClass("disabled btn-progress");
          $('#schedue-add')[0].reset();
          $(".select2").val("");
          $(".select2").trigger("change");
        } else {
          $("#save-data").removeClass("disabled btn-progress");
          swal("Oops!", "Error Input Data!", "error");
        }
      },
    })
  })
</script>
@endsection
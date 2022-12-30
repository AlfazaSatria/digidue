@extends('layouts.app')
@section('title', 'Jadwal')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>Tambah Jadwal</h4>
    </div>
    <div class="card-body">
        <form id="schedule-add">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                        <label for="month_id">Bulan</label>
                        <select class="form-control select2" id="month_id" name="month_id">
                            <option disabled selected>Pilih Bulan</option>
                            @foreach($months as $key => $month)
                            <option value="{{ $month->id }}">{{$month->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Tahun</label>
                        <input type="number" class="form-control" id="year" name="year" placeholder="Tahun">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="location_id">Lokasi</label>
                        <select class="form-control select2" id="location_id" name="location_id">
                            <option disabled selected>Pilih Lokasi</option>
                            @foreach($locations as $key => $location)
                            <option value="{{ $location->id }}">{{$location->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jenis Bay</label>
                        <select class="form-control select2" name="bay_type_id" id="bay_type_id" disabled>
                            <option value="" disabled selected>Pilih Jenis Bay</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="form-group">
                        <label>Peralatan Padam</label>
                        <select class="form-control select2" name="equipment_out_id" id="equipment_out_id" disabled>
                            <option value="" disabled selected>Pilih Peralatan Padam</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="seller_id">Tegangan</label>
                        <select class="form-control select2" id="voltage" name="voltage">
                            <option disabled selected>Pilih Tegangan</option>
                            <option value="500kV">500kV</option>
                            <option value="150kV">150kV</option>
                            <option value="70kV">70kV</option>
                            <option value="20kV">20kV</option>


                        </select>
                    </div>
                </div>
            </div>






            <div class="form-group">
                <label for="desc">Uraian Pekerjaan</label>
                <input type="text" class="form-control" id="desc_job" name="desc_job" placeholder="Uraian Pekerjaan">
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seller_id">Sifat</label>
                        <select class="form-control select2" id="attribute" name="attribute">
                            <option disabled selected>Pilih Sifat</option>
                            <option value="03">03</option>
                            <option value="05">05</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="person_responsible">Penanggung Jawab Pelaksanaan</label>
                        <select class="form-control select2" id="person_responsibles" name="person_responsibles">
                            <option disabled selected>Pilih Penanggung Jawab</option>
                            <option value="M.UPT">M.UPT</option>
                            <option value="M.UP2B/UIP2B">M.UP2B/UIP2B</option>
                            <option value="M. UP2D">M. UP2D</option>
                            <option value="PLN Proyek">PLN Proyek</option>
                            <option value="Pihak Luar">Pihak Luar</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operation_plan">Rencana Operasi </label>
                        <select class="form-control select2" id="operation_plan" name="operation_plan">
                            <option disabled selected>Pilih Rencana Operasi </option>
                            <option value="ROB">ROB</option>
                            <option value="ROM">ROM</option>
                            <option value="ROH">ROH</option>
                        </select>
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
                <input type="text" class="form-control" id="note" name="note" placeholder="Keterangan">
            </div>

            <div class="form-group">
                <label for="notif">Notif/WO</label>
                <input type="number" class="form-control" id="notif" name="notif" placeholder="Notif">
            </div>


            <div class="form-group">
                <button class="btn btn-success" id="save-data">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function()
  {
      $('select[name="location_id"]').on('change', function() {
        $('select[name="bay_type_id"]').removeAttr("disabled");
          var locationID = $(this).val();
          if(locationID) {
              $.ajax({
                  url: '/schedule/show/baytype/'+locationID,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {                      
                      $('select[name="bay_type_id"]').empty();
                      $('select[name="bay_type_id"]').append('<option value="" disabled selected>Pilih Jenis Bay</option>');
                      $.each(data, function(key, value) {
                          $('select[name="bay_type_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      });
                  }
              });
          }
          else{
              $('select[name="bay_type_id"]').empty();
          }
      });

      $('select[name="bay_type_id"]').on('change', function() {
        $('select[name="equipment_out_id"]').removeAttr("disabled");
          var baytypeID = $(this).val();
          if(baytypeID) {
              $.ajax({
                  url: '/schedule/show/equipmentout/'+baytypeID,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {                      
                      $('select[name="equipment_out_id"]').empty();
                      $('select[name="equipment_out_id"]').append('<option value="" disabled selected>Pilih Peralatan Padam</option>');
                      $.each(data, function(key, value) {
                          $('select[name="equipment_out_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      });
                  }
              });
          }else{
              $('select[name="equipment_out_id"]').empty();
          }
      });
  });
  
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#schedule-add').submit(function(e) {
    e.preventDefault();
    $("#save-data").addClass("btn disabled btn-success btn-progress");
    
    $.ajax({
      type: 'POST',
      url:"/schedule/add/ultg",
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
          swal("Success", "Data Anda Telah Disimpan!", "success");
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
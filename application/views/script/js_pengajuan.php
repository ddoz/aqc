<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<style>
    #mapRedaksi {
        width:100%;
        height:500px;
        }
    #mapBiro {
        width:100%;
        height:500px;
        }

        pre {
            min-width:300px;
            white-space: pre-wrap;     
            white-space: -moz-pre-wrap;
            white-space: -pre-wrap;    
            white-space: -o-pre-wrap;  
            word-wrap: break-word;     
        }

        .leaflet-popup-content-wrapper {
            min-width: 350px;
        }

</style>
<script>

$(document).ready(function() {

    $.getJSON('<?=base_url()?>assets/api-wilayah-indonesia/static/api/provinces.json',function(data){
        data.forEach(element => {
            var html = "<option value='"+element.id+"_"+element.name+"'>"+element.name+"</option>";
            $('#provinsi').append(html);
        });
    });

    $.getJSON('<?=base_url()?>assets/api-wilayah-indonesia/static/api/provinces.json',function(data){
        data.forEach(element => {
            var html = "<option value='"+element.id+"_"+element.name+"'>"+element.name+"</option>";
            $('#provinsi_redaksi').append(html);
        });
    });
});

$("#tipemedia_id").change(function(e) {
    var val = $(this).val();

    if(val==2 || val == 4) {
        $("#website").attr('required',true);
    }else {
        $("#website").attr('required',false);
    }
})

$('#provinsi').change(function() {
    $('#kota').empty();
    if($(this).val()!="") {
        var splitId = $(this).val().split("_");

        $.getJSON('<?=base_url()?>assets/api-wilayah-indonesia/static/api/regencies/'+splitId[0]+'.json',function(data){
            data.forEach(element => {
                var html = "<option value='"+element.name+"'>"+element.name+"</option>";
                $('#kota').append(html);
            });
        });
    }
})

$('#provinsi_redaksi').change(function() {
    $('#kota_redaksi').empty();
    if($(this).val()!="") {
        var splitId = $(this).val().split("_");

        $.getJSON('<?=base_url()?>assets/api-wilayah-indonesia/static/api/regencies/'+splitId[0]+'.json',function(data){
            data.forEach(element => {
                var html = "<option value='"+element.name+"'>"+element.name+"</option>";
                $('#kota_redaksi').append(html);
            });
        });
    }
})


var map = L.map('mapRedaksi').setView([-4.8083317, 104.5305877], 15);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var marker;
<?php if(@$proposal->latitude_redaksi!="") { ?>
marker = L.marker([<?=$proposal->latitude_redaksi?>, <?=$proposal->longitude_redaksi?>]).addTo(map);
<?php } ?>
map.on('click', function(e) {
  //var c = L.circle([e.latlng.lat,e.latlng.lng], {radius: 15}).addTo(map);
  if (marker!=null) {
      map.removeLayer(marker);
  }
  marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
  $("#latitude_redaksi").val(e.latlng.lat);
  $("#longitude_redaksi").val(e.latlng.lng);
  
});


var map2 = L.map('mapBiro').setView([-4.8083317, 104.5305877], 15);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map2);



var marker2;
<?php if(@$proposal->latitude!="") { ?>
marker2 = L.marker([<?=$proposal->latitude?>, <?=$proposal->longitude?>]).addTo(map2);
<?php } ?>
map2.on('click', function(e) {
  //var c = L.circle([e.latlng.lat,e.latlng.lng], {radius: 15}).addTo(map);
  if (marker2!=null) {
    map2.removeLayer(marker2);
  }
  marker2 = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map2);
  $("#latitude").val(e.latlng.lat);
  $("#longitude").val(e.latlng.lng);
  
});


</script>
<script>

$('.btnSetuju').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    // $('#modalKetSetuju').modal();
    // $('#plpersetujuanIdSetuju').val(id);

    var form = $('#formSetuju').serialize();
    $('#loader').show();
    $.ajax({
        url: '<?=base_url()?>datapersetujuan/setuju',
        type: 'POST',
        data: {id:id},
        success: function(res) {
            location.reload();
        },
        error: function(err) {
            $('#loader').hide();
            location.reload();
        }
    })
})

$('.btnTolak').click(function(e) {
    e.preventDefault();
    $('#modalKet').modal();
    var id = $(this).attr('data-id');
    $('#loader').show();
    $('#formTolak').submit(function(e) {
        var ket = $('#ketTolak').val();
        e.preventDefault();
        $.ajax({
            url: '<?=base_url()?>datapersetujuan/tolak',
            type: 'POST',
            data: {id:id,ket:ket},
            success: function(res) {
                $('#loader').hide();
                location.reload();
            },
            error: function(err) {
                $('#loader').hide();
                location.reload();
            }
        })
    })
    
})

$('.btnPending').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $('#loader').show();
    $.ajax({
        url: '<?=base_url()?>datapersetujuan/tunggu',
        type: 'POST',
        data: {id:id},
        success: function(res) {
            $('#loader').hide();
            location.reload();
        },
        error: function(err) {
            $('#loader').hide();
            location.reload();
        }
    })
});

$('.btnFilterBelum').click(function(e) {
    e.preventDefault();
    var status2 = $('#statusFilterBelum').val();
    if(status2=='0') {
        $('#formFilterBelum').show();
        $('#statusFilterBelum').val('1');
    }else {
        $('#formFilterBelum').hide();
        $('#statusFilterBelum').val('0');
    }
});

$('.btnFilterSetuju').click(function(e) {
    e.preventDefault();
    var status = $('#statusFilterSetuju').val();
    if(status=='0') {
        $('#formFilterSetuju').show();
        $('#statusFilterSetuju').val('1');
    }else {
        $('#formFilterSetuju').hide();
        $('#statusFilterSetuju').val('0');
    }
});

$(document).ready(function() {
    var status = $('#statusFilterBelum').val();
    var status2 = $('#statusFilterSetuju').val();
    if(status=='1') {
        $('#formFilterBelum').show();
    }else {
        $('#formFilterBelum').hide();
    }

    if(status2=='1') {
        $('#formFilterSetuju').show();
    }else {
        $('#formFilterSetuju').hide();
    }


    var t = $('#tablebelum').DataTable({
        initComplete: function() {
              var api = this.api();
              $('#datatable_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
            oLanguage: {
              sProcessing: "loading..."
          },
            responsive: true,
            processing: true,
            serverSide 		: true,
			ajax:{
				url 		: "<?php echo base_url();?>datapersetujuan/json_data_belum",
				type 		: "POST",
                data : {data:"<?=$_SERVER['QUERY_STRING']?>"}
			},
			columns 		:[
                {data: null, orderable:false, searchable:false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'action', orderable:false, searchable:false},
                {data: 'plmasterId', searchable:false},
                {data: 'namaDivisi', searchable:true},
                {data: 'subkategoriNama', searchable:true},
                {data: 'plmasterDeskripsi', searchable:true},
                {data: 'namaPengirim', searchable:true},
                {data: 'plpersetujuanCreatedAt', searchable:true},
                // {data: 'checkIsNow', searchable:true}
			],
            columnDefs: [
                    {
                    "render": function ( data, type, row ) {
                        // here you can convert data from base64 to hex and return it
                        // console.log(row);
                        if (row.checkIsNow=='false') {
                        //         $(row).hide();
                            return "-";
                        }else {
                            return data;
                        }
                    },
                    "targets": 1
                }
            ]
            // createdRow: function( row, data, type ) {
            //     if (data.checkIsNow=='false') {
            //         $(row).hide();
            //     }
            // },
            // rowCallback: function( row, data, index ) {
            //     if(data.checkIsNow=='false') {
            //         $(row).hide();
            //     }
            //     // if ( aScanCult.indexOf(data[1]) > -1 ) row.remove();
            // }
        });

        $('#tablesetuju').DataTable({
        initComplete: function() {
              var api = this.api();
              $('#datatable_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
            oLanguage: {
              sProcessing: "loading..."
          },
            responsive: true,
            processing: true,
            serverSide 		: true,
			ajax:{
				url 		: "<?php echo base_url();?>datapersetujuan/json_data_setuju",
				type 		: "POST",
                data : {data:"<?=$_SERVER['QUERY_STRING']?>"}
			},
			columns 		:[
                {data: null, orderable:false, searchable:false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'action', orderable:false, searchable:false},
                {data: 'plmasterId', searchable:false},
                {data: 'namaDivisi', searchable:true},
                {data: 'subkategoriNama', searchable:true},
                {data: 'plmasterDeskripsi', searchable:true},
                {data: 'namaPengirim', searchable:true},
                {data: 'plpersetujuanCreatedAt', searchable:true},
			],
        });

        $('#tabletidak').DataTable({
        initComplete: function() {
              var api = this.api();
              $('#datatable_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
            oLanguage: {
              sProcessing: "loading..."
          },
            responsive: true,
            processing: true,
            serverSide 		: true,
			ajax:{
				url 		: "<?php echo base_url();?>datapersetujuan/json_data_tidak",
				type 		: "POST",
                data : {data:"<?=$_SERVER['QUERY_STRING']?>"}
			},
			columns 		:[
                {data: null, orderable:false, searchable:false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'action', orderable:false, searchable:false},
                {data: 'plmasterId', searchable:true},
                {data: 'namaDivisi', searchable:true},
                {data: 'subkategoriNama', searchable:true},
                {data: 'plmasterDeskripsi', searchable:true},
                {data: 'namaPengirim', searchable:true},
                {data: 'plpersetujuanCreatedAt', searchable:true},
			],
        });

        $('#tabletunggu').DataTable({
        initComplete: function() {
              var api = this.api();
              $('#datatable_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
            oLanguage: {
              sProcessing: "loading..."
          },
            responsive: true,
            processing: true,
            serverSide 		: true,
			ajax:{
				url 		: "<?php echo base_url();?>datapersetujuan/json_data_tunggu",
				type 		: "POST",
                data : {data:"<?=$_SERVER['QUERY_STRING']?>"}
			},
			columns 		:[
                {data: null, orderable:false, searchable:false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'action', orderable:false, searchable:false},
                {data: 'plmasterId', searchable:true},
                {data: 'namaDivisi', searchable:true},
                {data: 'subkategoriNama', searchable:true},
                {data: 'plmasterDeskripsi', searchable:true},
                {data: 'namaPengirim', searchable:true},
                {data: 'plpersetujuanCreatedAt', searchable:true},
			],
        });
})

</script>
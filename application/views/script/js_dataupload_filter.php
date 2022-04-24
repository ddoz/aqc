<script>

$('.btnFilter').click(function(e) {
    e.preventDefault();
    var status = $('#statusFilter').val();
    if(status=='0') {
        $('#formFilter').show();
        $('#statusFilter').val('1');
    }else {
        $('#formFilter').hide();
        $('#statusFilter').val('0');
    }
});

$(document).ready(function() {
    $(".datepicker").datepicker({format:'yyyy-mm-dd'});
    var status = $('#statusFilter').val();
    if(status=='1') {
        $('#formFilter').show();
    }else {
        $('#formFilter').hide();
    }

    var t = $('#datatable').DataTable({
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
				url 		: "<?php echo base_url();?>dataupload/json_datauplaod_filter",
				type 		: "POST",
                data : {data:"<?=$_SERVER['QUERY_STRING']?>"}
			},
			columns 		:[
                {data: null, orderable:false, searchable:false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'plmasterId', searchable:true},
                {data: 'plmasterTanggal', searchable:true},
                {data: 'plmasterTujuan', searchable:true},
                {data: 'subkategoriNama', searchable:true},
                {data: 'plmasterDeskripsi', searchable:true},
                {data: 'status_persetujuan', searchable:true},
                {data: 'action', orderable:false, searchable:false},
			],
        });

})

</script>
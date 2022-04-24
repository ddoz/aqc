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
});


$('.btnIkhtisarRevisi').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $('#modalRevisiIkhtisar').modal();
    $('#masterIdIkhtisar').val(id);
})

$('.btnDetailRevisi').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $('#modalRevisiDetail').modal();
    $('#masterIdDetail').val(id);
})

</script>
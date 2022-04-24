<script>

$('.btnEdit').click(function() {

    var id = $(this).attr('data-id');
    var waktu_mulai = $(this).attr('data-waktu_mulai');
    var waktu_selesai = $(this).attr('data-waktu_selesai');
    var status = $(this).attr('data-status_jadwal');

    $("#myModal").modal('show');

    $("#id").val(id);
    $("#waktu_mulai").val(waktu_mulai);
    $("#waktu_selesai").val(waktu_selesai);
    $("#status_jadwal").val(status);
})

</script>
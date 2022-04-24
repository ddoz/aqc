<script>

$('.btnEdit').click(function() {

    var id = $(this).attr('data-id');
    var nilai = $(this).attr('data-nilai');
    var nama_penilaian = $(this).attr('data-nama_penilaian');
    var kriteria = $(this).attr('data-kriteria');

    $("#myModal").modal('show');

    $("#id").val(id);
    $("#kriteria_penilaian_id").val(kriteria);
    $("#nama_penilaian").val(nama_penilaian);
    $("#nilai").val(nilai);
})

$('.btnEditKriteria').click(function() {

var id = $(this).attr('data-id');
var nama_kriteria = $(this).attr('data-nama_kriteria');
var keterangan = $(this).attr('data-keterangan');

$("#myModal").modal('show');

$("#id").val(id);
$("#nama_kriteria").val(nama_kriteria);
$("#keterangan").val(keterangan);
})

</script>
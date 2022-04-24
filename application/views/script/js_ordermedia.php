<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<script>

    $(".modalpilih").click(function(){
        $("#modal").modal();
        $("#id_media").val($(this).attr("data-id"));
        $("#nama_media").val($(this).attr("data-media"));
    })
    $(document).ready(function() {
    $('#example').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                console.log(column.header());
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                    column.data().unique().sort().each( function ( d, j ) {
                        if(column.search() === '^'+d+'$'){
                            select.append( '<option value="'+d+'" selected="selected">'+d+'</option>' )
                        } else {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        }
                    } );
            } );
        }
    } );
} );
</script>
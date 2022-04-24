<script>

$('#plmasterTujuan').change(function(e) {
    e.preventDefault();
    var value = $(this).val();
    if(value=='') {
        $("#plmasterStatusArsipHtml").hide();
        $('#plmasterTagArsipHtml').hide();
        $('#plmasterPersetujuanUserHtml').hide();
        $('#plmasterTagArsip').removeAttr('required');
        $('#plmasterStatusArsip').removeAttr('required');
        $('#plmasterPersetujuanUser').removeAttr('required');
    }else if(value=='Arsip') {
        $('#plmasterIkhtisar').attr('required',false);
        $("#plmasterStatusArsipHtml").show();
        $('#plmasterStatusArsip').attr('required',true);
        $('#plmasterPersetujuanUserHtml').hide();
    }else if(value=='Persetujuan') {
        $('#plmasterIkhtisar').attr('required',true);
        $("#plmasterStatusArsipHtml").hide();
        $('#plmasterStatusArsip').removeAttr('required');
        $('#plmasterPersetujuanUser').removeAttr('required');
        $('#plmasterTagArsipHtml').hide();
        $('#plmasterPersetujuanUserHtml').show();
        $('#plmasterPersetujuanUser').attr('required',true);
    }else {
        $("#plmasterStatusArsipHtml").hide();
        $('#plmasterTagArsipHtml').hide();
        $('#plmasterTagArsip').removeAttr('required');
        $('#plmasterStatusArsip').removeAttr('required');
        $('#plmasterPersetujuanUser').removeAttr('required');
    }
});

$('#plmasterStatusArsip').change(function(e) {
    e.preventDefault();
    var value = $(this).val();
    if (value==''){
        $('#plmasterTagArsipHtml').hide();
        $('#plmasterTagArsip').removeAttr('required');
    }else if(value=="Tag"){
        $('#plmasterTagArsipHtml').show();
        $('#plmasterTagArsip').attr('required',true);
    }else{
        $('#plmasterTagArsipHtml').hide();
        $('#plmasterTagArsip').removeAttr('required'); 
    }
});

function removeRow(v) {
    $(v).closest('tr').remove();
}

$("#btnTambahFile").click(function(e) {
    e.preventDefault();
    $(this).closest('table').find('tr:last').prev().after('<tr class="warning">'+
                '<th>'+
                    '<input type="file" name="pldetailNamaFile[]" id="">'+
                '</th>'+
                '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeRow(this)">X</button></td>'+
            '</tr>');
});

$(document).ready(function() {
    $('.selectUser').select2();
    $('.selectUser').on("select2:select", function(evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });
});

$('.favArsip').click(function(e) {
    e.preventDefault();
    $('#modalArsip').modal();
})

$('.favArsipBtn').click(function(e) {
    e.preventDefault();
    $('#plmasterTagArsip').val(null).trigger('change');
    var user = $(this).attr('data-id');
    var users = user.split('.');
    var Values = new Array();
    $.each(users,function(a,b) {
        Values.push(b);
    })
    $('#plmasterTagArsip').val(['3','11']);
    $('#plmasterTagArsip').trigger('change');
})

$('#formUpload').submit(function() {
    $('#btnSimpanUpload').attr('readonly',true);
    return true;
})


</script>
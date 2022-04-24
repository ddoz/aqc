<script>

$(document).ready(function() {
    $('.selectUser').select2();
    $('.selectUser').on("select2:select", function(evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    })
})

</script>
$(document).ready( function () {
    $('#myTable').DataTable({
        "searching": false
    } );
} );

$(document).ready( function () {
    $('#users').DataTable()
} );

$(document).ready( function () {
    $('#confTab').DataTable()
} );

function updateTextInput(val) {
    document.getElementById('textInput').value=val;
}
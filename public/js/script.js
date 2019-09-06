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

$(document).ready( function () {
    $('#top').DataTable({
        "sorting": false,
        "paging": false,
        "searching": false
    } );
} );

function updateTextInput(val) {
    document.getElementById('textInput').value=val;
}


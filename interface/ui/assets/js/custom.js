




// $(document).ready(function() {
//     "use strict";
//     $("#user_table").DataTable({
//         language: {
//             paginate: {
//                 previous: "<i class='mdi mdi-chevron-left'>",
//                 next: "<i class='mdi mdi-chevron-right'>"
//             },
//             info: "Showing _START_ to _END_ of _TOTAL_",
//             lengthMenu: ''
//         },
//         pageLength: 5,
//         columns: [{
//             orderable: !1,
//             targets: 0,
//             render: function(e, l, a, o) {
//                 return "display" === l && (e = '<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>'), e
//             },
//             checkboxes: {
//                 selectRow: !0,
//                 selectAllRender: '<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>'
//             }
//         }, {
//             orderable: !0
//         }, {
//             orderable: !0
//         }, {
//             orderable: !0
//         }, {
//             orderable: !0
//         }, {
//             orderable: !0
//         }, {
//             orderable: !0
//         }, {
//             orderable: !1
//         }],
//         select: {
//             style: "multi"
//         },
//         order: [
//             [1, "asc"]
//         ],
//         drawCallback: function() {
//             $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $("#products-datatable_length label").addClass("form-label")
//         }
//     })
// });






$(document).ready(function(){
    $(".saveAsExcel").click(function(){
        var workbook = XLSX.utils.book_new();
        alert("User data exporting!")
        //var worksheet_data  =  [['hello','world']];
        //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);

       

        var worksheet_data  = document.getElementById("user_table");
        var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
        
        workbook.SheetNames.push("Test");
        workbook.Sheets["Test"] = worksheet;
      
         exportExcelFile(workbook);
      
     
    });
})

function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}


// start


$(document).ready(function() {

    $('.input-form-display').click(function() {

        $( ".form_append_submit").css("display", "block");

        var inputValue = $(this).attr("value");

var btnValue = $('.add_btn').attr("value");

        $("." + inputValue).toggle();

// if(inputValue === btnValue) { 

//         $( ".add_btn").css("display", "block")

// }


        alert("Checkbox " + inputValue + " is selected");
    });






$(' .add_btn').click(function() {

var inputValue = $(this).attr("value");

$("." + inputValue).clone(true).eq( 0 ).appendTo('#form_append_sec');





});








});
// end


//profile-pic
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});


// $('#add_row_btn').click(function() {


//     $( ".delete_row_btn").css("display", "block");

// })



//$( "#leftside-menu-container" ).load( "header.html #left_menu" );








$(document).ready(function(){
	$('.js-edit, .js-save').on('click', function(){
  	var $form = $(this).closest('form');
  	$form.toggleClass('is-readonly is-editing');
    var isReadonly  = $form.hasClass('is-readonly');
    $form.find('input,textarea').prop('disabled', isReadonly);
  });
});











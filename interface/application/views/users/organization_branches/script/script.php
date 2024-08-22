<script type="text/javascript">

$(document).ready(function() {
  assignValueToFilter();
  getdatas();
  ajax_modal('.addData','organization_branches/add','Create Branch','large',save_data);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ///var url = "organization_branches/getList";
    var module_name="organization_branches";
    ajax_filter(module_name, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
    ajax_modal('.editData','organization_branches/add','Edit Branch','large',save_data);
    ajax_modal('.viewDetails','organization_branches/view','View Branch Details','large','');
    delete_data('organization_branches','Organization Branch','name','');
  }else{
    show_toast('error',datas.message);
  }
  
}

function save_data(){
  get_country_select2();
  var formName='#myForm';
  var ajax_type='button';
  var ajax_text='Processing...';
  var url='organization_branches/save_data';
   $(formName).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules:{
          cities_id:{required:true},
          states_id:{required:true},
          countries_id:{required:true},
      },
      messages:{

      },
      submitHandler: function(){
        ajax_request(formName,url,ajax_type,ajax_text,render_save_data);
      }
  });
}


function render_save_data(returnData){
  if(returnData.status == "success"){
    $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
    show_toast('success',returnData.message);
    getdatas();
  }else{
    failureResult('#myForm',returnData.message,false);
  }
}



</script>
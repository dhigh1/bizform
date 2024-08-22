
// country, state & city select

function get_country_select2(){
  $(".select2_country").select2({
      dropdownParent: $('#userModalView'),
      placeholder: "--select--",
      allowClear: false,
      formatNoMatches:function(term){
          return '<div class="text-center">No countries found...</div>';
      }
    }).on('change',function(e){
      //console.log('changed');
      //e.preventDefault();
      var id=$(this).val();
      get_state_select2(id);
    }); 

    $(".select2_state").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select country first--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div class="text-center">No states found...</div>';
        }
    }).on('change',function(e){
      //console.log('changed');
      //e.preventDefault();
      var id=$(this).val();
      get_city_select2(id);
    });

    $(".select2_city").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select state first--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div class="text-center">No cities found...</div>';
        }
    });
}

function get_state_select2(id) {
    //console.log('id='+id);
    $("#state_select").select2("val", "");
    $("#s2id_state_select").find('.select2-chosen').html('<option>Loading states</option>');
    $.post(urljs+"utils/get_state_by_country",{'id':id},function(datas){
        //closeajax();
        if(datas.status=="success"){
          var tableitems='';
          var data = datas.data_list;
          if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              tableitems+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#s2id_state_select").find('.select2-chosen').html('--select state--');
            $("#state_select").html('');
            $("#state_select").append('<option></option>');
            $("#state_select").append(tableitems);
          }else{
            $("#s2id_state_select").find('.select2-chosen').html('<div class="text-center">No state found...</div>');
            $("#state_select").html('');
            $("#state_select").append('<option></option>');
          }
        }else{
            $("#s2id_state_select").find('.select2-chosen').html('<div class="text-center">No state found...</div>');
            $("#state_select").html('');
            $("#state_select").append('<option></option>');
        }    
    },"json");
}

function get_city_select2(id) {
  $("#city_select").select2("val", "");
  $("#s2id_city_select").find('.select2-chosen').html('<option>Loading cities</option>');
  $.post(urljs+"utils/get_city_by_state",{'id':id},function(datas){
    //closeajax();
    if(datas.status=="success"){
      var tableitems='';
      var data = datas.data_list;
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
          tableitems+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
        }
        $("#s2id_city_select").find('.select2-chosen').html('--select city--');
        $("#city_select").html('');
        $("#city_select").append('<option></option>');
        $("#city_select").append(tableitems);
      }else{
        $("#s2id_city_select").find('.select2-chosen').html('<div class="text-center">No city found...</div>');
        $("#city_select").html('');
        $("#city_select").append('<option></option>');
      }
    }else{
        $("#s2id_city_select").find('.select2-chosen').html('<div class="text-center">No city found...</div>');
        $("#city_select").html('');
        $("#city_select").append('<option></option>');
    }
    
    },"json");
}


// department & branch select


function get_dept_select2(){
    $(".select2_dept").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No departments found...</div>';
        }
    });
}

function get_org_branch_select2(){
  $(".select2_branch").select2({
      dropdownParent: $('#userModalView'),
      placeholder: "--select--",
      allowClear: false,
      formatNoMatches:function(term){
          return '<div>No branches found...</div>';
      }
    }).on('change',function(e){
        $("#s2id_dept_select").find('.select2-chosen').html('--select--');
        $("#dept_select").html('');
        $("#dept_select").append('<option></option>');
        var id=$(this).val();
        get_org_dept_select2(id);
    });

    $(".select2_dept").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No departments found...</div>';
        }
    });
}

function get_org_dept_select2(id) {
  $("#dept_select").select2("val", "");
  $("#s2id_dept_select").find('.select2-chosen').html('<option>Loading departments...</option>');
  $.post(urljs+"utils/get_depts_by_branch",{'id':id},function(datas){
    //closeajax();
    if(datas.status=="success"){
      if (datas.list_options!='') {
        $("#s2id_dept_select").find('.select2-chosen').html('--select--');
        $("#dept_select").html('');
        $("#dept_select").append('<option></option>');
        $("#dept_select").append(datas.list_options);
      }else{
        $("#s2id_dept_select").find('.select2-chosen').html('<div>No departments found...</div>');
        $("#dept_select").html('');
        $("#dept_select").append('<option></option>');
      }
    }else{
        $("#s2id_dept_select").find('.select2-chosen').html('<div>No departments found...</div>');
        $("#dept_select").html('');
        $("#dept_select").append('<option></option>');
    }
    
    },"json");
}

function get_user_role_select2(){
    $(".select2_branch").select2({
      dropdownParent: $('#userModalView'),
      placeholder: "--select--",
      allowClear: false,
      formatNoMatches:function(term){
          return '<div>No branches found...</div>';
      }
    }).on('change',function(e){
        $("#s2id_dept_select").find('.select2-chosen').html('--select--');
        $("#dept_select").html('');
        $("#dept_select").append('<option></option>');

        $("#s2id_role_select").find('.select2-chosen').html('--select--');
        $("#role_select").html('');
        $("#role_select").append('<option></option>');
        var id=$(this).val();
        get_org_dept_select2(id);
    });

    $(".select2_dept").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No departments found...</div>';
        }
    }).on('change',function(e){
        $("#s2id_role_select").find('.select2-chosen').html('--select--');
        $("#role_select").html('');
        $("#role_select").append('<option></option>');
        var id=$(this).val();
        get_role_select2(id);
    });

    $(".select2_role").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No roles found...</div>';
        }
    });
}


function get_role_select2(id) {
  $("#role_select").select2("val", "");
  $("#s2id_role_select").find('.select2-chosen').html('<option>Loading roles...</option>');
  $.post(urljs+"utils/get_roles_by_dept",{'id':id},function(datas){
    //closeajax();
    if(datas.status=="success"){
        var tableitems='';
        var data = datas.data_list;
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              tableitems+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#s2id_role_select").find('.select2-chosen').html('--select role--');
            $("#role_select").html('');
            $("#role_select").append('<option></option>');
            $("#role_select").append(tableitems);
        }else{
            $("#s2id_role_select").find('.select2-chosen').html('<div>No roles found...</div>');
            $("#role_select").html('');
            $("#role_select").append('<option></option>');
        }
    }else{
        $("#s2id_role_select").find('.select2-chosen').html('<div>No roles found...</div>');
        $("#role_select").html('');
        $("#role_select").append('<option></option>');
    }
    
    },"json");
}


function get_customer_select2(){
    $(".select2_customer").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No customers found...</div>';
        }
    }).on('change',function(e){
        $("#s2id_cbranch_select").find('.select2-chosen').html('--select--');
        $("#cbranch_select").html('');
        $("#cbranch_select").append('<option></option>');
        var id=$(this).val();
        get_customer_branch_select2(id);
    });
    $(".select2_cbranch").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select-",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No branches found...</div>';
        }
    }).on('change',function(e){

        if($('#cbranch_person_select').length>0){
            $("#s2id_cbranch_person_select").find('.select2-chosen').html('--select--');
            $("#cbranch_person_select").html('');
            $("#cbranch_person_select").append('<option></option>');
            var id=$(this).val();
            get_customer_branch_person_select2(id);
        }
    });

    if($('#cbranch_person_select').length>0){
       $(".select2_cbranch_person").select2({
            dropdownParent: $('#userModalView'),
            placeholder: "--select-",
            allowClear: false,
            formatNoMatches:function(term){
                return '<div>No contact persons found...</div>';
            }
        }); 
    }
}

function get_customer_branch_select2(id) {
  $("#cbranch_select").select2("val", "");
  $("#s2id_cbranch_select").find('.select2-chosen').html('<option>Loading branches...</option>');
  $.post(urljs+"utils/get_branches_by_customer",{'id':id},function(datas){
    //closeajax();
    if(datas.status=="success"){ 
        var tableitems='';
        var data = datas.data_list;
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              tableitems+='<option data-type="cbranch_select" value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#s2id_cbranch_select").find('.select2-chosen').html('--select--');
            $("#cbranch_select").html('');
            $("#cbranch_select").append('<option></option>');
            $("#cbranch_select").append(tableitems);
        }else{
            $("#s2id_cbranch_select").find('.select2-chosen').html('<div>No branches found...</div>');
            $("#cbranch_select").html('');
            $("#cbranch_select").append('<option></option>');
        }
    }else{
        $("#s2id_cbranch_select").find('.select2-chosen').html('<div>No branches found...</div>');
        $("#cbranch_select").html('');
        $("#cbranch_select").append('<option></option>');
    }
    
    },"json");
}


function get_customer_branch_person_select2(id) {
  $("#cbranch_person_select").select2("val", "");
  $("#s2id_cbranch_person_select").find('.select2-chosen').html('<option>Loading contact persons...</option>');
  $.post(urljs+"utils/get_contact_persons_by_branch",{'id':id},function(datas){
    //closeajax();
    if(datas.status=="success"){
        var tableitems='';
        var data = datas.data_list;
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              tableitems+='<option data-type="cbranch_person_select" value="'+data[i].id+'">'+data[i].name+', '+data[i].phone+'</option>';
            }
            $("#s2id_cbranch_person_select").find('.select2-chosen').html('--select--');
            $("#cbranch_person_select").html('');
            $("#cbranch_person_select").append('<option></option>');
            $("#cbranch_person_select").append(tableitems);
        }else{
            $("#s2id_cbranch_person_select").find('.select2-chosen').html('<div>No contact persons found...</div>');
            $("#cbranch_person_select").html('');
            $("#cbranch_person_select").append('<option></option>');
        }
    }else{
        $("#s2id_cbranch_person_select").find('.select2-chosen').html('<div>No contact persons found...</div>');
        $("#cbranch_person_select").html('');
        $("#cbranch_person_select").append('<option></option>');
    }
    
    },"json");
}




function get_service_executor_select2() {
    $(".select2_executor").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select-",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No executor found...</div>';
        }
    });

    $('.execution_type').on('change',function(){
        var execution_type=$(this).val();
        $("#executor_select").select2("val", "");
        $("#s2id_executor_select").find('.select2-chosen').html('<option>Loading executors...</option>');
        $.post(urljs+"utils/get_service_executors",{'execution_type':execution_type},function(datas){
        //closeajax();
        if(datas.status=="success"){
            var tableitems='';
            var data = datas.data_list;
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                  tableitems+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                $("#s2id_executor_select").find('.select2-chosen').html('--select--');
                $("#executor_select").html('');
                $("#executor_select").append('<option></option>');
                $("#executor_select").append(tableitems);
            }else{
                $("#s2id_executor_select").find('.select2-chosen').html('<div>No executor found...</div>');
                $("#executor_select").html('');
                $("#executor_select").append('<option></option>');
            }
        }else{
            $("#s2id_executor_select").find('.select2-chosen').html('<div>No executor found...</div>');
            $("#executor_select").html('');
            $("#executor_select").append('<option></option>');
        }
        
        },"json");
    });
}


function get_services_select2(){
    $(".select2_services").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No services found...</div>';
        }
    });   
}

function get_workorders_select2(){
    $(".select2_workorders").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No workorder found...</div>';
        }
    });   
}

function get_status_select2(){
    $(".select2_status").select2({
        dropdownParent: $('#userModalView'),
        placeholder: "--select--",
        allowClear: false,
        formatNoMatches:function(term){
            return '<div>No status found...</div>';
        }
    });   
}

function get_add_forms_select2(){
    $(".select2_add_forms").select2({
        dropdownParent: $("#userModalView"),
        placeholder: "--select--",
        allowClear: true,
        multiple: true,
        formatNoMatches: ()=>{
            return '<div>No status found...</div>';
        } 
    })
}

function get_form_categories_select2(){
    $(".select2_form_categories").select2({
        dropdownParent: $('#userModalView'),
        placeholder: '--Select Form Category--',
        allowClear: false,
        formatNoMatches: function(term){
            return `<div>No Form Category Found. <a href='${urljs}form_categories'>Create New ?</a></div>`;
        }
    });
}
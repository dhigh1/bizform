<div class="row mb-2">
    <!-- <div class="col-xs-12">
        
    </div> -->
    <div class="col-xs-12">
        <label class="mb-0">Move selections to the flow</label>
        <form id="check_status_form" class="d-flex align-items-end update-check-status">
            <?php $workflow=$this->curl->execute("workflow","GET",array('sortby'=>'workflow.orders','orderby'=>'ASC','perpage'=>'100')); ?>
            <div class="mr-10">
                
                <select class="form-select" name="check_status">
                    <option value="">--select--</option>
                    <?php 
                        if(!empty($workflow['data_list'])){
                            foreach($workflow['data_list'] as $row){
                    ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                    <?php } } ?>
                </select>
            </div>
            <div class="">
                <button type="button" class="btn btn-primary getCheckboxes"><i class="fa fa-check"></i> Update</button>
            </div>
        </form>
    </div>
</div>
<div class="row mb-3">
    <div class="col-xs-12" >
        <div id="gridPopup">
        </div> 
        <div class="box">
           <div class="clearfix"></div>
           <div >
                <table class="table-responsive" style="width:100%">
                    <tbody>
                        <tr>
                            <td>
                                <div id="grid_editing"></div>
                            </td>
                        </tr>
                    </tbody>

                </table>
           </div>
           <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
 </div>



 <script type="text/javascript">
    init_param_grid();
     
function init_param_grid() {
  var toolbar= {
    items: [
      {
        type:'button',
        label: 'Reset filters',
        cls:'btn btn-success',
        listener: function(){
          this.reset({filter: true});             
        }                        
      }
    ]
  };

  var colModel= [
    { 
        dataIndx: "state",
        align: "center",
        title: "<label><input type='checkbox' />&nbsp;Select All</label>",
        cb: { header: true, select: true, all: true },
        type: 'checkbox',
        cls: 'ui-state-default', 
        dataType: 'bool',
        editor: false,
        filter:false
    },
    { title: "Profile ID", dataType: "string", dataIndx: "workorders_profiles_code", editable: false, width: 80,
      filter: { 
        crules:[{condition: 'equal'}] 
      }
    },
    { title: "Check ID", dataType: "string", dataIndx: "check_code", editable: false, width: 80,
      filter: { type: 'textbox', condition: 'equal', listeners: ['change'] }
    },
    { title: "Ref ID", dataType: "string", dataIndx: "workorders_profiles_ref_id", editable: false, width: 10,
      filter: { type: 'textbox', condition: 'equal', listeners: ['change'] }
    },
    { title: "Profile Name", dataType: "string", dataIndx: "workorders_profiles_name", editable: false, width: 80,
      filter: { type: 'textbox', condition: 'begin', listeners: ['change'] }
    },
    { title: "Check Type", dataType: "string", dataIndx: "services_name", editable: false, width: 50,
      filter: { type: 'textbox', condition: 'equal', listeners: ['change'] }
    },
    { title: "Check Status", dataIndx: "status_name", width: 80, editable:false,
        filter: { type: 'textbox', condition: 'equal', listeners: ['change'] }
    },
    { title: "Created", dataType: "date", dataIndx: "created_at", format: "dd/mm/yy", editable: false, width: 50
    },
  ];

  var dataModel= {
      dataType: "JSON",
      location: "remote",
      paging: "remote",
      sorting: "remote",
      recIndx: "id",
      sortIndx: "id",
      sortDir: "down",
      colIndx:"id",
      url: urljs+data_module+"/get_grid_data?workorders_id="+getUrlParameter('id'),
      getData: function (response) {
          if(response.status=='success'){
            return {curPage: response.page_number, totalRecords: response.total_rows, data: response.datas }; 
          }else{
            swal(response.message);
          }
      }
  };

  var grid = $("#grid_editing").pqGrid({ 
    //width: 800, 
    //height: 550,
    menuIcon: true,
    height: 'flex',
    // pasteModel: { on: false },
    dataModel: dataModel,
    colModel: colModel,
    freezeCols: 1,
    //flex:{one: true},
    pageModel: { type: "remote", rPP: 20, strRpp: "{0}" },
    filterModel: { on: true, mode: "AND", header: false, type: 'remote' },
    sortable: true,
    selectionModel: { type: null },
    numberCell: { show:true,resizable: true, width: 30, title: "#" },
    //wrap: false, 
    // editable : true,
    hwrap: false,
    virtualX:true, 
    virtualY:true,
    resizable: true,     
    rowBorders: true,
    //trackModel: { on: true }, //to turn on the track changes.            
    scrollModel: {
        autoFit: true
    },           
    hoverMode: 'cell',
    swipeModel: { on: false },
    editor: {
        select: true
    },
    collapsible: {
      toggle: false
    },
    toolbar:toolbar,
    title: "<b>List of all checks</b>",       
    postRenderInterval: -1, //call postRender synchronously.
  });

    $('.getCheckboxes').on('click',function() {
        var boxes=grid.pqGrid("Checkbox", "state").getCheckedNodes().map(function(rd){
            return rd.id
        });
        //alert(boxes);

        var transition_id=$('#check_status_form [name=check_status]').val();
        if(boxes!=''){
            if(transition_id!=''){
                ajaxloading('Please wait</br>Processing...');
                formData={'check_ids':boxes,'transition_id':transition_id,'action_type':'status_update','workorders_id':getUrlParameter('id')};
                $.post(urljs+data_module+'/save_grid_data',formData,function(datas){
                    closeajax();
                    if(datas.status=='success'){
                        //grid.pqGrid("option", "dataModel.data", data);
                        //grid.pqGrid("refreshDataAndView" );
                        getdatas();
                        // swal(datas.message);
                        ajax_modal_report('',datas,'bulk-status-update');
                    }else{
                        //swal('Failed',datas.message,'error');
                        ajax_modal_report('Failed',datas,'bulk-status-update');
                    }
                },'json');
            }else{
                swal('Failed','Please select the status to update.','warning');
            }
        }else{
            swal('Failed','Please select the checks to update.','warning');
        }
    });  

}


 </script>
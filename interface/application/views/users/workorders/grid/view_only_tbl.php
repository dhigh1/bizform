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
    { title: "Profile ID", dataType: "string", dataIndx: "workorders_profiles_code", editable: false, width: 80,
      filter: { 
        crules:[{condition: 'equal'}] 
      }
    },
    { title: "Check Code", dataType: "string", dataIndx: "check_code", editable: false, width: 80,
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
    { title: "Check Status", dataIndx: "status_name", width: 80, editable:false},
    { title: "Created", dataType: "date", dataIndx: "created_at", format: "dd/mm/yy", editable: false, width: 50},


    <?php if($view_chk_prm || $edit_chk_prm || $delete_chk_prm){ ?>
    { title: "Actions", editable: false, minWidth: 83, sortable: false,
        render: function (ui) {
            var action_html="";
            <?php if($view_chk_prm || $edit_chk_prm || $delete_chk_prm){ ?>

            <?php if($view_chk_prm){ ?>
            action_html+= "<button type='button' title='View check details' class='grid-action-buttons btn btn-dark btn-sm viewProfileCheck'><i class='mdi mdi-eye'></i></button>";
            <?php } ?>

            <?php if($edit_chk_prm){ ?>
            action_html+="<button type='button' title='Edit check' class='grid-action-buttons btn btn-secondary btn-sm editProfileCheck'><i class='mdi mdi-pencil'></i></button>";
            <?php } ?>

            <?php if($delete_chk_prm){ ?>
            action_html+="<button type='button' title='Delete check' class='grid-action-buttons btn btn-danger btn-sm deleteProfileCheck'><i class='mdi mdi-delete'></i></button>";
            <?php } ?>


            <?php }else{ ?>
                action_html="---";
            <?php } ?>
            return action_html;
        },
        postRender: function (ui) {
            var rowIndx = ui.dataIndx,
                grid = this,
                $cell = grid.getCell(ui);
            $cell.find("button").attr('data-id',ui.rowData.id);

            var status=ui.rowData.status;
            if(status>=5){
                $cell.find("button.deleteProfileCheck").attr('disabled',true);
            }if(status>=6){
                $cell.find("button.editProfileCheck").attr('disabled',true);
            }
            get_grid_actions();

            //console.log(ui.rowData);

            //$cell.find("button").button({ icons: { primary: 'ui-icon-scissors'} })
            //.bind("click", function () {
              //  

                //grid.addClass({ rowIndx: ui.rowIndx, cls: 'pq-row-delete' });

                // var ans = window.confirm("Are you sure to delete row No " + (ui.dataIndx) + "?");
                // grid.removeClass({ rowIndx: rowIndx, cls: 'pq-row-delete' });
                // if (ans) {
                //     grid.deleteRow({ rowIndx: rowIndx });
                // }
            //});
        }
    },
    <?php }  ?>

    <?php if($report_chk_prm){ ?>
    { title: "Report", editable: false, minWidth: 83, sortable: false,
        render: function (ui) {
            var status=ui.rowData.status;
            var report_html='';
            <?php if($report_chk_prm){ ?>
            if(status>=8){
                report_html+= "<button type='button' title='Get Image' data-type='image' class='grid-action-buttons btn btn-info btn-sm getCheckImageReport'><i class='mdi mdi-file-image'></i></button>";
                report_html+="<button type='button' title='Get Docx' data-type='docx' class='grid-action-buttons btn btn-success btn-sm getCheckDocReport'><i class='mdi mdi-file-document'></i></button>";
            }else{
                report_html+='N/A';
            }
            <?php }else{ ?>
                report_html="---";
            <?php } ?>
            return report_html;
        },
        postRender: function (ui) {
            var rowIndx = ui.dataIndx,
                grid = this,
                $cell = grid.getCell(ui);
            $cell.find("button").attr('data-id',ui.rowData.id);
            $cell.find("button.getCheckImageReport").bind("click", function () {
                var btn=$(this);
                btn.attr('disabled',true);
                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                var formdata={'report_type':'image','id':ui.rowData.id};
                $.post(urljs+data_module+'/get_check_report',formdata,function(data) {

                    btn.removeAttr('disabled');
                    btn.html("<i class='mdi mdi-file-image'></i>");

                    if(data.status=='success' && data.report_url!=''){
                        window.open(data.report_url,'Download');
                    }else{
                        swal('Error',data.message,'error');
                    }
                },'json');
            });
            $cell.find("button.getCheckDocReport").bind("click", function () {

                var btn=$(this);
                btn.attr('disabled',true);
                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                var formdata={'report_type':'docx','id':ui.rowData.id};
                $.post(urljs+data_module+'/get_check_report',formdata,function(data) {

                    btn.removeAttr('disabled');
                    btn.html("<i class='mdi mdi-file-document'></i>")

                    if(data.status=='success' && data.report_url!=''){
                        window.open(data.report_url,'Download');
                    }else{
                        swal('Error',data.message,'error');
                    }
                },'json');
            });
        }
    }
    <?php }  ?>
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
      rowIndx:"id",
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
    dataModel: dataModel,
    colModel: colModel,
    //freezeCols: 2,
    //flex:{one: true},
    pageModel: { type: "remote", rPP: 10, strRpp: "{0}" },
    filterModel: { on: true, mode: "AND", header: false, type: 'remote' },
    sortable: true,
    selectionModel: { type: null },
    numberCell: { show:true,resizable: true, width: 30, title: "#" },
    //wrap: false, 
    // editable : true,
    hwrap: true,
    virtualX:true, 
    virtualY:true,
    resizable: true,     
    rowBorders: true,
    trackModel: { on: true }, //to turn on the track changes.            
    scrollModel: { autoFit: true, pace: 'optimum' },           
    swipeModel: { on: true },
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

}

function get_grid_actions(){  
    ajax_modal('.editProfileCheck',data_module+'/get_edit_check','Edit check from profile','large',save_check);
    ajax_modal('.viewProfileCheck',data_module+'/get_check_view','View profile check','large',render_check_view);
    delete_ajax('.deleteProfileCheck',data_module+'/delete_check','Profile',render_delete_profile);
    //get_check_reports();
}

function get_check_reports(){
    //$('.getCheckReport').on('click',function(e){
        //e.preventDefault();
        var btn=$(this);
        var report_type=$(this).attr('data-type');
        var id=$(this).attr('data-id');
        var formdata={'report_type':report_type,'id':id};

        var old_msg = btn.html();
        btn.attr('data-html',old_msg);
        btn.attr('disabled',true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $.post(urljs+data_module+'/get_check_report',formdata,function(data) {
              btn.removeAttr('data-html');
              btn.removeAttr('disabled');
              btn.html(old_msg);

            if(data.status=='success' && data.report_url!=''){
                window.open(data.report_url,'Download');
            }else{
                swal('Error',data.message,'error');
            }
        },'json');
    //});
}


 </script>
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
     
    $(function () {
        //called when save changes button is clicked.
        function saveChanges() {
            var grid = this;
            //attempt to save editing cell.
            if (grid.saveEditCell() === false) {
                return false;
            }

            if (grid.isDirty() && grid.isValidChange({ focusInvalid: true }).valid) {

                var gridChanges = grid.getChanges({ format: 'raw' });
                console.log(gridChanges);

                //post changes to server 
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    async: true,
                    beforeSend: function (jqXHR, settings) {
                        //grid.showLoading();
                        ajaxloading('Processing...</br>Please wait');
                    },
                    url: urljs+data_module+"/save_grid_data",
                    data: {
                        //JSON.stringify not required for PHP
                        workorders_id:getUrlParameter('id'),
                        action_type:"edit_update",
                        // list: JSON.stringify(gridChanges),
                        list: gridChanges
                    },
                    success: function (data) {
                        //debugger;
                        closeajax();
                        if(data.status=='success'){
                            $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
                            getdatas();
                            swal(data.message);
                        }else{
                            swal('Failed',data.message,'error');
                        }
                        grid.history({ method: 'reset' });
                    },
                    complete: function () {
                        grid.hideLoading();
                    }
                });
            }else{
                swal('','No changes made to update.','warning');
            }
        }

        var colM= [
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
            { title: "Name", dataType: "string", dataIndx: "workorders_profiles_name", editable: false, width: 80,
              filter: { type: 'textbox', condition: 'begin', listeners: ['change'] }
            },
            { title: "Email", dataType: "string", dataIndx: "workorders_profiles_email", editable: false, width: 80,
              filter: { type: 'textbox', condition: 'begin', listeners: ['change'] }
            },
            { title: "Phone", dataType: "string", dataIndx: "workorders_profiles_phone", editable: false, width: 80,
              filter: { type: 'textbox', condition: 'begin', listeners: ['change'] }
            },
            { title: "Comments", dataType: "string", dataIndx: "comments", editable: true, width: 80,
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

        var toolbar={
            items: [
                {
                    type: 'button', icon: 'ui-icon-disk', label: 'Save Changes', cls: 'btn btn-primary changes', listener: saveChanges,
                    options: { disabled: true }
                },
                { type: 'separator' },
                {
                    type: 'button', icon: 'ui-icon-arrowreturn-1-s', label: 'Undo', cls: 'btn btn-danger changes', listener: function () {
                        this.history({ method: 'undo' });
                    },
                    options: { disabled: true }
                },
                {
                    type: 'button', icon: 'ui-icon-arrowrefresh-1-s', label: 'Redo',cls: 'btn btn-success changes', listener: function () {
                        this.history({ method: 'redo' });
                    },
                    options: { disabled: true }
                }
            ]
        };

      var rowTemplate = {};

      var dataModel_url=urljs+data_module+"/get_grid_data?workorders_id="+getUrlParameter('id');
      var checkTypeURIparam=getUrlParameter('checkType');
      if(checkTypeURIparam!=undefined && checkTypeURIparam!=''){
        dataModel_url+="&checkType="+checkTypeURIparam;
      }

        var dataModel= {
          dataType: "JSON",
          location: "remote",
          paging: "remote",
          sorting: "remote",
          recIndx: "id",
          sortIndx: "id",
          sortDir: "down",
          colIndx:"id",
          url: dataModel_url,
          getData: function (response) {
              if(response.status=='success'){
                if(response.data_found=='yes'){
                    var colM = this.getColModel(),
                        rowTemplate = this.option('rowTemplate');
                    var jsonobj = JSON.parse(response.datas[0].input_json);                        

                    jsonobj.forEach(function (item, indx) {
                        colM.push({
                            dataIndx: item.name,
                            title: item.label,
                            editable: true,
                            dataType: "string"
                        });

                        //rowTemplate part required only in case of nested data.
                        (function (_indx) {
                            Object.defineProperty(rowTemplate, item.name, {
                                enumerable: true,
                                configurable:true,
                                get() {
                                    var jsonData=JSON.parse(this.input_json);
                                    var jsonRow =jsonData[_indx];
                                    if(jsonRow.userData!=undefined){
                                        var jsonvalue=jsonRow.userData[0];
                                    }else{
                                        var jsonvalue='';
                                    }
                                    //console.log(jsonRow.userData);
                                    return jsonvalue;
                                    // return this.custom_fields[_indx].userData[0];
                                },
                                set(val) {
                                    var jsonvalue=[val];
                                    this.input_json[_indx].userData = jsonvalue;
                                    //console.log(jsonvalue);
                                    // this.custom_fields[_indx].userData = [val]; 
                                }
                            })
                        })(indx);
                    });
                    this.refreshCM(colM);
                }
                    return {curPage: response.page_number, totalRecords: response.total_rows, data: response.datas };
              }else{
                swal(response.message);
              }
          }
        };

        var obj = {
            menuIcon:true,
            flex: { one: true }, 
            showTitle: false,                        
            // freezeCols: 1,                        
            hwrap: false,
            wrap: false,    
            trackModel: { on: true }, //to turn on the track changes.            
            toolbar: toolbar,
            numberCell: { show:true,resizable: true, width: 30, title: "#" },
            editModel: {
              clicksToEdit: 1,
              keyUpDown: false,
              onBlur: 'save'
            },
             editable: true,
             editor: {
                select: true
            },
            swipeModel: { on: false },

            title: "<b>Batch Editing</b>",
            history: function (evt, ui) {
                var $tb = this.toolbar();
                if (ui.canUndo != null) {
                    $("button.changes", $tb).button("option", { disabled: !ui.canUndo });
                }
                if (ui.canRedo != null) {
                    $("button:contains('Redo')", $tb).button("option", "disabled", !ui.canRedo);
                }
                $("button:contains('Undo')", $tb).button("option", { label: 'Undo (' + ui.num_undo + ')' });
                $("button:contains('Redo')", $tb).button("option", { label: 'Redo (' + ui.num_redo + ')' });
            }, 
            collapsible: {
              toggle: false
            },
            dataModel: dataModel,
            colModel: colM,
            rowTemplate: rowTemplate,
            postRenderInterval: -1, //call postRender synchronously.
            pageModel: { type: "remote", rPP: 20, strRpp: "{0}" },
        };
        pq.grid("#grid_editing", obj);
    });

 </script>
<script type="text/javascript">
    if($("#Tbl").length > 0) {
        var page = 1;
        getdatas(page);
        report_generate();
    }

    function getdatas(page){		
        var url = "admin/admissions/get_list";
    	ajax_filter(url, page, renderfilter)				
    }

    function renderfilter(datas){
        if(datas.result=="success"){
            var data = datas.data_list;
            var tableItems = "";
            var viewurl=urljs+'admin/admissions?view=';
            if (data.length > 0) {                
                for (var i = 0; i < data.length; i++) {

                    tableItems += '<tr>';
                    tableItems += '<td>' + data[i].sno + '</td>';
                    tableItems += '<td>' + data[i].acm_year + '</td>';
                    tableItems += '<td>' + data[i].code + '</td>';
                    tableItems += '<td>' + data[i].first_name +' '+data[i].last_name+'</td>';
                    tableItems += '<td>' + data[i].email + '</td>';
                    tableItems += '<td>' + data[i].mobile + '</td>';
                    tableItems += '<td>' + data[i].date + '</td>';                   
                    tableItems += '<td><a href="javascript:;" data-sid="' + data[i].id + '" data-fid="' + data[i].formId + '" title="View details" class="label label-success text-green btn-candidateDetail"><span class="fa fa-info-circle"></span></a><a href="'+urljs+'admin/admissions/pdf?sid=' + data[i].id + '&fid=' + data[i].formId + '" target="_blank" title="View details" class="label label-success text-danger"><span class="fa fa-file-pdf"></span></a></td></tr>';
                }
            }else {
                tableItems += '<tr>';
                tableItems += '<td colspan="8">No admissions found...</td>';
                tableItems += '</tr>';
            }
            $('#Tbl').html(tableItems);
            $('#page_result').html(datas.pagination);
            filterdata(); 
            open_details();
        }
    }

    function report_generate(){
        $("#export_form").on('submit', (function (e) {
            e.preventDefault();
            var $fields = $("#export_form :input");
            errorInputBox($fields);
            var form = $(this);
            var url = "admin/admissions/export_candidates";
            $ajax_text = "";
            ajax_request(form, url, $ajax_text, renderexceldata);
        }));
    }

    function renderexceldata(data) {
        if (data.status == "success") {
          document.location = urljs+"reports/"+data.result.filename;
        }else{
            swal({type: 'error', title:"Fail",html:data.message});  
        }
    }

    function open_details(){
      $('.btn-candidateDetail').on('click',function(e){
        e.preventDefault();
        var studentId=$(this).attr('data-sid');
        var formId=$(this).attr('data-fid');
        var dataModal = bootbox.dialog({
          title: "Candidate's Application Details",
          message: '<i class="fa fa-spinner fa-spin"></i> Loading, Please wait...',
          closeButton: true,
          size: 'extra-large',
          animate:true,
          //centerVertical:true,
          className: "largeWidth candidateDetailsModal",
        });
        var csrf_test_name=$["cookie"]("csrf_cookie_name");
        $.post(urljs+"admin/admissions/get_candidate_info",{'sid':studentId,'fid':formId,'csrf_test_name':csrf_test_name},function(data){
            dataModal.find('.bootbox-body').html(data.message);
            $('[data-toggle="tooltip"]').tooltip();
        },"json");
      });
    }


</script>
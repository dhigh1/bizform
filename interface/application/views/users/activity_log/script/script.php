<script type="text/javascript">

var data_module='activity_log';
$(document).ready(function() {
  assignValueToFilter();
  getdatas();
  ajax_export('.exportData',data_module);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
  }else{
    show_toast('error',datas.message);
  }
}

</script>
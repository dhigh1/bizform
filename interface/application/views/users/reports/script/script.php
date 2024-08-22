<script>
    $(document).ready(function() {
        init_daterange();
        get_customer_select2();
        get_services_select2();
        get_workorders_select2();
        get_status_select2();
        //assignValueToFilter();
    })

    $(".btn-report").on('click', function() {
        getdatas();
    })

    function getdatas(page) {
        ajaxloading('Loading...');
        ajax_custom_filter('reports/get_datas', page, renderfilter)
    }

    function renderfilter(datas) {
        if (datas.status == "success") {
            $('#Tbl').html(datas.message);
            downloadrender();
            filterdata();
            btn_url_load();
        } else {
            show_toast('error', datas.message);
        }
    }

    function downloadrender() {
        $(".report_download").on('click', function() {
            ajax_custom_filter('reports/report_download', '', download_excel);
        })
    }

    function download_excel(datas) {
        if (datas.status == 'success') {
            console.log(datas.status);
            location.href = datas.url;
        } else {
            show_toast('error', 'No report found');
        }
    }

    if ($("#form_report").length > 0) {
        get_report(1);
    }

    function get_report(page) {
        $('#form_report').validate({
            errorClass: 'error',
            validClass: 'valid',
            rules: {},
            messages: {},
            submitHandler: function(e) {
                // e.preventDefault();
                var formdata = new FormData($('#form_report')[0]);
                console.log(page)
                formdata.append('page', page);

                $["ajax"]({
                    url: urljs + "reports/generate_report",
                    type: "POST",
                    dataType: "json",
                    data: formdata,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        button_load('#form_report', 'Generating Report...', '.btn-report');
                    },
                    success: function(data) {
                        end_button_load('#form_report', '.btn-report');
                        if (data.status == 'success') {
                            $('#Tbl').html(data.message);

                            $("#page_result").unbind().on("click", ".pagination a", function(e) {
                                e.preventDefault();
                                var page = $(this).attr("data-page");
                                $("#page").val(page);
                                get_report(page);
                            });

                            // swal('Success', 'DONE', 'success');
                            // location.href = data.url;
                        } else {
                            swal_alert('error', data.message, 'Fail', '', '');
                        }
                    }
                })
            }
        });
    }


    var a = 10;

    function init_daterange() {
        $('.input-limit-datepicker').daterangepicker({
            autoUpdateInput: false,
            minDate: '01/09/2021',
            maxDate: new Date(),
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-custom',
            cancelClass: 'btn-secondary',
            dateLimit: {
                months: 2
            },
            // opens: 'left',
            // drops: 'down',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1,
                format: 'MM/DD/YYYY'
            }
        });
        $('.input-limit-datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
    }
</script>
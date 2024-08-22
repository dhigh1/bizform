function ajaxloading(texts){
 if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
 jQuery('body').append('<div id="resultLoading" style="display:none"><div><div class="card-box"><img src="'+urljs+'ui/loaders/throbber_12.gif" height="50"><div id="ajaxtext"></div></div></div><div class="bg"></div></div>');
 }
  jQuery('#resultLoading').css({
 'width':'100%',
 'height':'100%',
 'position':'fixed',
 'z-index':'10000000',
 'top':'0',
 'left':'0',
 'right':'0',
 'bottom':'0',
 'margin':'auto'
 });

  jQuery('#resultLoading .bg').css({
 'background':'#000000',
 'opacity':'0.7',
 'width':'100%',
 'height':'100%',
 'position':'absolute',
 'top':'0'
 });

  jQuery('#resultLoading>div:first').css({
 'width': '250px',
 'height':'75px',
 'text-align': 'center',
 'position': 'fixed',
 'top':'0',
 'left':'0',
 'right':'0',
 'bottom':'0',
 'margin':'auto',
 'font-size':'16px',
 'z-index':'10',
 'color':'#ffffff'

  });

 jQuery('#resultLoading .bg').height('100%');
 jQuery('#resultLoading').fadeIn(300);
 jQuery('body').css('cursor', 'wait');
  jQuery('#ajaxtext').html(texts);
  jQuery('#ajaxtext').css('color','#000');
 
}
function closeajax() {
 /* $(".pacpop")["remove"]();
 $(".pacpopbac")["remove"]()
 */
 jQuery('#resultLoading .bg').height('100%');
 jQuery('#resultLoading').fadeOut(300);
 jQuery('body').css('cursor', 'default');
}

function show_toast(msgType,msg){
  toastr.clear();
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "6500",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    toastr[msgType](msg)
}

deparam = (function(d,x,params,pair,i) {
  return function (qs) {
    // start bucket; can't cheat by setting it in scope declaration or it overwrites
    params = {};
    // remove preceding non-querystring, correct spaces, and split
    qs = qs.substring(qs.indexOf('#')+1).replace(x,' ').split('&');
    // march and parse
    for (i = qs.length; i > 0;) {
      pair = qs[--i].split('=');
      params[d(pair[0])] = d(pair[1]);
    }
    return params;
  };//--  fn  deparam
})(decodeURIComponent, /\+/g);
var handleBootbox = function () {
  $(".basic-alert").click(function(){
    bootbox.alert("Hello World");
  });
}

function assignValueToFilter(){
  var page = window.location.hash.substr(1);
  var q = deparam(page);
  var msg = JSON.stringify(q);
  var result = $.parseJSON(msg);
  $.each(result, function(k, v) {
    var id = $('[data-type='+k+']').attr('id');
    $('#'+id).val(v);
  });
}

function emptyValueToFilter(){
  var page = window.location.hash.substr(1);
  var q = deparam(page);
  var msg = JSON.stringify(q);
  var result = $.parseJSON(msg);
  $.each(result, function(k, v) {
    var id = $('[data-type='+k+']').attr('id') ;
    $('#'+id).val("");
  });
}

function failureResult(form,msg,autohide){
  if(autohide==true){
    var result = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+msg+'</div>';  
  }else{
    var result = '<div class="alert alert-danger fade show" role="alert">'+msg+'</div>';
  }
  var div =$('#'+form).find('.div_res');
  $(div).html(result); 
  if(autohide==true){
    setTimeout(function(){
      $(div).html('');
    },5000);
  }
  $(div).show();
}

function successResult(form,msg,autohide){
  if(autohide==true){
    var result = '<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+msg+'</div>';
  }else{
    var result = '<div class="alert alert-success fade show" role="alert">'+msg+'</div>';
  }
  var div =$('#'+form).find('.div_res');
  $(div).html(result);
  if(autohide==true){
    setTimeout(function(){
      $(div).html('');
    },5000);
  }
  $(div).show();
}

function show_btn_load(form,msg,btn_elem){
  if(btn_elem==''){
    var btn = $(form).find('button[type=submit]');
  }else{
    var btn = $(btn_elem);
  }
  var old_msg = btn.html();
  btn.attr('data-html',old_msg);
  btn.attr('disabled','true');
  btn.html("<i class='fa fa-spinner fa-spin '></i> "+msg);
}

function close_btn_load(form,btn_elem){
  if(btn_elem==''){
    var btn = $(form).find('button[type=submit]');
  }else{
    var btn = $(btn_elem);
  }
  var old_msg = btn.attr('data-html');
  btn.removeAttr('data-html');
  btn.removeAttr('disabled');
  btn.html(old_msg);
}


function common_btn_load(elem,msg){
  var btn = $(elem);
  var old_msg = btn.html();
  btn.attr('data-html',old_msg);
  btn.attr('disabled','true');
  btn.html("<i class='fa fa-spinner fa-spin '></i> "+msg);
}

function close_commonbtn_load(elem,msg){
  var btn = $(elem);
  var old_msg = btn.attr('data-html');
  btn.removeAttr('data-html');
  btn.removeAttr('disabled');
  btn.html(old_msg);
}

function GetURLParameter(sParam) {
  var page = document.URL.split("#");
  var sPageURL = page[1];
  if(sPageURL!=undefined) {
    //var sPageURL = window.location.hash.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
      var sParameterName = sURLVariables[i].split('=');
      if (sParameterName[0] == sParam) {
        return sParameterName[1];
      }
    }
  }
}


//toggle password
function pwd_showHide(){
    $(".Togglepwd .fa").on('click', function(event) {
        event.preventDefault();
        var elem=$(this).parent();
        if($(elem).find('input').attr("type") == "password"){
            $(elem).find('input').attr('type', 'text');
            $(this).toggleClass("fa-eye-slash").toggleClass("fa-eye");
        }else{
            $(elem).find('input').attr('type', 'password');
            $(this).toggleClass("fa-eye").toggleClass("fa-eye-slash");
        }
    });
}

if($('.Togglepwd').length>0){
    pwd_showHide();
}

if($('.data-tooltip').length>0){
    $('[data-toggle="tooltip"]').tooltip(); 
}

$(".fullscreen-link").click(function(e) {
    $("body").hasClass("fullscreen-mode") ? ($("body").removeClass("fullscreen-mode"), $(this).closest("div.card-box").removeClass("card-fullscreen"), $(window).off("keydown", e)) : ($("body").addClass("fullscreen-mode"), $(this).closest("div.card-box").addClass("card-fullscreen"), $(window).on("keydown", e))
});
$(".card-collapse").click(function() {
    $(this).closest("div.card-box").toggleClass("collapsed-mode").children(".card-body").slideToggle(200)
});
$(".card-remove").click(function() {
    $(this).closest("div.stats-box").remove()
});

function goBottomScroll(id){
  $(id).stop().animate({ scrollTop: $(id)[0].scrollHeight}, 1000);
}

function init_search_select(){
  var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : { allow_single_deselect: true },
    '.chosen-select-no-single' : { disable_search_threshold: 10 },
    '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
    '.chosen-select-rtl'       : { rtl: true },
    '.chosen-select-width'     : { width: '95%' }
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }
}

//if($('#adv-search').length>0){
//press enter on text area..
  $('.refine_filter').keypress(function (e) {
   var key = e.which;
   if(key == 13)  // the enter key code
    {
      $('.filter').click();
      return false;  
    }
  });
//}


 function downloadHtml2Image(div){
   html2canvas(document.querySelector(div)).then(canvas => {
    a = document.createElement('a'); 
    document.body.appendChild(a); 
    a.download = "snapshot.png";
    a.href =  canvas.toDataURL();
    a.click();
  });  
 }

 function init_accordian() {
    $('.accordion-head-panel').click(function(e) {
      e.preventDefault();    
      let $this = $(this);
      if ($this.next().hasClass('active')) {
        $this.next().removeClass('active');
        $(this).find('.btn_colaps .fa').removeClass('fa-chevron-up');
        $(this).find('.btn_colaps .fa').addClass('fa-chevron-down');
      } else {
        $this.next().addClass('active');
        $this.next().addClass('active');
        $(this).find('.btn_colaps .fa').removeClass('fa-chevron-down');
        $(this).find('.btn_colaps .fa').addClass('fa-chevron-up');
      }
  });
}
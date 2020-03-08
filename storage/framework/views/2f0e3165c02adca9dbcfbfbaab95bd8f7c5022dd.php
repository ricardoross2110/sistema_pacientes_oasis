<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="<?php echo e(asset('/js/app.js')); ?>" type="text/javascript"></script>

<!-- icheck -->
<script src="<?php echo e(asset('/plugins/iCheck/icheck.min.js')); ?>"></script>

<!-- datatable -->
<script src="<?php echo e(asset('/plugins/datatables/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('/plugins/datatables/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>

<!-- Duallistbox Files -->
<script src="<?php echo e(asset('/plugins/duallistbox/src/jquery.bootstrap-duallistbox.js')); ?>" type="text/javascript"></script>

<!-- multi select -->
<script src="<?php echo e(asset('/plugins/multiselectjs/dist/js/multiselect.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('/plugins/select2/dist/js/select2.min.js')); ?>" type="text/javascript"></script>

<!-- Datepicker Files -->
<script src="<?php echo e(asset('/plugins/datepicker/bootstrap-datepicker.js')); ?>"></script>
<!-- Languaje Datepicker -->
<script src="<?php echo e(asset('/plugins/datepicker/locales/bootstrap-datepicker.es.js')); ?>"></script>

<!-- Timepicker Files -->
<script src="<?php echo e(asset('/plugins/timepicker/bootstrap-timepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/datetime.js')); ?>"></script>

<!-- graficos -->
<script src="<?php echo e(asset('plugins/raphael/raphael.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/morris/morris.min.js')); ?>"></script>

<!-- Fullcalendar files -->
<script src="<?php echo e(asset('plugins/moment/min/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/fullcalendar/fullcalendar.min.js')); ?>"></script>

<!-- treegrid -->
<script src="<?php echo e(asset('/plugins/jquery-treegrid/js/jquery.treegrid.js')); ?>"></script>
<script src="<?php echo e(asset('/plugins/jquery-treegrid/js/jquery.treegrid.bootstrap3.js')); ?>"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script type="text/javascript">

    var patronPermitido =/^[A-Za-z\u00E1\u00E9\u00ED\u00F3\u00FA\u00F1\u00D1\u00C1\u00C9\u00CD\u00D3\u00DA0-9 ]*$/;

    $(function() {

        if(!$.support.placeholder) { 
            var active = document.activeElement;
            $('input[type="textarea"], textarea').focus(function () {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function () {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $('input[type="textarea"], textarea').blur();
            $('form').submit(function () {
                $(this).find('.hasPlaceholder').each(function() { $(this).val(''); });
            });
        }
    });

    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function onlyNumbers(evt) {
        if(evt.charCode < 47 || evt.charCode > 57){
            return false;
        }
    }

    function digitoverificador(evt) {
        if (evt.charCode != 107) { 
            if (evt.charCode != 75) { 
                if(evt.charCode < 47 || evt.charCode > 57){
                    return false;
                }   
            }
        }
    }

    function isNumber(event) {
        var number = parseFloat($('#' + event).val());
        if ($.isNumeric(number) === false) {
            $('#' + event).val('');
        }
    }

    function maxLengthCheck(object){
        if (object.value.length > object.maxLength){
            object.value = object.value.slice(0, object.maxLength)
        }
    }

    function soloLetras(e) {
        key = e.keyCode || e.which;
        console.log(key);
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = [8, 37, 39, 46, 241, 209, 193, 225, 233, 201, 237, 205, 243, 211, 250, 218];

        tecla_especial = false
        for(var i in especiales) {
            if(key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    }

    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>;

    // esconder mensajes de alerta
  	window.setTimeout(function() {
  	    $(".alert").fadeTo(500, 0).slideUp(500, function(){
  	        $(this).remove(); 
  	    });
  	}, 4000);

    // iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
    })  


    // cambio caracteres para ordenamiento
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "letras-pre": function ( data ) {

        return data.toLowerCase()
            .replace(/\u00E1/g, 'a') //á
            .replace(/\u00E9/g, 'e') //é
            .replace(/\u00ED/g, 'i') //í
            .replace(/\u00F3/g, 'o') //ó
            .replace(/\u00FA/g, 'u') //ú
            .replace(/\u00F1/g, 'n') //ñ
            .replace(/\u00D1/g, 'n') //Ñ
            .replace(/\u00C1/g, 'a') //Á
            .replace(/\u00C9/g, 'e') //É
            .replace(/\u00CD/g, 'i') //Í
            .replace(/\u00D3/g, 'o') //Ó
            .replace(/\u00DA/g, 'u') //Ú           
            .replace(/ç/g, 'c');
        },
        "letras-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        "letras-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });


    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "num-html-pre": function ( a ) {
            var x = String(a).replace( /<[\s\S]*?>/g, "" );
            return parseFloat( x );
        },
       
        "num-html-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
       
        "num-html-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });      

    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-range-pre": function ( a ) {
            var monthArr = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            return monthArr.indexOf(a); 
        },
         "date-range-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
         "date-range-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });

</script>

import './jquery';
import select2 from  'select2/dist/js/select2.min';
import 'select2/dist/css/select2.min.css';
import '../../css/select2.css';
select2($);

//listener

$(document).ready(function () {
    $('.select2').select2();
});

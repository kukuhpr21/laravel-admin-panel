import './jquery';
import select2 from  'select2/dist/js/select2.min';
import 'select2/dist/css/select2.min.css';
import '../css/select2.css';
select2($);

//listener

$(document).ready(function () {
    $('.select2').select2();
 // Apply Tailwind classes after initialization
//  $('.select2-container').addClass('w-full');
//  $('.select2-selection--single').addClass('bg-gray-50 border border-gray-300 rounded-lg shadow-sm');
//  $('.select2-results__option').addClass('px-4 py-2 cursor-pointer text-gray-800');
//  $('.select2-results__option--highlighted').addClass('bg-blue-500 text-white');
});

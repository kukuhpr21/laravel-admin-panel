// css
import 'remixicon/fonts/remixicon.css';
import 'leaflet/dist/leaflet.css';
import 'select2/dist/css/select2.min.css';

//js
import './bootstrap';
import 'preline'
import Chart from 'chart.js/auto';
import L from 'leaflet';
import $ from 'jquery';
import 'select2';

// export
window.Chart = Chart;
window.L = L;
window.$ = $;
window.jQuery = $;

//listener
document.addEventListener('DOMContentLoaded', function() {
    $('.select2').select2();
});

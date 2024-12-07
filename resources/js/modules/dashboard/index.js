import { generateChart} from '../../utils/chart';
import { generateMap } from '../../utils/leaflet';

const chartData = {
    labels: ['January', 'February', 'March', 'April', 'May'],
    datasets: [
        {
            label: 'Sales',
            data: [12, 19, 3, 5, 2],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
        },
    ],
};

generateChart('myChart', 'bar', chartData);

const mapConfig = {
    center: [51.505, -0.09], // Latitude and Longitude
    zoom: 13, // Zoom level
};

const mapMarkers = [
    {
        coords: [51.505, -0.09],
        popup: "I am a marker at the center!",
    },
    {
        coords: [51.515, -0.1],
        popup: "I am another marker!",
    },
];

generateMap('map', mapConfig, mapMarkers);

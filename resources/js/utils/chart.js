import Chart from 'chart.js/auto';


// example data
// const chartData = {
//     labels: ['January', 'February', 'March', 'April', 'May'],
//     datasets: [
//         {
//             label: 'Sales',
//             data: [12, 19, 3, 5, 2],
//             backgroundColor: 'rgba(75, 192, 192, 0.2)',
//             borderColor: 'rgba(75, 192, 192, 1)',
//             borderWidth: 1,
//         },
//     ],
// };


export const generateChart = (canvasID, type, data) => {
    const ctx = document.getElementById(canvasID).getContext('2d');

    // Destroy existing chart instance on the canvas, if any.
    if (window[canvasID + '_chart']) {
        window[canvasID + '_chart'].destroy();
    }

    window[canvasID + '_chart'] = new Chart(ctx, {
        type: type, // bar | bubble | doughnut | pie | line | polarArea | radar | scatter
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}

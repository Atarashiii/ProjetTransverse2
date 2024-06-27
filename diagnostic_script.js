// Récupérer les données transmises depuis PHP
var canvas = document.getElementById('chart');
var axesData = JSON.parse(canvas.getAttribute('data-axes'));

// Préparer les données pour Chart.js
var labels = Object.keys(axesData);
var data = Object.values(axesData);

// Créer un diagramme avec Chart.js
var ctx = canvas.getContext('2d');
var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total des valeurs par axe',
            data: data,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                beginAtZero: true,
                max: 5
            }
        },
        elements: {
            line: {
                borderWidth: 3
            }
        }
    }
});

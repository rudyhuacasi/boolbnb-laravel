const visitorsContainer = document.querySelector('.chart-container');
const visitorsData = visitorsContainer.getAttribute('data-visitors');

const visitors = JSON.parse(visitorsData);
console.log(visitors)

const visuals = {
    'January': 0,
    'February': 0,
    'March': 0,
    'April': 0,
    'May': 0,
    'June': 0,
    'July': 0,
    'August': 0,
    'September': 0,
    'October': 0,
    'November': 0,
    'December': 0
};

visitors.forEach(visitor => {
    const mese = visitor.created_at.substring(0, 10);
    const thisMonth = moment(mese, 'YYYY-MM-DD').format("MMMM");

    if (visuals[thisMonth] !== undefined) {
        visuals[thisMonth] += 1;
    }
});

results(visuals);

function results(visuals) {
    let month = [];
    let num = [];

    for (let key in visuals) {
        month.push(key);
        num.push(visuals[key]);
    }
    totVisuals(month, num);
}

// Grafico visualizzazioni totali
function totVisuals(month, num) {
    const grafico = document.getElementById('chart');
    let chart = new Chart(grafico, {
        type: 'line',
        data: {
            labels: month,
            datasets: [{
                label: "Visite mensili",
                backgroundColor: '#00d9a6',
                borderColor: '#00d9a6',
                data: num
            }]
        },
        options: {
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Visualizzazioni'
                    }, beginAtZero: true
                }
            }
        }
    });
};


function countVisualsByApartment(visitors) {
    const apartmentVisuals = {};

    visitors.forEach(visitor => {
        const apartmentTitle = visitor.home.title;
        if (apartmentVisuals[apartmentTitle]) {
            apartmentVisuals[apartmentTitle] += 1;
        } else {
            apartmentVisuals[apartmentTitle] = 1;
        }
    });

    return apartmentVisuals;
}

const visualCounts = countVisualsByApartment(visitors);
console.log(visualCounts)

const apartmentNames = Object.keys(visualCounts);
console.log(apartmentNames)
const visualizations = Object.values(visualCounts);
console.log(visualizations)

apartmentVisuals(apartmentNames, visualizations);

// Grafico visualizzazioni per appartamento
function apartmentVisuals(apartmentNames, visualizations) {
    const grafico = document.getElementById('chart-apartments');
    let chart_apartments = new Chart(grafico, {
        type: 'bar',
        data: {
            labels: apartmentNames,
            datasets: [{
                label: "Visite per appartamento",
                backgroundColor: '#00d9a6',
                borderColor: '#00d9a6',
                data: visualizations
            }]
        },
        options: {
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Visualizzazioni'
                    }, beginAtZero: true
                }
            }
        }
    });
}
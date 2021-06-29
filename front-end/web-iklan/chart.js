fetch('http://127.0.0.1:8000/api/aktif/')
    .then(response => response.json())
    .then(response => {
        data = response.data
        console.log(data);
        const tanggal = data.map((d) => d.tanggal = moment(d.tanggal).format('LL'))
        const jumlah = data.map((d) => d.jumlah)

        console.log(tanggal)
        console.log(jumlah);
        const ctx = document.getElementById('canvas').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: tanggal,
                datasets: [{
                    label: 'Iklan Aktif',
                    data: jumlah,
                    backgroundColor: 'transparent',
                    borderColor: 'red',
                    borderWidth: 3
                }]

            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
<!DOCTYPE html>
<html>
<head>
    <title>Погода</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<h1>Погода</h1>

<input type="text" id="search" placeholder="Введіть місто..." />

<div id="results"></div>

<script>
    const searchInput = document.getElementById('search');
    const resultsDiv = document.getElementById('results');

    searchInput.addEventListener('input', async function () {
        const query = searchInput.value.trim();

        if (query.length < 2) {
            resultsDiv.innerHTML = '';
            return;
        }

        const response = await fetch(`/api/weather?search=${encodeURIComponent(query)}`);
        const weatherData = await response.json();

        if(weatherData.error) {
            resultsDiv.innerHTML = `<p>${weatherData.error}</p>`;
        } else {
            resultsDiv.innerHTML = `
                <p>Поточна погода в ${weatherData.city}, ${weatherData.country}</p>
                <p>Температура: ${weatherData.temperature}</p>
                <p>Стан: ${weatherData.condition}</p>
                <p>Вологість: ${weatherData.humidity}</p>
                <p>Швидкість вітру: ${weatherData.wind_speed}</p>
                <p>Останнє оновлення: ${weatherData.last_updated}</p>
            `;
        }
    });
</script>
</body>
</html>

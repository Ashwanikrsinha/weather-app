const API_URL = 'http://weatherapp.local/api';
const WEATHER_API_URL = 'https://api.openweathermap.org/data/2.5';
const WEATHER_API_KEY = 'e12cd8cbd3df2dacdfcfb78e39714809'; 

export async function fetchWeatherData(lat, lon) {
  try {
    let [weatherPromise, forcastPromise] = await Promise.all([
      fetch(
        `${API_URL}/weather-by-coordinates?latitude=${lat}&longitude=${lon}`
      ),
      fetch(
        `${WEATHER_API_URL}/forecast?lat=${lat}&lon=${lon}&appid=${WEATHER_API_KEY}&units=metric`
      ),
    ]);

    const weatherResponse = await weatherPromise.json();
    const forcastResponse = await forcastPromise.json();
    return [weatherResponse, forcastResponse];
  } catch (error) {
    console.log(error);
  }
}

export async function fetchCities(input) {
  if (input) {
  try {
    const response = await fetch(
      `${API_URL}/search-city?query=${input}`
    );

    const data = await response.json();
    return data;
  } catch (error) {
    console.log(error);
    return;
  }
}
}

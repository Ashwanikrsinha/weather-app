"# Weather App Assesment" 
Welcome to the Project Name repository! This project consists of a Laravel backend and a React frontend.


## ✨ Getting Started
## Backend
- Make sure you already have `php:8.2^` and `composer` installed in your system.
- You need to configure the `.env` file with database and API details.
- Clone the repository
- `cd backend` in `cli`
- `composer install`
- `cp .env.example .env`
- Configure the `.env` file
- `DB_CONNECTION=sqlite` and setup your `sqlite`
- You need an API key from [OpenWeatherMap](https://openweathermap.org/). After creating an account, [grab your key](https://home.openweathermap.org/api_keys).
- Then, under the `src` directory, go to `.env` and replace `WEATHER_API_KEY`  And for Current weather replace `API_URL` with your openweather api Url.
- `php artisan key:generate`
-  `php artisan migrate`
- `php artisan serve`


<br/>

## ⚡ Install Frontend

- Clone the repository: 
- `cd ../frontend`
- Install the packages using the command `npm install`
- `cp .env.example .env`
- Make sure you already have `Node.js` and `npm` installed in your system.
- You need an API key from [OpenWeatherMap](https://openweathermap.org/). After creating an account, [grab your key](https://home.openweathermap.org/api_keys).
- Then, under the `src` directory, go to `,env` and replace `REACT_APP_WEATHER_API_KEY` and `REACT_APP_WEATHER_API_URL` with your OpenWeatherMap API Key for weekly weather Forcasst. And for Current weather replace `REACT_APP_API_URL` with your Laravel Backend Url.
  - **`api/OpenWeatherService.js`**: It contains the code related to the back-end of the application.


## 📙 Used libraries
## Frontend
- `react-js`
- `material-ui`
## Backend 
- `Laravel`

Check `packages.json` for details

Thank You ☺

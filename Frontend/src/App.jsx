
import React, { useEffect, useState } from "react";
import "./App.css";
import InputForm from "./InputForm";
import WeatherCard from "./WeatherCard";
import axios from "axios";
import Search from "./component/search";
import dotenv from 'dotenv'; 
dotenv.config();

function App() {
  const [data, setData] = useState({});
  const [todayWeather, setTodayWeather] = useState(null);
  const [todayForecast, setTodayForecast] = useState([]);
  const [weekForecast, setWeekForecast] = useState(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(false);

  useEffect(() => {
    const storedWeatherData = sessionStorage.getItem("weatherData");

    if (storedWeatherData) {
      setData(JSON.parse(storedWeatherData));
    }
  }, []);

  const searchChangeHandler = async (enteredData) => {
    const [latitude, longitude] = enteredData.value.split(' ');

    setIsLoading(true);

    const currentDate = transformDateFormat();
    const date = new Date();
    let dt_now = Math.floor(date.getTime() / 1000);

    try {
      const [todayWeatherResponse, weekForecastResponse] =
        await fetchWeatherData(latitude, longitude);
      const all_today_forecasts_list = getTodayForecastWeather(
        weekForecastResponse,
        currentDate,
        dt_now
      );

      const all_week_forecasts_list = getWeekForecastWeather(
        weekForecastResponse,
        ALL_DESCRIPTIONS
      );

      setTodayForecast([...all_today_forecasts_list]);
      setTodayWeather({ city: enteredData.label, ...todayWeatherResponse });
      setWeekForecast({
        city: enteredData.label,
        list: all_week_forecasts_list,
      });
    } catch (error) {
      setError(true);
    }

    setIsLoading(false);
  };
  const searchedCityName = async (cityName) => {
    try {
      const res = await axios.request({
        method: "GET",
        url: `${import.meta.env.VITE_API_URL}/search-city`,
      });
      sessionStorage.setItem("weatherData", JSON.stringify(res.data));
      setData(res.data);
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <div
      style={{ backgroundColor: " #1B262C", height: "1148px" }}
      className="weatherApp"
    >
      <h1
        style={{
          color: "#fff",
          fontSize: "40px",
          fontWeight: 600,
          textAlign: "center",
          lineHeight: 4,
        }}
      >
        Dark Weather
      </h1>
      <h2
        style={{
          color: "#fff",
          fontSize: "40px",
          fontWeight: 500,
          width: "778px",
          marginLeft: "22rem",
          textAlign: "center",
        }}
      >
        Seeing the weather of the whole world with&nbsp;
        <span className="gradient">Dark Weather!</span>
      </h2>
      <Search onSearchChange={searchChangeHandler} />
      {/* <InputForm searchedCityName={searchedCityName} data={data} /> */}

      <WeatherCard data={data} />
    </div>
  );
}

export default App;

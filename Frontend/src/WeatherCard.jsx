import React, { useEffect, useState } from "react";
import ThunderStrom from "./assets/ThunderStrom.png";
import Cloud from "./assets/Cloud.png";
import Sun from "./assets/Sun.png";
import { farhenhiteToCelcius, sunriseAndSunset } from "./helpers";

function WeatherCard({ data }) {
  const logo = "cloud";
  const cityTemp = data?.main?.temp
    ? farhenhiteToCelcius(data?.main?.temp).toFixed()
    : "0";
  const feelsLike = data?.main?.feels_like
    ? farhenhiteToCelcius(data?.main?.feels_like).toFixed()
    : "0";

  const sunRise = sunriseAndSunset(data?.sys?.sunrise);
  const sunSet = sunriseAndSunset(data?.sys?.sunset);

  return (
    data?.weather && (
      <>
        <div
          style={{
            backgroundColor: "#24353E",
            borderRadius: "25px",
            width: "180px",
            textAlign: "center",
            padding: "10px 5px",
            margin: "0 auto",
            marginTop: "2rem",
          }}
        >
          <p
            style={{ color: "#EAE5E5", fontWeight: "300", fontSize: "0.9rem" }}
          >
            Feels Like : {feelsLike}°C
          </p>
        </div>

        <div style={{ color: "#fff" }} className="weatherCard">
          <div
            className="weatherCardLogo"
            style={{
              top:
                logo === "cloud" ? "-5rem" : logo === "sun" ? "-6rem" : "-3rem",
              left:
                logo === "cloud" ? "4rem" : logo === "sun" ? "3rem" : "7rem",
            }}
          >
            <img
              src={
                logo === "cloud" ? Cloud : logo === "sun" ? Sun : ThunderStrom
              }
              alt="logo"
              width={
                logo === "cloud" ? "320px" : logo === "sun" ? "310px" : "190px"
              }
            />
          </div>
          <div
            className="weatherCardDetails"
            style={{
              position: "relative",
              top: logo === "cloud" ? "-3rem" : logo === "sun" ? "-6rem" : "",
              marginLeft: "2rem",
            }}
          >
            <h2 className="cityName">
              {data.name || "cityname"}
              <span className="cityTemp"> {cityTemp}°C </span>
            </h2>

            <p className="details">Wind Speed: {data?.wind?.speed || "0"} km/h</p>
            <p className="details">{data?.weather?.[0]?.main || "cloudy"}</p>
            <p className="details">Humidty: {data?.main?.humidity}%</p>
            <p className="details">Sunrise: {sunRise}</p>
            <p className="details">Sunset: {sunSet}</p>
          </div>
        </div>
      </>
    )
  );
}

export default WeatherCard;

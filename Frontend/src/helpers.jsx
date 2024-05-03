const farhenhiteToCelcius = (farhenhite) => {
  return (farhenhite - 32) * (5 / 9);
};

const sunriseAndSunset = (timestamp) => {
  const date = new Date(timestamp * 1000);

  const hours = date.getHours();
  const minutes = date.getMinutes();

  const formattedHours = hours % 12 || 12;
  const amPm = hours >= 12 ? "PM" : "AM";

  const formattedTime = `${formattedHours}:${
    minutes < 10 ? "0" : ""
  }${minutes} ${amPm}`;

  return formattedTime;
};

export { farhenhiteToCelcius, sunriseAndSunset };

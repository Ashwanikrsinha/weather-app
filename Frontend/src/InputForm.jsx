import React, { useEffect, useState } from "react";
import { IoIosSearch } from "react-icons/io";
import { farhenhiteToCelcius } from "./helpers";
import { Tooltip } from "@mui/material";

function InputForm({ searchedCityName, data }) {
  const [search, setSearch] = useState("");

  const handleSearch = () => {
    searchedCityName(search);
  };

  const handleKeyDown = (e) => {
    if (e.key === "Enter") {
      handleSearch();
    }
  };

  const minTemp = data?.main?.temp_min
    ? farhenhiteToCelcius(data.main.temp_min).toFixed()
    : "min";
  const maxTemp = data?.main?.temp_max
    ? farhenhiteToCelcius(data.main.temp_max).toFixed()
    : "max";

  return (
    <div
      style={{
        color: "#fff",
        marginLeft: "18rem",
        marginTop: "5rem",
        display: "flex",
        gap: "5rem",
      }}
      className="inputForm"
    >
      <div className="inputFormSearch">
        <input
          type="search"
          placeholder="Search Here"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          onKeyDown={handleKeyDown}
        />
        <Tooltip describeChild title="click or press enter">
          <div>
            <IoIosSearch onClick={handleSearch} />
          </div>
        </Tooltip>
      </div>

      <div className="weatherDetails">
        Weather
        <div className="temperature">{data?.weather?.[0]?.main || "main"}</div>
        <div className="temperature">
          {minTemp}°C - {maxTemp}°C
        </div>
        <div className="temperature">
          {data?.weather?.[0]?.description || "desc"}
        </div>
      </div>
    </div>
  );
}

export default InputForm;

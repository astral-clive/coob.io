import React, { useState } from "react";
import "./CoobColorSquare.css";
import { motion } from "framer-motion";
import { CircleSlider } from "react-circle-slider";
import ActualSquare from "./ActualSquare";

function CoobColorSquare({ hexColor, shadow, gradient }) {
  const [redValue, setRedValue] = useState(0);
  const [greenValue, setGreenValue] = useState(0);
  const [blueValue, setBlueValue] = useState(0);

  function handleRedSlider (e){
    setRedValue(e);
  }

  function handleGreenSlider(e){
    setGreenValue(e);
  }

  function handleBlueSlider(e){
    setBlueValue(e);
  }


  return (
    <div className="color__square__outer">
    <div className="circle__one">
    <CircleSlider
        size={500}
        knobRadius={20}
        progressWidth={20}
        circleWidth={10}
        circleWidth={25}
        knobRadius={12.5}
        min={0}
        max={255}
        progressColor="#FF0000"
        onChange={handleRedSlider}
        />
    </div>
    <div className="circle__two">
    <CircleSlider
        size={450}
        knobRadius={20}
        progressWidth={20}
        circleWidth={10}
        circleWidth={25}
        knobRadius={12.5}
        progressColor="#228B22"
        min={0}
        max={255}
        onChange={handleGreenSlider}
        />
    </div>
    <div className="circle__three">
    <CircleSlider
        size={400}
        knobRadius={20}
        progressWidth={20}
        circleWidth={10}
        circleWidth={25}
        knobRadius={12.5}
        progressColor="#0000FF"
        min={0}
        max={255}
        onChange={handleBlueSlider}
        />
    </div>
    <div className="inner__circle__outer">
    <ActualSquare redValue={redValue} greenValue={greenValue} blueValue={blueValue}/>
  
    </div>


      {/* <div
        className={`color__square__holder ${shadow && "color__square__shadow"}`}
      ></div>
       */}
    
    </div>
  );
}

export default CoobColorSquare;

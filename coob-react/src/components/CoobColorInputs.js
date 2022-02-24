import React from "react";
import "./CoobColorInputs.css";


function CoobColorInputs({ setHexColor, setShadow, setGradient }) {
  function handleColorChange(e) {
    if (!e.target.value) {
      setHexColor("8B5FBF");
    } else {
      setHexColor(e.target.value);
    }
  }

  function handleShadowToggle(e) {
    setShadow(e.target.checked);
  }

  function handleSubmit(e) {
    e.preventDefault();
  }

  return (
    <div className="color__inputs__outer">
    
      <form>
        <input
          placeholder="Color code..."
          className="color__inputs__input"
          onChange={handleColorChange}
        />
        <input
          type="checkbox"
          defaultChecked
          value="Shadow"
          id="shadow_checkbox"
          onClick={handleShadowToggle}
        />
        <label for="shadow_checkbox">Shadow</label>
        <input
          type="checkbox"
          defaultChecked
          value="Linear Gradient"
          id="linear_gradient_checkbox"
        />
        <label for="linear_gradient_checkbox">Gradient</label>
        <button className="color__inputs__button" onClick={handleSubmit}>
          COOBIFY
        </button>
      </form>
    </div>
  );
}

export default CoobColorInputs;

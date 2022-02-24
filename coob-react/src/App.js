import Header from "./components/Header.js";
import "./App.css";
import IntroText from "./components/IntroText.js";
import CoobColorInputs from "./components/CoobColorInputs.js";
import CoobColorSquare from "./components/CoobColorSquare.js";
import { useState } from "react";
import Footer from "./components/Footer.js";
import Background from "./components/Background.js";

function App() {
  const [hexColor, setHexColor] = useState("8B5FBF");
  const [shadow, setShadow] = useState(false);
  const [gradient, setGradient] = useState(false);
  const [redValue, setRedValue] = useState(0);
  const [greenValue, setGreenValue] = useState(0);
  const [blueValue, setBlueValue] = useState(0);

  return (
    <div className="App">
      <Background>
        <Header />
        <IntroText />
        {/* <CoobColorInputs
          setHexColor={setHexColor}
          setShadow={setShadow}
          setGradient={setGradient}
        /> */}
        <CoobColorSquare
          hexColor={hexColor}
          shadow={shadow}
          gradient={gradient}
        />
        <Footer />
      </Background>
    </div>
  );
}

export default App;

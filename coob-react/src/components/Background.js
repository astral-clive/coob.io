import React from "react";
import "./Background.css";
import { motion } from "framer-motion";

function Background({ children }) {

  const shapeArray = ['_1', '_2', '_3', '_4', '_5', '_6', '_7', '_8', '_9', '_10', '_11', '_12', '_13', '_14', '_15', '_16', '_17', '_18', '_19', '_20', '_21']


  return (
    <div className="background__outer">
      <div className="app__content">{children}</div>
      {shapeArray.map((item, index) => (
      <motion.div
              className={item}
              initial={{scale: 1, originX: 0, rotate: 0}}
              ainimate={{ scale: 1.3, boxShadow: "10px 10px 0 rgba(0, 0, 0, 0.2)", originX: 0, rotate: 20 }}
              whileHover={{ scale: 1.3, boxShadow: "10px 10px 0 rgba(0, 0, 0, 0.2)", originX: 0, rotate: 40 }}
              transition={{ type: "spring", stiffness: 120 }}
            ></motion.div>
      ))}
      
    </div>
  );
}

export default Background;

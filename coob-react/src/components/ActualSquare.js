import React from 'react';
import { motion } from "framer-motion";

function ActualSquare({redValue, greenValue, blueValue}) {

const colorStringToPass = "RGB(" + redValue + ", " + greenValue + ", " + blueValue + " )";

  return (
     <motion.div
    whileHover={{
      scale: [1, 1.2, 1.2, 1, 1],
      rotate: [0, 0, 270, 270, 0],
      borderRadius: ["10%", "20%", "50%", "50%", "10%"],
    }}
    transition={{type: 'spring', stiffness: 120, duration: 2}}
    // whileHover={{ scale: 1.1 }}
    // whileTap={{ scale: 1.2, boxShadow: "10px 10px 0 rgba(0, 0, 0, 0.2)" }}
    style={{
      width: "225px",
      height: "225px",
      backgroundColor: colorStringToPass,
      borderRadius: "10%",
      cursor: "pointer",
    }}
  ></motion.div>
  )
}

export default ActualSquare
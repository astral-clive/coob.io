import React from "react";
import COOB_Logo from "../COOB.io.svg";
import "./Header.css";
import { motion } from "framer-motion";

function Header() {
  return (
    <div className="header__outer">
      <motion.div
        initial={{ y: -1200, opacity: 1 }}
              transition={{
                y: { type: "spring", stiffness: 50, duration: 0.5 },
                duration: 2,
              }}
              animate={{ y: 0, opacity: 1 }}
      >
        <img src={COOB_Logo} alt="blocky coob logo" />
      </motion.div>
    </div>
  );
}

export default Header;

import React, { useState, useEffect } from "react";
import {
  FiActivity,
  FiBarChart,
  FiChevronDown,
  FiChevronsRight,
  FiDollarSign,
  FiHome,
  FiMonitor,
  FiShoppingCart,
  FiTag,
  FiUsers,
} from "react-icons/fi";
import { motion } from "framer-motion";

export const Example = () => {
  // Acceder a los datos de window.appData y establecerlos en el estado
  const [user, setUser] = useState(window.appData.user || null);
  const [categorias, setCategorias] = useState(window.appData.categorias || []);
  const [carrito, setCarrito] = useState(window.appData.carrito || []);

  return (
    <div className="flex bg-white dark:bg-black text-black dark:text-white">
      <Sidebar user={user} categorias={categorias} carrito={carrito} />
      <ExampleContent />
    </div>
  );
};

const Sidebar = ({ user, categorias, carrito }) => {
  const [open, setOpen] = useState(true);
  const [selected, setSelected] = useState("Dashboard");

  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth < 768 || (window.innerWidth >= 750 && window.innerWidth <= 1000)) {
        setOpen(false);
      } else {
        setOpen(true);
      }
    };

    handleResize(); // inicial
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);


  return (
    <motion.nav
      layout
      className={`sticky top-0 h-screen shrink-0 border-r border-slate-200 dark:border-slate-950 bg-white dark:bg-black p-2 transition-all duration-300 ${open ? "w-[225px]" : "w-[56px]"
        } sm:w-[56px] md:w-[150px] lg:w-[225px] overflow-hidden`}
    >
      <TitleSection open={open} user={user} />

      {user && (
        <div className="text-black text-sm mb-3 dark:text-white">
          Bienvenido: {user.nombre} {user.apellidos}
        </div>
      )}

      <div className="space-y-1">
        <Option Icon={FiHome} title="Inicio" {...{ selected, setSelected, open }} route="/producto/index" />
        <Option Icon={FiDollarSign} title="Ver Carrito" {...{ selected, setSelected, open }} route="/carrito/index" />
        {/* Otros enlaces */}
        {user?.rol === "admin" && (
          <>
            <Option Icon={FiShoppingCart} title="Gestionar Productos" {...{ selected, setSelected, open }} route="/producto/gestion" />
            <Option Icon={FiTag} title="Gestionar Pedidos" {...{ selected, setSelected, open }} route="/pedido/gestion" />
            <Option Icon={FiActivity} title="Gestionar Categorías" {...{ selected, setSelected, open }} route="/categoria/index" />
            <Option Icon={FiUsers} title="Gestionar Usuarios" {...{ selected, setSelected, open }} route="/usuario/listado" />
          </>
        )}

        {user && (
          <>
            <Option Icon={FiBarChart} title="Mis Pedidos" {...{ selected, setSelected, open }} route="/pedido/mis-pedidos" />
            <Option Icon={FiMonitor} title="Mi Perfil" {...{ selected, setSelected, open }} route="/usuario/perfil" />
          </>
        )}

        {!user && (
          <Option Icon={FiMonitor} title="Registrarse" {...{ selected, setSelected, open }} route="/usuario/registro" />
        )}
      </div>

      <ToggleClose open={open} setOpen={setOpen} />
    </motion.nav>
  );
};




const Option = ({ Icon, title, selected, setSelected, open, notifs, route }) => {
  const handleClick = () => {
    if (route) {
      window.location.href = route;
    } else {
      setSelected(title);
    }
  };

  return (
    <motion.button
      layout
      onClick={handleClick}
      className={`relative flex h-10 min-w-0 w-full items-center justify-center rounded-md transition-colors ${selected === title
          ? "bg-indigo-100 text-slate-800 dark:bg-indigo-800 dark:text-white"
          : "text-slate-600 hover:bg-slate-800  dark:text-slate-300 dark:hover:text-black dark:hover:bg-slate-100"
        } overflow-hidden`}
    >
      <motion.div layout className="grid h-full w-10 place-content-center text-lg">
        <Icon />
      </motion.div>
      {open && (
        <motion.span
          layout
          initial={{ opacity: 0, y: 12 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.125 }}
          className="text-xs font-medium truncate bg-white text-black hover:text-white dark:text-white dark:bg-black dark:hover:text-black dark:hover:bg-white"
        >
          {title}
        </motion.span>
      )}
      {notifs && open && (
        <motion.span
          initial={{ scale: 0, opacity: 0 }}
          animate={{ opacity: 1, scale: 1 }}
          style={{ y: "-50%" }}
          transition={{ delay: 0.5 }}
          className="absolute right-2 top-1/2 size-4 rounded bg-black text-xs text-white"
        >
          {notifs}
        </motion.span>
      )}
    </motion.button>
  );
};

const TitleSection = ({ open, user }) => {
  return (
    <div className="mb-3 border-b border-slate-300 dark:border-slate-700 pb-3">
      <div className="flex cursor-pointer items-center justify-between rounded-md transition-colors hover:bg-slate-100 dark:hover:bg-slate-800">
        <div className="flex items-center gap-2">
          <Logo />
          {open && (
            <motion.div
              layout
              initial={{ opacity: 0, y: 12 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.125 }}
            >
              <span className="block text-xs font-semibold text-slate-700 dark:text-slate-300">Roll&Play</span>
              <span className="block text-xs text-slate-500 dark:text-slate-400">
                {user ? `Bienvenido: ${user.nombre} ${user.apellidos}` : "Main Menu"}
              </span>
            </motion.div>
          )}
        </div>
        {open && <FiChevronDown className="mr-2" />}
      </div>
    </div>
  );
};

const Logo = () => {
  return (
    <motion.div
      layout
      className="grid size-10 shrink-0 place-content-center rounded-md bg-black"
    >
        <svg
        width="50"
        height="50"
        viewBox="0 0 120 120"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        className="fill-slate-50"
      >
        {/* Carrete exterior */}
        <circle cx="60" cy="60" r="50" stroke="white" strokeWidth="5" fill="none" />
        {/* Ruedas internas del carrete */}
        <circle cx="60" cy="60" r="10" fill="white" />
        {[0, 72, 144, 216, 288].map((angle, i) => {
          const rad = (angle * Math.PI) / 180;
          const x = 60 + 30 * Math.cos(rad);
          const y = 60 + 30 * Math.sin(rad);
          return <circle key={i} cx={x} cy={y} r="7" fill="white" />;
        })}
        {/* Cinta saliendo */}
        <path
          d="M60 100 C55 110, 65 115, 60 120"
          stroke="white"
          strokeWidth="3"
          fill="none"
        />
      </svg>
    </motion.div>
  );
};

const ToggleClose = ({ open, setOpen }) => {
  return (
    <motion.button
      layout
      onClick={() => setOpen((pv) => !pv)}
      className="w-full bottom-0 left-0 right-0 border-t border-slate-200 dark:border-slate-700 transition-colors hover:bg-slate-100 dark:hover:bg-black"
    >
      <div className="flex items-center p-2 text-black dark:text-white">
        <motion.div layout className="grid size-10 place-content-center text-lg">
          <FiChevronsRight className={`transition-transform ${open && "rotate-180"}`} />
        </motion.div>
        {open && (
          <motion.span
            layout
            initial={{ opacity: 0, y: 12 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.125 }}
            className="text-xs font-medium bg-white text-black hover:bg-black hover:text-white dark:bg-black dark:text-white dark:hover:text-black dark:hover:bg-white"
          >
            Hide
          </motion.span>
        )}
      </div>
    </motion.button>
  );
};

const ExampleContent = () => {
  return (
    <div className="w-full p-4">
      <div
        id="blade-container"
        dangerouslySetInnerHTML={{
          __html: document.getElementById("blade-content")?.innerHTML || "<p>Loading content...</p>",
        }}
      />
    </div>
  );
};

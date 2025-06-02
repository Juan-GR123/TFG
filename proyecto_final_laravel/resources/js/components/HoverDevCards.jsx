import React from "react";
import { FiCreditCard, FiHome, FiMail, FiUsers } from "react-icons/fi";

const HoverDevCards = () => {
  return (
    <div className="p-4">
      <p className="text-xl font-semibold mb-2 text-gray-600 dark:text-gray-400">Navegación</p>
      <div className="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <Card
          title="Inicio"
          subtitle="Ir a la página principal"
          href="/producto/index"
          Icon={FiHome}
        />
        <Card title="Registrarse" subtitle="Registrate en nuestra página" href="/usuario/registro" Icon={FiMail} />
        <Card title="Inicia sesión" subtitle="¿Ya tienes cuenta?" href="/usuario/sesion" Icon={FiUsers} />
        <Card
          title="Carrito"
          subtitle="¿Quieres comprar algo?"
          href="/carrito/index"
          Icon={FiCreditCard}
        />
      </div>
    </div>
  );
};

const Card = ({ title, subtitle, Icon, href }) => {
  return (
    <a
      href={href}
      className="w-full p-4 rounded border-[1px] border-slate-300 relative overflow-hidden group bg-black dark:bg-white"
    >
      <div className="absolute inset-0 bg-gradient-to-r from-violet-600 to-indigo-600 translate-y-[100%] group-hover:translate-y-[0%] transition-transform duration-300" />

      <Icon className="absolute z-10 -top-12 -right-12 text-9xl text-slate-800 dark:text-slate-100 group-hover:text-violet-400 group-hover:rotate-12 transition-transform duration-300" />
      <Icon className="mb-2 text-2xl text-violet-600 group-hover:text-white transition-colors relative z-10 duration-300" />
      <h3 className="font-medium text-lg text-slate-100 dark:text-slate-950  group-hover:text-white relative z-10 duration-300">
        {title}
      </h3>
      <p className="text-slate-400 group-hover:text-violet-200 relative z-10 duration-300">
        {subtitle}
      </p>
    </a>
  );
};

export default HoverDevCards;
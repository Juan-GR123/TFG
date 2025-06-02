import './bootstrap';
import 'flowbite';
import '../css/app.css';
import { createRoot } from 'react-dom/client';
import { Example } from './components/Example';
import HoverDevCards from './components/HoverDevCards';



const container = document.getElementById('react-tabs');
const container2 = document.getElementById('react-tabs2');





if (container) {
  const waitForBladeContent = setInterval(() => {
    const el = document.getElementById('blade-content');
    if (el) {
      clearInterval(waitForBladeContent);
      console.log('Blade content element found:', el);
      createRoot(container).render(<Example />);
    } else {
      console.log('Waiting for Blade content...');
    }
  }, 100); // revisa cada 100ms
}

if(container2){
  createRoot(container2).render(<HoverDevCards />);
}








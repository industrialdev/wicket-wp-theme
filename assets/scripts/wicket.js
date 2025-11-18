// Import styles
import '../styles/wicket.scss';

// Import libraries and components
import Alpine from 'alpinejs';
import datepicker from './components/datepicker';
import { disablePostTermLinks } from './post-terms-topics.js';

// Initialize AlpineJS
window.Alpine = Alpine;
Alpine.start();

// Initialize components
datepicker();
disablePostTermLinks();
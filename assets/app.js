// Importation des styles
import './styles/app.css';
import './styles/app.scss';

// Importation de React
import React from 'react';
import ReactDOM from 'react-dom';
import Map from './js/components/Map'; // Chemin vers votre composant Map

// Journal de vérification
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// Rendu du composant React
const mapElement = document.getElementById('map');
if (mapElement) {
    ReactDOM.render(<Map />, mapElement);
}

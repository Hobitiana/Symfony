import React from 'react';
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';

const Map = () => {
    console.log('Rendering Map Component');  // Vérifiez si ce log s'affiche dans la console
    return (
        <MapContainer
            center={[-18.8792, 47.5079]}
            zoom={6}
            style={{ height: '500px', width: '100%' }}
        >
            <TileLayer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            />
            <Marker position={[-18.8792, 47.5079]}>
                <Popup>Antananarivo, Madagascar</Popup>
            </Marker>
        </MapContainer>
    );
};

export default Map;

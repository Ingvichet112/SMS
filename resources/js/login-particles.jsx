import React from 'react';
import ReactDOM from 'react-dom/client';
import Particles from './components/Particles/Particles';

const rootElement = document.getElementById('particles-root');
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(
        <div style={{ width: '100%', height: '100%', position: 'absolute', top: 0, left: 0, zIndex: 0 }}>
            <Particles
                particleColors={["#ffffff"]}
                particleCount={600}
                particleSpread={10}
                speed={0.1}
                particleBaseSize={100}
                moveParticlesOnHover={true}
                alphaParticles={false}
                disableRotation={false}
            />
        </div>
    );
}

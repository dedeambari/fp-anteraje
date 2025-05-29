import React from 'react';
import ReactDOM from 'react-dom/client';
import App from '@/App';
import '@/index.css';
import { Toaster } from 'react-hot-toast';
import { BrowserRouter } from 'react-router-dom';
import UpdateProsess from '@/components/UpdateProsess';

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <BrowserRouter>
      <App />
      <Toaster
        position="top-center"
        toastOptions={{
          style: {
            borderRadius: "99999px",
          },
        }}
        containerStyle={{
          top: 80,
        }}
      />
        <UpdateProsess />

    </BrowserRouter>
  </React.StrictMode>
);
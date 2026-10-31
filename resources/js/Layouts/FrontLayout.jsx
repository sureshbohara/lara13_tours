import React from 'react';
import Header from '../Components/Shared/Header';
import Footer from '../Components/Shared/Footer';

export default function FrontLayout({ children }) {
    return (
        <div className="flex flex-col min-h-screen">
            <Header />
            <main className="flex-1">
                {children}
            </main>
            <Footer />
        </div>
    );
}
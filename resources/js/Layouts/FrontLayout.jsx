import React from 'react';
import Header from '../Components/Shared/Header';
import Footer from '../Components/Shared/Footer';
import MobileBottomNav from '../Components/Shared/MobileBottomNav';

export default function FrontLayout({ children }) {
    return (
        <div className="flex flex-col min-h-screen bg-white text-slate-800">
            <Header />
            <main className="flex-1 overflow-x-hidden pb-16 md:pb-0">
                {children}
            </main>
            <Footer />
            <MobileBottomNav />
        </div>
    );
}
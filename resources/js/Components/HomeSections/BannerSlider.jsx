import React, { useState, useEffect } from 'react';
import { Link } from '@inertiajs/react';

export default function BannerSlider({ banners }) {

    const [current, setCurrent] = useState(0);
    useEffect(() => {
        if (!banners || banners.length <= 1) return;
        const timer = setInterval(() => {
            setCurrent((prev) => (prev + 1) % banners.length);
        }, 6000);
        return () => clearInterval(timer);
    }, [banners]);

    if (!banners || banners.length === 0) {
        return null;
    }
    return (
        <section className="relative h-[600px] md:h-[700px] overflow-hidden bg-theme-dark">
            {banners.map((banner, index) => (
                <div
                    key={banner.id}
                    className={`absolute inset-0 transition-opacity duration-1000 ease-in-out ${index === current ? 'opacity-100 z-10' : 'opacity-0 z-0'}`}
                >
                 
                    <div className={`absolute inset-0 transition-transform duration-[8000ms] ease-linear ${index === current ? 'scale-110' : 'scale-100'}`}>
                        <img
                            src={`/images/${banner.image}`}
                            alt={banner.title}
                            className="w-full h-full object-cover"
                        />
                    </div>
                    
          
                    <div className="absolute inset-0 bg-gradient-to-r from-theme-dark/90 via-theme-dark/50 to-transparent"></div>
                    <div className="absolute inset-0 bg-gradient-to-t from-theme-dark/80 via-transparent to-transparent"></div>
                    
            
                    <div className="absolute inset-0 flex items-center z-20">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                            <div className="max-w-3xl">
                                
                                <h1 className="font-serif text-5xl md:text-7xl font-bold text-white mb-6 leading-tight drop-shadow-lg">
                                    {banner.title}
                                </h1>
                                
                                {banner.subtitle && (
                                    <p className="text-xl md:text-2xl text-gray-200 mb-8 font-light drop-shadow-md">
                                        {banner.subtitle}
                                    </p>
                                )}
                                
                                <div className="flex flex-wrap gap-4">
                                    <Link
                                        href="/packages"
                                        className="inline-flex items-center gap-2 px-8 py-4 bg-accent hover:bg-white hover:text-theme-dark text-white font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-400 transform hover:-translate-y-1"
                                    >
                                        Explore Packages <i className="fa-solid fa-arrow-right"></i>
                                    </Link>
                                    <Link
                                        href="/contact-us"
                                        className="inline-flex items-center gap-2 px-8 py-4 bg-white/10 hover:bg-white/20 text-white border border-white/30 font-semibold rounded-full backdrop-blur-sm transition-all duration-400"
                                    >
                                        Contact Us
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ))}

     
            {banners.length > 1 && (
                <div className="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-30">
                    {banners.map((_, index) => (
                        <button
                            key={index}
                            onClick={() => setCurrent(index)}
                            className={`h-1.5 rounded-full transition-all duration-500 ${index === current ? 'w-10 bg-accent' : 'w-4 bg-white/40 hover:bg-white/70'}`}
                            aria-label={`Go to slide ${index + 1}`}
                        ></button>
                    ))}
                </div>
            )}
            

        </section>
    );
}
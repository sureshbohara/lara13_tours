import React from 'react';
import { Link } from '@inertiajs/react';
import PackageCard from '../UI/PackageCard';

export default function PopularTours({ packages }) {
    if (!packages || packages.length === 0) return null;

    return (
        <section className="py-16 md:py-20 bg-slate-50">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex flex-col md:flex-row md:items-end md:justify-between mb-12 gap-4">
                    <div>
                        <span className="inline-block px-4 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
                            Most Popular
                        </span>
                        <h2 className="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">
                            Popular Tours
                        </h2>
                        <p className="text-slate-600">Our most booked and loved travel experiences</p>
                    </div>
                    <Link href="/packages" className="inline-flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                        View All Packages <i className="fa-solid fa-arrow-right"></i>
                    </Link>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {packages.map((pkg) => (
                        <PackageCard key={pkg.id} package={pkg} />
                    ))}
                </div>
            </div>
        </section>
    );
}
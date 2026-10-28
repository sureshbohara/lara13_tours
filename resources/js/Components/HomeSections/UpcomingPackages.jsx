import React from 'react';
import { Link } from '@inertiajs/react';
import { useCurrency } from '../../Hooks/useCurrency';
import { formatDate } from '../../Utils/helpers';

export default function UpcomingPackages({ packages }) {
    const { formatPrice } = useCurrency();

    if (!packages || packages.length === 0) return null;

    return (
        <section className="py-16 md:py-20 bg-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-12">
                    <span className="inline-block px-4 py-1.5 bg-green-50 text-green-600 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
                        Upcoming Dates
                    </span>
                    <h2 className="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3">
                        Upcoming Fixed Departures
                    </h2>
                    <p className="text-slate-600 max-w-2xl mx-auto">
                        Join our scheduled group tours with guaranteed departure dates
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {packages.slice(0, 4).map((pkg) => {
                        const nextDeparture = pkg.fixed_departures?.[0];
                        return (
                            <div key={pkg.id} className="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 border border-slate-100 hover:shadow-lg transition-all duration-300">
                                <div className="flex gap-4">
                                    <Link href={`/packages/${pkg.slug}`} className="flex-shrink-0">
                                        <img
                                            src={`/images/${pkg.image}`}
                                            alt={pkg.name}
                                            className="w-32 h-32 object-cover rounded-xl"
                                        />
                                    </Link>
                                    <div className="flex-1 min-w-0">
                                        <Link href={`/packages/${pkg.slug}`}>
                                            <h3 className="text-lg font-bold text-slate-900 mb-2 hover:text-blue-600 transition-colors line-clamp-1">
                                                {pkg.name}
                                            </h3>
                                        </Link>
                                        
                                        {nextDeparture ? (
                                            <div className="space-y-1 mb-3">
                                                <div className="flex items-center gap-2 text-sm text-slate-600">
                                                    <i className="fa-regular fa-calendar text-green-600"></i>
                                                    <span>{formatDate(nextDeparture.start_date)}</span>
                                                </div>
                                                <div className="flex items-center gap-2 text-sm text-slate-600">
                                                    <i className="fa-solid fa-users text-blue-600"></i>
                                                    <span>{nextDeparture.max_seats - nextDeparture.booked_seats} seats left</span>
                                                </div>
                                            </div>
                                        ) : (
                                            <p className="text-sm text-slate-500 mb-3">Contact us for available dates</p>
                                        )}

                                        <div className="flex items-center justify-between">
                                            <div className="text-xl font-bold text-blue-600">
                                                {formatPrice(pkg.trip_price)}
                                            </div>
                                            <Link
                                                href={`/packages/${pkg.slug}`}
                                                className="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                                            >
                                                Book Now
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
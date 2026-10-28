import React from 'react';
import { Link } from '@inertiajs/react';
import { useCurrency } from '../../Hooks/useCurrency';

export default function PackageCard({ package: pkg }) {
    const { formatPrice } = useCurrency();

    return (
        <div className="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <Link href={`/packages/${pkg.slug}`} className="block relative overflow-hidden">
                <img
                    src={`/images/${pkg.image}`}
                    alt={pkg.name}
                    className="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                
                {pkg.trip_previous_price && (
                    <span className="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg">
                        <i className="fa-solid fa-tag mr-1"></i>SALE
                    </span>
                )}
                
                {pkg.duration && (
                    <span className="absolute bottom-3 left-3 bg-white/95 backdrop-blur text-slate-900 text-xs font-semibold px-3 py-1.5 rounded-full shadow-md">
                        <i className="fa-regular fa-clock mr-1 text-blue-600"></i>{pkg.duration}
                    </span>
                )}
            </Link>

            <div className="p-5">
                <Link href={`/packages/${pkg.slug}`}>
                    <h3 className="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-1">
                        {pkg.name}
                    </h3>
                </Link>

                <p className="text-sm text-slate-600 mb-4 line-clamp-2 min-h-[40px]">
                    {pkg.excerpt}
                </p>

                <div className="flex items-center gap-3 text-xs text-slate-500 mb-4">
                    {pkg.trip_grading && (
                        <span className="flex items-center gap-1">
                            <i className="fa-solid fa-mountain text-blue-600"></i> {pkg.trip_grading}
                        </span>
                    )}
                    {pkg.max_altitude && (
                        <span className="flex items-center gap-1">
                            <i className="fa-solid fa-arrow-up text-blue-600"></i> {pkg.max_altitude}
                        </span>
                    )}
                </div>

                <div className="flex items-center justify-between pt-4 border-t border-slate-100">
                    <div>
                        {pkg.trip_previous_price && (
                            <div className="text-xs text-slate-400 line-through">
                                {formatPrice(pkg.trip_previous_price)}
                            </div>
                        )}
                        <div className="text-xl font-bold text-blue-600">
                            {formatPrice(pkg.trip_price)}
                        </div>
                    </div>
                    <Link
                        href={`/packages/${pkg.slug}`}
                        className="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-600/20"
                    >
                        Details <i className="fa-solid fa-arrow-right ml-1 text-xs"></i>
                    </Link>
                </div>
            </div>
        </div>
    );
}
import React from 'react';
import { Link } from '@inertiajs/react';

export default function CategoryCard({ category }) {
    return (
        <Link href={`/packages?category=${category.id}`} className="group block relative overflow-hidden rounded-2xl aspect-[4/5] shadow-md hover:shadow-xl transition-all duration-300">
            <img
                src={`/images/${category.image}`}
                alt={category.name}
                className="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            
            <div className="absolute inset-0 flex flex-col justify-end p-5 text-white">
                <h3 className="text-lg font-bold mb-1 group-hover:text-blue-300 transition-colors">
                    {category.name}
                </h3>
                <div className="flex items-center gap-2 text-sm text-slate-200">
                    <span>{category.packages_count || 0} Tours</span>
                    <i className="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </div>
            </div>
        </Link>
    );
}
import React from 'react';
import CategoryCard from '../UI/CategoryCard';

export default function ToursCategory({ categories }) {
    if (!categories || categories.length === 0) return null;

    return (
        <section className="py-16 md:py-20 bg-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-12">
                    <span className="inline-block px-4 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
                        Explore Destinations
                    </span>
                    <h2 className="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3">
                        Popular Tour Categories
                    </h2>
                    <p className="text-slate-600 max-w-2xl mx-auto">
                        Choose from our carefully curated travel categories
                    </p>
                </div>

                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    {categories.map((category) => (
                        <CategoryCard key={category.id} category={category} />
                    ))}
                </div>
            </div>
        </section>
    );
}
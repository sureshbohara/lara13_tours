import React from 'react';

export default function ServiceSection({ services }) {
    if (!services || services.length === 0) return null;

    return (
        <section className="py-16 md:py-20 bg-slate-50">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-12">
                    <span className="inline-block px-4 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
                        What We Offer
                    </span>
                    <h2 className="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3">
                        Our Services
                    </h2>
                    <p className="text-slate-600 max-w-2xl mx-auto">
                        Comprehensive travel services tailored to your needs
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {services.map((service) => (
                        <div key={service.id} className="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 group border border-slate-100">
                            {service.icon && (
                                <div className="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-600/20">
                                    <i className={`${service.icon} text-2xl text-white`}></i>
                                </div>
                            )}
                            <h3 className="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                                {service.title}
                            </h3>
                            {service.short_content && (
                                <p className="text-slate-600 text-sm leading-relaxed line-clamp-3">
                                    {service.short_content}
                                </p>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
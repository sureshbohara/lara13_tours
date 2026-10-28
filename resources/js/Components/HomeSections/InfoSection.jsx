import React from 'react';

export default function InfoSection({ data }) {
    if (!data || !data.items || data.items.length === 0) return null;

    return (
        <section className="py-16 md:py-20 bg-gradient-to-br from-blue-600 to-blue-800 text-white relative overflow-hidden">
            <div className="absolute inset-0 opacity-10">
                <div className="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div className="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
            </div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div className="text-center mb-12">
                    <h2 className="text-3xl md:text-4xl font-extrabold mb-3">
                        {data.title || 'Why Choose Us'}
                    </h2>
                    {data.subtitle && (
                        <p className="text-blue-100 max-w-2xl mx-auto text-lg">
                            {data.subtitle}
                        </p>
                    )}
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {data.items.map((item, index) => (
                        <div key={index} className="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            {item.icon && (
                                <div className="w-14 h-14 bg-white rounded-xl flex items-center justify-center mb-4 shadow-lg">
                                    <i className={`${item.icon} text-2xl text-blue-600`}></i>
                                </div>
                            )}
                            <h3 className="text-xl font-bold mb-2">{item.title}</h3>
                            <p className="text-blue-100 text-sm leading-relaxed">{item.content}</p>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
import React from 'react';

export default function ReviewSection({ reviews }) {
    if (!reviews || reviews.length === 0) return null;

    return (
        <section className="py-16 md:py-20 bg-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-12">
                    <span className="inline-block px-4 py-1.5 bg-yellow-50 text-yellow-600 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
                        Testimonials
                    </span>
                    <h2 className="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3">
                        What Our Travelers Say
                    </h2>
                    <p className="text-slate-600 max-w-2xl mx-auto">
                        Real experiences from our valued customers
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {reviews.map((review) => (
                        <div key={review.id} className="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 border border-slate-100 hover:shadow-lg transition-all duration-300">
                            <div className="flex items-center gap-1 mb-4">
                                {[...Array(5)].map((_, i) => (
                                    <i
                                        key={i}
                                        className={`fa-solid fa-star text-sm ${i < (review.rating || 5) ? 'text-yellow-400' : 'text-slate-200'}`}
                                    ></i>
                                ))}
                            </div>
                            
                            <p className="text-slate-700 text-sm leading-relaxed mb-5 italic">
                                "{review.message || review.content}"
                            </p>

                            <div className="flex items-center gap-3 pt-4 border-t border-slate-100">
                                <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {(review.name || 'U').charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <h4 className="font-bold text-slate-900">{review.name}</h4>
                                    {review.designation && (
                                        <p className="text-xs text-slate-500">{review.designation}</p>
                                    )}
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
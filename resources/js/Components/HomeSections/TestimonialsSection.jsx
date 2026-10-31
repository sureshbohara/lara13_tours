import React from 'react';
import ReviewCard from '../UI/ReviewCard';

export default function TestimonialsSection({ reviews }) {
    const displayReviews = reviews || [];
    
    if (displayReviews.length === 0) {
        return null;
    }

    return (
        <section className="testimonials-section section">
            <div className="container position-relative" style={{ zIndex: 2 }}>
                <div className="text-center mb-5">
                    <h2 className="section-title mt-2">MEMORIES FROM THE MOUNTAINS</h2>
                    <p className="section-subtitle">Real experiences from our SP Travel community</p>
                </div>
                
                <div className="row g-4">
                    {displayReviews.map((review) => (
                        <ReviewCard key={review.id} review={review} />
                    ))}
                </div>
            </div>
        </section>
    );
}
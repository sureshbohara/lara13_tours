import React from 'react';

export default function ReviewCard({ review }) {
    const renderStars = (rating) => {
        const stars = [];
        const numRating = Number(rating) || 5;
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(numRating)) {
                stars.push(<i key={i} className="bi bi-star-fill"></i>);
            } else if (i === Math.ceil(numRating) && !Number.isInteger(numRating)) {
                stars.push(<i key={i} className="bi bi-star-half"></i>);
            } else {
                stars.push(<i key={i} className="bi bi-star"></i>);
            }
        }
        return stars;
    };
    const avatarUrl = review.image_url 
        ? review.image_url 
        : (review.image ? `/${review.image}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(review.name || 'User')}&background=D4AF6A&color=fff`);

    return (
        <div className="col-lg-4 col-md-6">
            <div className="testimonial-card">
                <div className="d-flex justify-content-between align-items-start mb-3">
                    <i className="bi bi-quote" style={{ fontSize: '40px', color: 'var(--theme-accent)', opacity: 0.3 }}></i>
                    <div className="testimonial-rating" style={{ color: 'var(--theme-accent)', fontSize: '14px' }}>
                        {renderStars(review.rating)}
                    </div>
                </div>
                
                <blockquote className="testimonial-quote mb-4" style={{ fontStyle: 'italic', color: 'var(--text-main)', fontSize: '15px', lineHeight: 1.8, margin: 0 }}>
                    "{review.comment || review.review}"
                </blockquote>
                
                <div className="testimonial-author d-flex align-items-center gap-3 mt-auto pt-3" style={{ borderTop: '1px solid rgba(26, 43, 76, 0.1)' }}>
                    <img 
                        src={avatarUrl} 
                        alt={review.name} 
                        className="author-avatar" 
                        style={{ width: '50px', height: '50px', borderRadius: '50%', objectFit: 'cover', border: '2px solid var(--theme-accent)' }} 
                    />
                    <div className="author-info">
                        <h5 className="author-name mb-1" style={{ fontFamily: "'Poppins', sans-serif", fontSize: '16px', fontWeight: 700, color: 'var(--theme-primary)', margin: 0 }}>
                            {review.name}
                        </h5>
                        <p className="author-location mb-0" style={{ fontSize: '13px', color: 'var(--text-muted)', margin: 0, display: 'flex', alignItems: 'center', gap: '4px' }}>
                            <i className="bi bi-geo-alt-fill" style={{ color: 'var(--theme-accent)', fontSize: '12px' }}></i> {review.location || 'Nepal'}
                            <span className="badge bg-success bg-opacity-10 text-success ms-2" style={{ fontSize: '10px', fontWeight: 600, padding: '2px 6px', borderRadius: '4px' }}>
                                Verified Traveler
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}
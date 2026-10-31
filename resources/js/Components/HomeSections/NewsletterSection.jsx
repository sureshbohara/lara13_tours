import React, { useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function NewsletterSection() {
    const { props } = usePage();
    
    const { data, setData, post, processing, errors, reset } = useForm({
        email: ''
    });

    const [showSuccess, setShowSuccess] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        
        post('/newsletter/subscribe', {
            onSuccess: () => {
                setShowSuccess(true);
                reset(); 
                
                setTimeout(() => setShowSuccess(false), 5000);
            }
        });
    };

    return (
        <section className="newsletter-section section hidden-xs">
            <div className="container">
                <div className="row align-items-center">
                    <div className="col-lg-6 mb-4 mb-lg-0">
                        <h2 style={{ fontFamily: "'Playfair Display', serif", fontSize: '32px', fontWeight: 700, color: 'white', marginBottom: '15px' }}>
                            Ready for your next adventure?
                        </h2>
                        <p style={{ color: 'rgba(255,255,255,0.8)', fontSize: '16px', margin: 0 }}>
                            Subscribe to our newsletter for exclusive deals and travel tips.
                        </p>
                    </div>
                    
                    <div className="col-lg-6">
               
                        {showSuccess && (
                            <div className="alert alert-success mb-3" style={{ borderRadius: '8px', border: 'none', background: 'rgba(45, 106, 79, 0.9)', color: 'white' }}>
                                <i className="bi bi-check-circle-fill me-2"></i>
                                Thank you for subscribing!
                            </div>
                        )}

               
                        <form className="newsletter-form" style={{ display: 'flex' }} onSubmit={handleSubmit}>
                            <div style={{ flex: 1, position: 'relative' }}>
                                <input 
                                    type="email" 
                                    name="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="Enter your email address" 
                                    disabled={processing}
                                    style={{ 
                                        width: '100%', 
                                        padding: '15px 25px', 
                                        border: errors.email ? '2px solid #dc3545' : 'none',
                                        borderRadius: '8px 0 0 8px',
                                        outline: 'none',
                                        fontFamily: "'Poppins', sans-serif",
                                        fontSize: '15px'
                                    }} 
                                />
                    
                                {errors.email && (
                                    <small style={{ color: '#ff6b6b', fontSize: '12px', position: 'absolute', bottom: '-20px', left: '10px' }}>
                                        {errors.email}
                                    </small>
                                )}
                            </div>
                            
                            <button 
                                type="submit" 
                                disabled={processing}
                                style={{ 
                                    background: processing ? 'var(--text-muted)' : 'var(--theme-accent)', 
                                    color: 'var(--theme-dark)', 
                                    border: 'none', 
                                    padding: '15px 35px', 
                                    fontFamily: "'Poppins', sans-serif",
                                    fontSize: '15px', 
                                    fontWeight: 700, 
                                    textTransform: 'uppercase', 
                                    letterSpacing: '0.5px', 
                                    cursor: processing ? 'not-allowed' : 'pointer', 
                                    transition: 'var(--transition)', 
                                    borderRadius: '0 8px 8px 0',
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '8px'
                                }}
                            >
                                {processing ? (
                                    <>
                                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Subscribing...
                                    </>
                                ) : (
                                    'Subscribe'
                                )}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    );
}
import React from 'react';
import { useForm } from '@inertiajs/react';
import { toast } from 'react-hot-toast';

export default function BookingModal({ pkg, show, onClose }) {
    const bookingForm = useForm({
        name: '', email: '', phone: '', number_of_people: 1, travel_date: '', message: '', fixed_departure_id: ''
    });

    const submitBooking = (e) => {
        e.preventDefault();
        bookingForm.post(`/tour/${pkg.slug}/booking`, {
            preserveScroll: true,
            onSuccess: () => {
                bookingForm.reset();
                onClose();
                toast.success('Your booking request has been submitted successfully! We will contact you shortly.');
            },
            onError: () => {
                toast.error('Please fix the errors in the booking form.');
            }
        });
    };

    if (!show) return null;

    return (
        <div className="booking-modal-overlay" style={{ position: 'fixed', top: 0, left: 0, right: 0, bottom: 0, background: 'rgba(15, 26, 46, 0.7)', zIndex: 9999, display: 'flex', alignItems: 'center', justifyContent: 'center', padding: '20px', backdropFilter: 'blur(4px)' }} onClick={onClose}>
            <div className="booking-modal-content" style={{ background: 'var(--bg-white)', borderRadius: '16px', width: '100%', maxWidth: '650px', overflowY: 'auto', padding: '32px', position: 'relative', boxShadow: '0 20px 60px rgba(0,0,0,0.3)' }} onClick={(e) => e.stopPropagation()}>
                
                <button type="button" className="btn-close" style={{ position: 'absolute', top: '20px', right: '20px', fontSize: '1.2rem', background: 'none', border: 'none', cursor: 'pointer', color: 'var(--text-muted)' }} onClick={onClose}>
                    <i className="bi bi-x-lg"></i>
                </button>
                
                <div className="text-center mb-4">
                    <div style={{ width: '60px', height: '60px', background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 15px' }}>
                        <i className="bi bi-calendar-check" style={{ fontSize: '28px', color: 'var(--theme-accent)' }}></i>
                    </div>
                    <h4 style={{ fontFamily: 'Poppins, sans-serif', fontWeight: 700, color: 'var(--theme-primary)', marginBottom: '8px' }}>Book Your Adventure</h4>
                </div>

                <form onSubmit={submitBooking}>
                    <div className="row g-3">
                        <div className="col-12">
                            <label className="form-label small fw-bold">Full Name</label>
                            <input type="text" className={`form-control ${bookingForm.errors.name ? 'is-invalid' : ''}`} value={bookingForm.data.name} onChange={e => bookingForm.setData('name', e.target.value)} placeholder="John Doe" required style={{ padding: '10px 14px', borderRadius: '8px' }} />
                            {bookingForm.errors.name && <div className="invalid-feedback">{bookingForm.errors.name}</div>}
                        </div>
                        <div className="col-md-6">
                            <label className="form-label small fw-bold">Email</label>
                            <input type="email" className={`form-control ${bookingForm.errors.email ? 'is-invalid' : ''}`} value={bookingForm.data.email} onChange={e => bookingForm.setData('email', e.target.value)} placeholder="john@example.com" required style={{ padding: '10px 14px', borderRadius: '8px' }} />
                            {bookingForm.errors.email && <div className="invalid-feedback">{bookingForm.errors.email}</div>}
                        </div>
                        <div className="col-md-6">
                            <label className="form-label small fw-bold">Phone / WhatsApp</label>
                            <input type="text" className={`form-control ${bookingForm.errors.phone ? 'is-invalid' : ''}`} value={bookingForm.data.phone} onChange={e => bookingForm.setData('phone', e.target.value)} placeholder="+977 98XXXXXXXX" required style={{ padding: '10px 14px', borderRadius: '8px' }} />
                            {bookingForm.errors.phone && <div className="invalid-feedback">{bookingForm.errors.phone}</div>}
                        </div>
                        <div className="col-md-6">
                            <label className="form-label small fw-bold">No. of People</label>
                            <input type="number" className="form-control" min="1" value={bookingForm.data.number_of_people} onChange={e => bookingForm.setData('number_of_people', e.target.value)} required style={{ padding: '10px 14px', borderRadius: '8px' }} />
                        </div>
                        <div className="col-md-6">
                            <label className="form-label small fw-bold">Travel Date</label>
                            <input type="date" className="form-control" value={bookingForm.data.travel_date} onChange={e => bookingForm.setData('travel_date', e.target.value)} style={{ padding: '10px 14px', borderRadius: '8px' }} />
                        </div>
                        <div className="col-12">
                            <label className="form-label small fw-bold">Message (Optional)</label>
                            <textarea className="form-control" rows="3" value={bookingForm.data.message} onChange={e => bookingForm.setData('message', e.target.value)} placeholder="Any special requirements, dietary needs, or questions?" style={{ padding: '10px 14px', borderRadius: '8px' }}></textarea>
                        </div>
                        <div className="col-12 mt-4">
                            <button type="submit" className="btn btn-solid w-100" disabled={bookingForm.processing} style={{ padding: '14px', fontSize: '1rem' }}>
                                {bookingForm.processing ? (
                                    <><span className="spinner-border spinner-border-sm me-2"></span> Submitting...</>
                                ) : (
                                    <><i className="bi bi-send me-2"></i> Submit Booking Request</>
                                )}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
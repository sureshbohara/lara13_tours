import React from 'react';
import { Link } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function UpcomingPackagesSection({ packages }) {
    if (!packages || packages.length === 0) return null;

    const formatDateBadge = (dateString) => {
        if (!dateString) return { day: 'TBA', month: 'DATE' };
        const date = new Date(dateString);
        const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        return { day: date.getDate().toString().padStart(2, '0'), month: months[date.getMonth()] };
    };

    const formatFullDate = (dateString) => {
        if (!dateString) return 'Contact for Date';
        return new Date(dateString).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    };

    return (
        <section className="upcoming-section section">
            <div className="container">
                <div className="section-header text-center mb-5">
                    <h2 className="section-title">UPCOMING FIXED DEPARTURES</h2>
                    <p className="section-subtitle">Join our scheduled group departures. Limited seats available, book your Himalayan adventure today!</p>
                </div>
                <div className="row g-4">
                    {packages.map((pkg) => {
                        const imageUrl = pkg.image_url;
                        const nextDeparture = pkg.fixed_departures && pkg.fixed_departures.length > 0 ? pkg.fixed_departures[0] : null;
                        const dateBadge = formatDateBadge(nextDeparture?.start_date);
                        const seatsLeft = nextDeparture ? (nextDeparture.max_seats || 15) - (nextDeparture.booked_seats || 0) : 0;

                        return (
                            <div className="col-lg-6" key={pkg.id}>
                                <Link href={route('package.details', { slug: pkg.slug })} className="text-decoration-none">
                                    <div className="upcoming-package-card">
                                        <div className="upcoming-image-wrapper">
                                            <img src={imageUrl} alt={pkg.name} />
                                            <div className="departure-badge">
                                                <span className="day">{dateBadge.day}</span>
                                                <span className="month">{dateBadge.month}</span>
                                            </div>
                                        </div>
                                        <div className="upcoming-content">
                                            <div>
                                                <h4 className="upcoming-title">{pkg.name}</h4>
                                                <div className="upcoming-meta">
                                                    <span><i className="bi bi-calendar-event"></i> {formatFullDate(nextDeparture?.start_date)}</span>
                                                    <span><i className="bi bi-clock"></i> {pkg.duration || 'N/A'}</span>
                                                    <span><i className="bi bi-people"></i> {seatsLeft} Seats Left</span>
                                                </div>
                                            </div>
                                            <div className="upcoming-footer">
                                                <div className="upcoming-price">
                                                    {pkg.trip_price ? `$${Number(pkg.trip_price).toLocaleString()}` : 'On Request'}
                                                    <span>Per Person</span>
                                                </div>
                                                <span className="btn-upcoming">View Details <i className="bi bi-arrow-right"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
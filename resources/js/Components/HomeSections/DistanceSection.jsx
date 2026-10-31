import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function DistanceSection() {
    const { props } = usePage();
    const destinationCategory = props.destinationCategory || null;
    const destinations = destinationCategory?.children || [];

    if (!destinations || destinations.length === 0) return null;

    return (
        <section className="distance-section section">
            <div className="distance-wrapper">
                <div className="distance-left">
                    <div className="distance-content">
                        <span className="top-discount-label">Popular Destinations</span>
                        <h2 className="distance-title">Explore Amazing Destinations Across The Globe</h2>
                        <Link href={route('packages.category', { slug: destinationCategory.slug })} className="btn-book-distance">View All Packages</Link>
                    </div>
                </div>
                <div className="distance-right">
                    {destinations.map((dest) => (
                        <div className="distance-card-col" key={dest.id}>
                            <Link href={route('packages.category', { slug: dest.slug })} className="distance-card" style={{ textDecoration: 'none', color: 'inherit' }}>
                                <div className="distance-image">
                                    <img src={dest.image_url || '/default/noimage.png'} alt={dest.name} />
                                </div>
                                <div className="distance-card-content">
                                    <h4>{dest.name}</h4>
                                    <span className="discount-text">{dest.packages_count || 0} Packages</span>
                                </div>
                            </Link>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
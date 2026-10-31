import React from 'react';
import { Link } from '@inertiajs/react';

export default function PackageCard({ package: pkg }) {
    return (
            <div className="package-card">
               <Link href={`/tour/${pkg.slug}`} className="text-decoration-none text-dark">
                <div className="package-image-wrapper">
                    <img src={pkg.image_url} alt={pkg.name} className="package-image" />
                    {pkg.fixed_departures && pkg.fixed_departures.length > 0 && (
                        <span className="upcoming-badge">Upcoming</span>
                    )}
                </div>

                
                <div className="package-content">
                    <h4 className="package-title">{pkg.name}</h4>
                    
                    <div className="package-info">
                        {pkg.trip_grading && (
                            <div className="package-info-item">
                                <i className="bi bi-clipboard-data"></i>
                                <span><strong>Trip Grading :</strong> {pkg.trip_grading}</span>
                            </div>
                        )}
                        {pkg.best_season && (
                            <div className="package-info-item">
                                <i className="bi bi-snow"></i>
                                <span><strong>Best Season :</strong> {pkg.best_season}</span>
                            </div>
                        )}
                    </div>
                    
                    <div className="package-footer">
                        <div className="package-footer-item">
                            <i className="bi bi-clock"></i>
                            <span>Duration : {pkg.duration || 'N/A'}</span>
                        </div>
                        <div className="package-footer-item">
                            <i className="bi bi-tag"></i>
                            <span>
                                {pkg.trip_price 
                                    ? `$${Number(pkg.trip_price).toLocaleString()}` 
                                    : 'On Request'}
                            </span>
                        </div>
                    </div>
                </div>
            </Link>
            </div>
    );
}
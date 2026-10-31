
import React from 'react';
import PackageCard from '../UI/PackageCard';

export default function PackageSection({ packages }) {
    const displayPackages = packages || [];

    if (displayPackages.length === 0) {
        return null;
    }

    return (
        <section className="package-section section">
            <div className="container">
                <div className="section-header text-center mb-5">
                    <h2 className="section-title">
                        WHERE EVERY JOURNEY FEELS LIKE HOME
                    </h2>
                    <p className="section-subtitle">
                        Experience warm hospitality, expert guidance, and meaningful connections on every adventure with the SP Travel Team
                    </p>
                </div>

                <div className="row g-4">
                    {displayPackages.map((pkg) => (
                        <div className="col-lg-4 col-md-6" key={pkg.id}>
                            <PackageCard package={pkg} />
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

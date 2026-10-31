import React from 'react';

export default function AffiliationsSection({ teamMemberships }) {
    if (!teamMemberships || teamMemberships.length === 0) {
        return null;
    }

    return (
        <section className="affiliations-section section">
            <div className="container">
                <div className="text-center mb-5">
                    <h2 className="section-title" style={{ fontSize: '24px', marginBottom: '15px' }}>
                        OUR TRUSTED AFFILIATIONS & MEMBERSHIPS
                    </h2>
                    <p className="section-subtitle" style={{ maxWidth: '800px', margin: '0 auto' }}>
                        SP Travel and Tours is proudly registered and affiliated with Nepal's leading tourism and mountaineering authorities, ensuring safety, credibility, and professional standards.
                    </p>
                </div>
                
                <div className="row align-items-center justify-content-center">
                    <div className="col-lg-10">
                        <div className="row align-items-center justify-content-center g-4">
                            {teamMemberships.map((membership) => (
                                <div className="col-6 col-md-4 col-lg-2 text-center" key={membership.id}>
                                    <div className="affiliation-logo">
                                        <img 
                                            src={membership.image_url} 
                                            alt={membership.name || 'Affiliation Logo'} 
                                            style={{ maxHeight: '80px', width: 'auto', objectFit: 'contain' }}
                                        />
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
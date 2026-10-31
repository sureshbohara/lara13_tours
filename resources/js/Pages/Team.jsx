import React, { useState, useMemo } from 'react';
import { Head, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
export default function Team({ teamMembers }) {
    const { props } = usePage();
    const setting = props.setting || {};
    const breadcrumbImage = setting.breadcrumb_url;
    const [activeFilter, setActiveFilter] = useState('All');
    const filterOptions = useMemo(() => {
        const designations = teamMembers
            .map(member => member.designation)
            .filter(Boolean);
        return ['All', ...new Set(designations)];
    }, [teamMembers]);

    const filteredMembers = useMemo(() => {
        if (activeFilter === 'All') {
            return teamMembers;
        }
        return teamMembers.filter(member => member.designation === activeFilter);
    }, [teamMembers, activeFilter]);

    return (
        <>
            <Head>
                <title>{`Meet Our Team | ${setting.system_name || 'SP Travel and Tours'}`}</title>
                {setting.meta_description && <meta name="description" content={setting.meta_description} />}
                {setting.meta_keywords && <meta name="keywords" content={setting.meta_keywords} />}
            </Head>

         
            <PageHeader title="Meet Our Expert Team" subtitle="The passionate professionals behind your unforgettable Himalayan adventures." />

           
            <section className="section" style={{ background: 'var(--bg-soft)', padding: '60px 0' }}>
                <div className="container">
                    
              
                    <div className="d-flex flex-wrap justify-content-center gap-2 mb-5">
                        {filterOptions.map((option) => (
                            <button
                                key={option}
                                onClick={() => setActiveFilter(option)}
                                className="btn rounded-pill px-4 py-2"
                                style={{
                                    backgroundColor: activeFilter === option ? 'var(--theme-primary)' : 'transparent',
                                    color: activeFilter === option ? 'white' : 'var(--theme-primary)',
                                    border: `2px solid var(--theme-primary)`,
                                    fontWeight: '600',
                                    fontSize: '14px',
                                    transition: 'var(--transition)'
                                }}
                                onMouseEnter={(e) => {
                                    if (activeFilter !== option) {
                                        e.currentTarget.style.backgroundColor = 'rgba(26, 43, 76, 0.05)';
                                    }
                                }}
                                onMouseLeave={(e) => {
                                    if (activeFilter !== option) {
                                        e.currentTarget.style.backgroundColor = 'transparent';
                                    }
                                }}
                            >
                                {option}
                            </button>
                        ))}
                    </div>

                 
                    <div className="row g-4">
                        {filteredMembers && filteredMembers.length > 0 ? (
                            filteredMembers.map((member, index) => (
                                <div className="col-lg-4 col-md-6" key={member.id || index}>
                                    <div className="details-card" style={{ padding: '0', overflow: 'hidden', height: '100%', display: 'flex', flexDirection: 'column' }}>
                                        
                                    
                                        <div style={{ height: '300px', overflow: 'hidden' }}>
                                            <img 
                                                src={member.image_url} 
                                                alt={member.name}
                                                style={{ width: '100%', height: '100%', objectFit: 'cover', transition: 'transform 0.5s ease' }}
                                                onMouseEnter={(e) => e.target.style.transform = 'scale(1.05)'}
                                                onMouseLeave={(e) => e.target.style.transform = 'scale(1)'}
                                            />
                                        </div>
                                        
                                  
                                        <div style={{ padding: '25px', flex: 1, display: 'flex', flexDirection: 'column' }}>
                                            <h3 style={{ fontFamily: 'Playfair Display, serif', fontSize: '22px', fontWeight: '700', color: 'var(--theme-primary)', marginBottom: '5px' }}>
                                                {member.name}
                                            </h3>

                                            {member.email && (
                                                <p style={{ fontSize: '14px', color: 'var(--theme-accent)', fontWeight: '600', marginBottom: '15px' }}>
                                                    {member.email}
                                                </p>
                                            )}
                                            
                                            {member.bio && (
                                                <p style={{ fontSize: '14px', color: 'var(--text-muted)', lineHeight: '1.7', marginBottom: '20px', flex: 1 }}>
                                                    {member.bio}
                                                </p>
                                            )}

                                   
                                            <div style={{ display: 'flex', gap: '10px', marginTop: 'auto' }}>
                                                {member.facebook && (
                                                    <a href={member.facebook} target="_blank" rel="noopener noreferrer" style={{ width: '36px', height: '36px', borderRadius: '50%', background: 'var(--bg-soft)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--theme-primary)', transition: 'var(--transition)', textDecoration: 'none' }}
                                                    onMouseEnter={(e) => { e.currentTarget.style.background = 'var(--theme-primary)'; e.currentTarget.style.color = 'white'; }}
                                                    onMouseLeave={(e) => { e.currentTarget.style.background = 'var(--bg-soft)'; e.currentTarget.style.color = 'var(--theme-primary)'; }}>
                                                        <i className="bi bi-facebook"></i>
                                                    </a>
                                                )}
                                                {member.instagram && (
                                                    <a href={member.instagram} target="_blank" rel="noopener noreferrer" style={{ width: '36px', height: '36px', borderRadius: '50%', background: 'var(--bg-soft)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--theme-primary)', transition: 'var(--transition)', textDecoration: 'none' }}
                                                    onMouseEnter={(e) => { e.currentTarget.style.background = 'var(--theme-primary)'; e.currentTarget.style.color = 'white'; }}
                                                    onMouseLeave={(e) => { e.currentTarget.style.background = 'var(--bg-soft)'; e.currentTarget.style.color = 'var(--theme-primary)'; }}>
                                                        <i className="bi bi-instagram"></i>
                                                    </a>
                                                )}
                                                {member.youtube && (
                                                    <a href={member.youtube} target="_blank" rel="noopener noreferrer" style={{ width: '36px', height: '36px', borderRadius: '50%', background: 'var(--bg-soft)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--theme-primary)', transition: 'var(--transition)', textDecoration: 'none' }}
                                                    onMouseEnter={(e) => { e.currentTarget.style.background = 'var(--theme-primary)'; e.currentTarget.style.color = 'white'; }}
                                                    onMouseLeave={(e) => { e.currentTarget.style.background = 'var(--bg-soft)'; e.currentTarget.style.color = 'var(--theme-primary)'; }}>
                                                        <i className="bi bi-youtube"></i>
                                                    </a>
                                                )}
                                                {member.tiktok && (
                                                    <a href={member.tiktok} target="_blank" rel="noopener noreferrer" style={{ width: '36px', height: '36px', borderRadius: '50%', background: 'var(--bg-soft)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--theme-primary)', transition: 'var(--transition)', textDecoration: 'none' }}
                                                    onMouseEnter={(e) => { e.currentTarget.style.background = 'var(--theme-primary)'; e.currentTarget.style.color = 'white'; }}
                                                    onMouseLeave={(e) => { e.currentTarget.style.background = 'var(--bg-soft)'; e.currentTarget.style.color = 'var(--theme-primary)'; }}>
                                                        <i className="bi bi-tiktok"></i>
                                                    </a>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div className="col-12 text-center py-5">
                                <i className="bi bi-people" style={{ fontSize: '48px', color: 'var(--text-muted)', opacity: 0.3 }}></i>
                                <p style={{ marginTop: '20px', color: 'var(--text-muted)' }}>No team members available at the moment.</p>
                            </div>
                        )}
                    </div>
                </div>
            </section>
        </>
    );
}

Team.layout = (page) => <FrontLayout>{page}</FrontLayout>;
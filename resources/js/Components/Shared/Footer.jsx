import React, { useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function Footer() {
    const { props } = usePage();
    const teamMembers = props.teamMembers || [];
    const popularTreks = props.popularTreks || []; 
    const setting = props.setting || {};
    const cmsFooterPages = props.cmsFooterPages || []; 

    useEffect(() => {
        const backToTopBtn = document.getElementById('backToTop');
        const handleScroll = () => {
            if (window.scrollY > 300) backToTopBtn?.classList.add('show');
            else backToTopBtn?.classList.remove('show');
        };
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const scrollToTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

    return (
        <footer className="main-footer">
            <div className="container">
                <div className="row g-5">
                    <div className="col-lg-4 col-md-6">
                        <div className="footer-logo mb-4">
                            <Link href={route('home')}>
                                <img src={setting.logo_url} alt="SP TRAVEL Logo" className="logo-img-footer" />
                            </Link>
                        </div>
                        <p style={{ color: 'rgba(255,255,255,0.7)', lineHeight: 1.8, marginBottom: 25, fontSize: 15 }}>
                            SP Travel and Tours is a premier adventure company in Nepal. We provide world-class experiences with local expertise, ensuring your journey into the mountains is safe, memorable, and transformative.
                        </p>
                        <div className="footer-social d-flex gap-3 mb-4">
                            {setting.facebook && <a href={setting.facebook} target="_blank" rel="noopener noreferrer" className="social-icon"><i className="bi bi-facebook"></i></a>}
                            {setting.instagram && <a href={setting.instagram} target="_blank" rel="noopener noreferrer" className="social-icon"><i className="bi bi-instagram"></i></a>}
                            {setting.youtube && <a href={setting.youtube} target="_blank" rel="noopener noreferrer" className="social-icon"><i className="bi bi-youtube"></i></a>}
                        </div>
                    </div>

                    <div className="col-lg-2 col-md-6">
                        <h4 style={{ fontFamily: "'Poppins', sans-serif", fontSize: 16, fontWeight: 700, color: 'white', marginBottom: 25, textTransform: 'uppercase', letterSpacing: 1.5, position: 'relative', paddingBottom: 10 }}>
                            Quick Links<span style={{ position: 'absolute', bottom: 0, left: 0, width: 40, height: 2, background: 'var(--theme-accent)' }}></span>
                        </h4>
                        <ul className="footer-links" style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                            <li style={{ marginBottom: 12 }}><Link href={route('about')} style={{ display: 'inline-flex', alignItems: 'center', gap: 8 }}><i className="bi bi-chevron-right" style={{ fontSize: 12, color: 'var(--theme-accent)' }}></i> About Us</Link></li>
                            <li style={{ marginBottom: 12 }}><Link href={route('team')} style={{ display: 'inline-flex', alignItems: 'center', gap: 8 }}><i className="bi bi-chevron-right" style={{ fontSize: 12, color: 'var(--theme-accent)' }}></i> Our Guides</Link></li>
                            <li style={{ marginBottom: 12 }}><Link href={route('gallery')} style={{ display: 'inline-flex', alignItems: 'center', gap: 8 }}><i className="bi bi-chevron-right" style={{ fontSize: 12, color: 'var(--theme-accent)' }}></i> Trip Gallery</Link></li>
                            <li style={{ marginBottom: 12 }}><Link href={route('blog.index')} style={{ display: 'inline-flex', alignItems: 'center', gap: 8 }}><i className="bi bi-chevron-right" style={{ fontSize: 12, color: 'var(--theme-accent)' }}></i> Travel Blog</Link></li>
                            <li style={{ marginBottom: 12 }}><Link href={route('faqs')} style={{ display: 'inline-flex', alignItems: 'center', gap: 8 }}><i className="bi bi-chevron-right" style={{ fontSize: 12, color: 'var(--theme-accent)' }}></i> FAQs</Link></li>
                        </ul>
                    </div>

                    <div className="col-lg-3 col-md-6">
                        <h4 style={{ fontFamily: "'Poppins', sans-serif", fontSize: 16, fontWeight: 700, color: 'white', marginBottom: 25, textTransform: 'uppercase', letterSpacing: 1.5, position: 'relative', paddingBottom: 10 }}>
                            Popular Treks<span style={{ position: 'absolute', bottom: 0, left: 0, width: 40, height: 2, background: 'var(--theme-accent)' }}></span>
                        </h4>
                        <ul className="footer-links" style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                            {popularTreks.map((trek) => (
                                <li key={trek.id} style={{ marginBottom: 12 }}>
                                    <Link href={route('package.details', { slug: trek.slug })} style={{ display: 'inline-flex', alignItems: 'center', gap: 8 }}>
                                        <i className="bi bi-chevron-right" style={{ fontSize: 12, color: 'var(--theme-accent)' }}></i> {trek.name}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>

                    <div className="col-lg-3 col-md-6">
                        <h4 style={{ fontFamily: "'Poppins', sans-serif", fontSize: 16, fontWeight: 700, color: 'white', marginBottom: 25, textTransform: 'uppercase', letterSpacing: 1.5, position: 'relative', paddingBottom: 10 }}>
                            Contact Info<span style={{ position: 'absolute', bottom: 0, left: 0, width: 40, height: 2, background: 'var(--theme-accent)' }}></span>
                        </h4>
                        <ul className="footer-contact" style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                            <li style={{ marginBottom: 20, display: 'flex', gap: 15, alignItems: 'flex-start' }}>
                                <div style={{ width: 36, height: 36, background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}><i className="bi bi-geo-alt-fill" style={{ color: 'var(--theme-accent)', fontSize: 18 }}></i></div>
                                <div><span style={{ color: 'rgba(255,255,255,0.9)', display: 'block', fontSize: 14, lineHeight: 1.6, fontWeight: 500 }} dangerouslySetInnerHTML={{ __html: setting.address || 'Kathmandu, Nepal' }}></span></div>
                            </li>
                            <li style={{ marginBottom: 20, display: 'flex', gap: 15, alignItems: 'center' }}>
                                <div style={{ width: 36, height: 36, background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}><i className="bi bi-telephone-fill" style={{ color: 'var(--theme-accent)', fontSize: 16 }}></i></div>
                                <a href={`tel:${setting.phone}`} style={{ color: 'rgba(255,255,255,0.9)', textDecoration: 'none', fontSize: 14, fontWeight: 500 }}>{setting.phone || '+977 9849352533'}</a>
                            </li>
                            <li style={{ marginBottom: 20, display: 'flex', gap: 15, alignItems: 'center' }}>
                                <div style={{ width: 36, height: 36, background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}><i className="bi bi-envelope-fill" style={{ color: 'var(--theme-accent)', fontSize: 16 }}></i></div>
                                <a href={`mailto:${setting.email}`} style={{ color: 'rgba(255,255,255,0.9)', textDecoration: 'none', fontSize: 14, fontWeight: 500 }}>{setting.email || 'info@sptravel.com'}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                {teamMembers.length > 0 && (
                    <div className="row mt-5 pt-4" style={{ borderTop: '1px solid rgba(255,255,255,0.1)' }}>
                        <div className="col-12">
                            <h4 style={{ fontFamily: "'Poppins', sans-serif", fontSize: 16, fontWeight: 600, color: 'white', marginBottom: 25, textTransform: 'uppercase', letterSpacing: 1, display: 'flex', alignItems: 'center', gap: 10 }}>
                                <i className="bi bi-people-fill" style={{ color: 'var(--theme-accent)' }}></i> Speak with our worldwide representatives
                            </h4>
                            <div className="row g-3">
                                {teamMembers.map((member) => (
                                    <div className="col-6 col-md-3" key={member.id}>
                                        <div className="representative-card">
                                            <div style={{ width: 50, height: 50, borderRadius: '50%', margin: '0 auto 12px', display: 'flex', alignItems: 'center', justifyContent: 'center', overflow: 'hidden', border: '2px solid var(--theme-accent)' }}>
                                                <img src={member.image_url} alt={member.name} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                            </div>
                                            <h5 style={{ fontFamily: "'Poppins', sans-serif", fontSize: 14, fontWeight: 700, color: 'white', marginBottom: 4, textAlign: 'center' }}>{member.name}</h5>
                                            <p style={{ color: 'var(--theme-accent)', fontSize: 12, margin: 0, fontWeight: 600, textTransform: 'uppercase', letterSpacing: 0.5, textAlign: 'center' }}>{member.address || 'Team Member'}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                <div className="row mt-5 pt-4" style={{ borderTop: '1px solid rgba(255,255,255,0.1)' }}>
                    <div className="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: 14, margin: 0 }}>© 2007-{new Date().getFullYear()} SP Travel and Tours. All rights reserved. Developed by Suresh Bishara</p>
                    </div>
                    <div className="col-md-6 text-center text-md-end">
                       <ul className="footer-bottom-links" style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', gap: 25, justifyContent: 'center', flexWrap: 'wrap' }}>
                            {cmsFooterPages.map((page) => (
                                <li key={page.id}>
                                    <Link href={route('cms.page', { slug: page.slug })}>{page.title}</Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>
            <button id="backToTop" onClick={scrollToTop}><i className="bi bi-arrow-up" style={{ fontSize: 20, fontWeight: 'bold' }}></i></button>
        </footer>
    );
}
import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { route } from 'ziggy-js';
import MobileMenu from './MobileMenu'; 

export default function Header() {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const { props } = usePage();
    const setting = props.setting || {};
    const megaMenuCategories = props.megaMenuCategories || [];
    const cmsMenuPages = props.cmsMenuPages || [];
    const logoSrc = setting.logo_url ? setting.logo_url : '/default/logo.png';

    return (
        <div className="header-wrapper">
            <div className="top-bar">
                <div className="container">
                    <div className="top-bar-inner">
                        <div className="top-contact hidden-xs">
                            <div className="icon-circle"><i className="bi bi-telephone-fill"></i></div>
                            <div>
                                <span className="contact-label">For Further Inquires:</span>
                                <a href={`tel:${setting.phone || '+977123456789'}`} className="contact-text">{setting.phone || '+01 (977) 2599 12'}</a>
                            </div>
                        </div>
                        <div className="logo-center">
                            <Link href={route('home')}>
                                <img src={logoSrc} alt={`${setting.system_name || 'SP TRAVEL'} Logo`} className="logo-img" />
                            </Link>
                        </div>

                       
                        <button 
                            className="mobile-toggle visible-xs" 
                            aria-label="Toggle Menu" 
                            onClick={() => setIsMenuOpen(!isMenuOpen)}
                        >
                            <i className={`bi ${isMenuOpen ? 'bi-x-lg' : 'bi-list'}`}></i>
                        </button>

                        <div className="social-icons hidden-xs">
                            {setting.facebook && <a href={setting.facebook} target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i className="bi bi-facebook"></i></a>}
                            {setting.instagram && <a href={setting.instagram} target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i className="bi bi-instagram"></i></a>}
                            {setting.youtube && <a href={setting.youtube} target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i className="bi bi-youtube"></i></a>}
                            {setting.twitter && <a href={setting.google} target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i className="bi bi-google"></i></a>}
                            {setting.twitter && <a href={setting.twitter} target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i className="bi bi-twitter"></i></a>}
                        </div>
                    </div>
                </div>
            </div>

            <div className="main-nav hidden-xs">
                <div className="container">
                    <div className="nav-inner">
                        <nav id="navMenu">
                            <ul className="nav-menu-list">
                                <li className="dropdown">
                                    <a className="nav-link dropdown-toggle" href="#" role="button">Company Info <i className="bi bi-chevron-down"></i></a>
                                    <ul className="dropdown-menu dropdown-menu-custom">
                                        <li><Link className="dropdown-item" href={route('about')}>About Us</Link></li>
                                        <li><Link className="dropdown-item" href={route('team')}>Meet Our Guides</Link></li>
                                        <li><Link className="dropdown-item" href={route('gallery')}>Trip Gallery</Link></li>
                                        <li><Link className="dropdown-item" href={route('blog.index')}>Travel Blog</Link></li>
                                        <li><Link className="dropdown-item" href={route('faqs')}>Trip FAQs</Link></li>
                                        {cmsMenuPages.map((page) => (
                                            <li key={page.id}>
                                                <Link className="dropdown-item" href={route('cms.page', { slug: page.slug })}>{page.title}</Link>
                                            </li>
                                        ))}
                                    </ul>
                                </li>

                                {megaMenuCategories.map((category) => {
                                    const [activeChild, setActiveChild] = useState(category.children?.[0] || null);
                                    return (
                                        <li key={category.id} className="dropdown has-mega-menu">
                                            <a className="nav-link dropdown-toggle" href="#" role="button">{category.name} <i className="bi bi-chevron-down"></i></a>
                                            <div className="dropdown-menu mega-menu">
                                                <div className="row">
                                                    <div className="col-lg-4 col-md-5">
                                                        <h6 className="mega-section-title"><i className="bi bi-signpost-split"></i> {category.name} Regions/Types</h6>
                                                        <ul className="mega-menu-list">
                                                            {category.children.map((child) => (
                                                                <li key={child.id} onMouseEnter={() => setActiveChild(child)} style={{ backgroundColor: activeChild?.id === child.id ? 'var(--bg-soft)' : 'transparent', transition: 'all 0.2s ease' }}>
                                                                    <Link href={route('packages.category', { slug: child.slug })}><i className="bi bi-geo-alt"></i> {child.name}</Link>
                                                                </li>
                                                            ))}
                                                        </ul>
                                                    </div>
                                                    <div className="col-lg-8 col-md-7 mega-packages-col">
                                                        <h6 className="mega-section-title"><i className="bi bi-star-fill"></i> Popular {activeChild?.name || category.name} Packages</h6>
                                                        <div className="row">
                                                            {activeChild && activeChild.packages && activeChild.packages.length > 0 ? (
                                                                activeChild.packages.map((pkg) => (
                                                                    <div key={pkg.id} className="col-md-6 mb-3">
                                                                        <Link href={route('package.details', { slug: pkg.slug })} className="mini-package-card">
                                                                            <img src={`${pkg.image}`} alt={pkg.name} />
                                                                            <div className="mini-package-info">
                                                                                <h6>{pkg.name}</h6>
                                                                                <div className="mini-package-meta">
                                                                                    <span><i className="bi bi-clock"></i> {pkg.duration} Days</span>
                                                                                    <span><i className="bi bi-signpost-2"></i> {pkg.trip_grading}</span>
                                                                                </div>
                                                                                <div className="mini-package-price">
                                                                                    {pkg.trip_previous_price && <span>${Number(pkg.trip_previous_price).toLocaleString()}</span>}
                                                                                    ${Number(pkg.trip_price).toLocaleString()}
                                                                                </div>
                                                                            </div>
                                                                        </Link>
                                                                    </div>
                                                                ))
                                                            ) : (
                                                                <div className="col-12"><p className="text-muted small p-3 text-center">No packages available for this category yet.</p></div>
                                                            )}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    );
                                })}
                                <li><Link className="nav-link" href={route('contact')}>Contact Us</Link></li>
                            </ul>
                        </nav>
                        <Link href={route('customize.trip')} className="btn-book d-none d-md-block">Customize Trip</Link>
                    </div>
                </div>
            </div>

           
            <MobileMenu 
                isOpen={isMenuOpen} 
                onClose={() => setIsMenuOpen(false)} 
                megaMenuCategories={megaMenuCategories}
                cmsMenuPages={cmsMenuPages}
                setting={setting}
            />
        </div>
    );
}
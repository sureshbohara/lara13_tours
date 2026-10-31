import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function MobileMenu({ isOpen, onClose, megaMenuCategories, cmsMenuPages, setting }) {
    const [openAccordion, setOpenAccordion] = useState(null);
    const toggleAccordion = (id) => {
        setOpenAccordion(openAccordion === id ? null : id);
    };

    if (!isOpen) return null;
    return (
        <>
            <div 
                className="offcanvas-backdrop fade show" 
                style={{ zIndex: 111110 }}
                onClick={onClose}
            ></div>
            
            <div className={`offcanvas offcanvas-end show`} tabIndex="-1" style={{ zIndex: 111111 }}>
                <div className="offcanvas-header">
                    <h5 className="offcanvas-title">Menu</h5>
                    <button type="button" className="btn-close btn-close-white" onClick={onClose}></button>
                </div>
                
                <div className="offcanvas-body">
                    <div className="offcanvas-nav">
                        <div className="accordion" id="offcanvasAccordion">
                            
                  
                            {megaMenuCategories && megaMenuCategories.map((category, catIndex) => (
                                <div className="accordion-item" key={category.id}>
                                    <h2 className="accordion-header">
                                        <button 
                                            className={`accordion-button ${openAccordion === `cat-${catIndex}` ? '' : 'collapsed'}`} 
                                            type="button" 
                                            onClick={() => toggleAccordion(`cat-${catIndex}`)}
                                        >
                                            {category.name}
                                        </button>
                                    </h2>
                                    {openAccordion === `cat-${catIndex}` && (
                                        <div className="accordion-collapse show">
                                            <div className="accordion-body">
                                                <ul>
                                                    {category.children.map((child, childIndex) => (
                                                        <React.Fragment key={child.id}>
                                                            {childIndex === 0 && (
                                                                <li><h4>{category.name} Regions/Types</h4></li>
                                                            )}
                                                            <li>
                                                                <Link href={route('packages.category', { slug: child.slug })} onClick={onClose}>
                                                                    {child.name}
                                                                </Link>
                                                            </li>
                                                        </React.Fragment>
                                                    ))}
                                                </ul>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            ))}

                      
                            <div className="accordion-item">
                                <h2 className="accordion-header">
                                    <button 
                                        className={`accordion-button ${openAccordion === 'company' ? '' : 'collapsed'}`} 
                                        type="button" 
                                        onClick={() => toggleAccordion('company')}
                                    >
                                        Company Info
                                    </button>
                                </h2>
                                {openAccordion === 'company' && (
                                    <div className="accordion-collapse show">
                                        <div className="accordion-body">
                                            <ul>
                                                <li><Link href={route('about')} onClick={onClose}>About Us</Link></li>
                                                <li><Link href={route('team')} onClick={onClose}>Meet Our Guides</Link></li>
                                                <li><Link href={route('gallery')} onClick={onClose}>Trip Gallery</Link></li>
                                                <li><Link href={route('blog.index')} onClick={onClose}>Travel Blog</Link></li>
                                                <li><Link href={route('faqs')} onClick={onClose}>FAQs</Link></li>
                                                <li><Link href={route('contact')} onClick={onClose}>Contact Us</Link></li>
                                                {cmsMenuPages && cmsMenuPages.map((page) => (
                                                    <li key={page.id}>
                                                        <Link href={route('cms.page', { slug: page.slug })} onClick={onClose}>
                                                            {page.title}
                                                        </Link>
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                    
              
                    <div className="p-4 border-top mt-auto">
                        <Link href={route('customize.trip')} className="btn btn-solid w-100 text-center" onClick={onClose} style={{ padding: '12px', borderRadius: '8px' }}>
                            Customize Trip
                        </Link>
                    </div>
                </div>
            </div>
        </>
    );
}
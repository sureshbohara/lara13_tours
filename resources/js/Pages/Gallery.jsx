import React, { useState } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
import Lightbox from 'yet-another-react-lightbox';
import Zoom from 'yet-another-react-lightbox/plugins/zoom';
import Download from 'yet-another-react-lightbox/plugins/download';
import 'yet-another-react-lightbox/styles.css';

export default function Gallery({ images }) {
    const { props } = usePage();
    const setting = props.setting || {};
    const breadcrumbImage = setting.breadcrumb_url;

    const [isOpen, setIsOpen] = useState(false);
    const [currentIndex, setCurrentIndex] = useState(0);

    const lightboxSlides = (images.data || []).map(img => ({
        src: img.image_url,
        alt: img.alt || img.name || 'Gallery Image',
        title: img.name
    }));

    const openLightbox = (index) => {
        setCurrentIndex(index);
        setIsOpen(true);
    };

    return (
        <>
            <Head>
                <title>{`Gallery | ${setting.system_name || 'SP Travel and Tours'}`}</title>
                {setting.meta_description && <meta name="description" content={setting.meta_description} />}
                {setting.meta_keywords && <meta name="keywords" content={setting.meta_keywords} />}
            </Head>

      
            <PageHeader 
                title="Travel Gallery" 
                subtitle="Glimpses of our unforgettable journeys through the majestic Himalayas." 
            />

     
            <section className="section" style={{ background: 'var(--bg-soft)', padding: '40px 0' }}>
                <div className="container">
                    <div className="row g-4">
                       
                        {images && images.data && images.data.length > 0 ? (
                            images.data.map((image, index) => (
                                <div className="col-lg-4 col-md-6" key={image.id || index}>
                                    <div 
                                        className="gallery-item-card"
                                        style={{ 
                                            position: 'relative', 
                                            borderRadius: 'var(--radius)', 
                                            overflow: 'hidden', 
                                            cursor: 'pointer',
                                            boxShadow: 'var(--shadow-md)',
                                            transition: 'var(--transition)',
                                            height: '280px'
                                        }}
                                        onClick={() => openLightbox(index)}
                                        onMouseEnter={(e) => {
                                            e.currentTarget.style.transform = 'translateY(-5px)';
                                            e.currentTarget.style.boxShadow = '0 15px 35px rgba(26, 43, 76, 0.15)';
                                        }}
                                        onMouseLeave={(e) => {
                                            e.currentTarget.style.transform = 'translateY(0)';
                                            e.currentTarget.style.boxShadow = 'var(--shadow-md)';
                                        }}
                                    >
                                        <img 
                                            src={image.image_url} 
                                            alt={image.alt || image.name}
                                            style={{ 
                                                width: '100%', 
                                                height: '100%', 
                                                objectFit: 'cover',
                                                transition: 'transform 0.5s ease'
                                            }}
                                            onMouseEnter={(e) => e.target.style.transform = 'scale(1.1)'}
                                            onMouseLeave={(e) => e.target.style.transform = 'scale(1)'}
                                        />
                                        
                              
                                        <div style={{
                                            position: 'absolute',
                                            top: 0, left: 0, right: 0, bottom: 0,
                                            background: 'rgba(15, 26, 46, 0.4)',
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            opacity: 0,
                                            transition: 'var(--transition)'
                                        }}
                                        onMouseEnter={(e) => e.currentTarget.style.opacity = '1'}
                                        onMouseLeave={(e) => e.currentTarget.style.opacity = '0'}
                                        >
                                            <div style={{ 
                                                width: '50px', height: '50px', 
                                                background: 'var(--theme-accent)', 
                                                borderRadius: '50%', 
                                                display: 'flex', alignItems: 'center', justifyContent: 'center' 
                                            }}>
                                                <i className="bi bi-arrows-fullscreen" style={{ color: 'var(--theme-dark)', fontSize: '20px' }}></i>
                                            </div>
                                        </div>

                                 
                                        {image.name && (
                                            <div style={{
                                                position: 'absolute',
                                                bottom: 0, left: 0, right: 0,
                                                background: 'linear-gradient(to top, rgba(0,0,0,0.8), transparent)',
                                                padding: '20px 15px 15px',
                                                color: 'white',
                                                fontSize: '14px',
                                                fontWeight: '600'
                                            }}>
                                                {image.name}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div className="col-12 text-center py-5">
                                <i className="bi bi-images" style={{ fontSize: '48px', color: 'var(--text-muted)', opacity: 0.3 }}></i>
                                <p style={{ marginTop: '20px', color: 'var(--text-muted)' }}>No gallery images available at the moment.</p>
                            </div>
                        )}
                    </div>

                
                    {images && images.links && images.links.length > 3 && (
                        <div className="pagination-custom" style={{ marginTop: '50px', display: 'flex', justifyContent: 'center', gap: '8px', flexWrap: 'wrap' }}>
                            {images.links.map((link, index) => (
                                <Link 
                                    key={index}
                                    href={link.url || '#'}
                                    className="page-link" 
                                    style={{
                                        minWidth: '42px',
                                        height: '42px',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        borderRadius: '8px',
                                        border: '1px solid rgba(26, 43, 76, 0.15)',
                                        background: link.active ? 'var(--theme-accent)' : 'var(--bg-white)',
                                        color: link.active ? 'var(--theme-dark)' : 'var(--text-main)',
                                        cursor: link.url ? 'pointer' : 'not-allowed',
                                        transition: 'var(--transition)',
                                        textDecoration: 'none',
                                        padding: '0 12px',
                                        fontSize: '14px',
                                        fontWeight: '600'
                                    }}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </div>
                    )}
                </div>
            </section>

         
            <Lightbox
                open={isOpen}
                close={() => setIsOpen(false)}
                index={currentIndex}
                slides={lightboxSlides}
                plugins={[Zoom, Download]} 
                render={{
                    buttonPrev: () => null, 
                    buttonNext: () => null, 
                }}
            />
        </>
    );
}

Gallery.layout = (page) => <FrontLayout>{page}</FrontLayout>;